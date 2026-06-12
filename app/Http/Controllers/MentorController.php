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
            ? Produk::with('umkm')->where('mentor_id', $mentor->id)->latest()->get()
            : collect();

        $totalUmkm    = $umkmList->count();
        $totalUlasan  = $mentor ? $mentor->ulasanList()->count() : 0;
        $avgRating    = $mentor ? $mentor->avg_rating : 0;
        $statusMentor = $mentor->status ?? 'belum_daftar';

        return view('pages.mentor.dashboard', compact(
            'mentor', 'umkmList', 'totalUmkm', 'totalUlasan', 'avgRating', 'statusMentor'
        ));
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

    // Update pakai DB::table untuk bypass masalah dirty/accessor
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
            'foto'                   => $fotoPath,
            'updated_at'             => now(),
        ]);

        

    return redirect()->route('mentor.dashboard', ['#profil'])
                     ->with('success', 'Profil berhasil diperbarui.');
}
    }
