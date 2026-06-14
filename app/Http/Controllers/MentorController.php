<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Mentor;
use App\Models\Produk;

class MentorController extends Controller
{
    public function index()
    {
        $user   = Auth::user();
        $mentor = Mentor::where('user_id', $user->id)->latest()->first();

        $umkmList = $mentor
        ? $mentor->produks()->with('user')->where('status', 'approved')->latest()->get()
        : collect();

    $totalUmkm    = $umkmList->count();
    $totalUlasan  = $mentor ? $mentor->ulasanList()->count() : 0;
    $avgRating    = $mentor ? $mentor->avg_rating : 0;
    $statusMentor = $mentor->status ?? 'belum_daftar';

        return view('pages.mentor.dashboard', compact(
            'mentor', 'umkmList', 'totalUmkm', 'totalUlasan', 'avgRating', 'statusMentor'
        ));
    }

    public function getProdukUmkm($produkId)
{
    $items = \App\Models\ProdukItem::where('produk_id', $produkId)
        ->orderByDesc('is_unggulan')
        ->orderBy('created_at')
        ->get()
        ->map(fn($item) => [
            'nama'        => $item->nama,
            'deskripsi'   => $item->deskripsi,
            'harga'       => $item->harga_format,
            'stok'        => $item->stok,
            'satuan'      => $item->satuan,
            'is_unggulan' => $item->is_unggulan,
            'foto'        => $item->foto ? asset('storage/' . $item->foto) : null,
        ]);

    return response()->json($items);
}

    public function updateProfil(Request $request)
{
    $user   = Auth::user();
    $mentor = Mentor::where('user_id', $user->id)->firstOrFail();

    $request->validate([
        'nama'                   => 'required|string|max:255',
        'bio'                    => 'nullable|string|max:1000',
        'phone'                  => 'nullable|string|max:20',
        'spesialisasi'           => 'nullable|string',
        'displayed_spesialisasi' => 'nullable|string|max:255',
        'lokasi'                 => 'nullable|string|max:255',
        'foto'                   => 'nullable|image|max:2048',
    ]);

    // Update user
    $user->name = $request->nama;
    if ($request->filled('phone')) $user->phone = $request->phone;
    $user->save();

    // Handle foto
    $fotoPath = $mentor->foto;
    if ($request->hasFile('foto')) {
        if ($mentor->foto) Storage::disk('public')->delete($mentor->foto);
        $fotoPath = $request->file('foto')->store('mentor/foto', 'public');
    }
    
    // Simpan sosmed
    $sosmed = null;
    if ($request->has('sosmed')) {
        $filtered = array_filter(
            $request->input('sosmed', []),
            fn($v) => trim($v) !== ''
        );
        $sosmed = empty($filtered) ? null : json_encode($filtered);
    }
    
    // Update pakai DB::table
    DB::table('mentor')
        ->where('id', $mentor->id)
        ->update([
            'nama'                   => $request->nama,
            'bio'                    => $request->bio,
            'phone'                  => $request->phone,
            'lokasi'                 => $request->lokasi,
            'displayed_spesialisasi' => $request->displayed_spesialisasi,
            'spesialisasi'           => json_encode(
                array_values(array_filter(array_map('trim', explode(',', $request->spesialisasi ?? ''))))
            ),
            'sosmed'                 => $sosmed,  // <-- tambah di sini
            'foto'                   => $fotoPath,
            'updated_at'             => now(),
        ]);

        

        return redirect()->route('mentor.dashboard')
                 ->with('success', 'Profil berhasil diperbarui.');
    }
  }