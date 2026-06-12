<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Mentor;
use App\Models\Produk;

class MentorController extends Controller
{
    /**
     * Dashboard utama mentor — profil + daftar UMKM terhubung
     */
    public function index()
    {
        $user   = Auth::user();
        $mentor = Mentor::where('user_id', $user->id)->latest()->first();

        // UMKM (Produk) yang terhubung dengan mentor ini
        $umkmList = $mentor
            ? Produk::with('user')
                    ->where('mentor_id', $mentor->id)
                    ->latest()
                    ->get()
            : collect();

        // Statistik ringkas
        $totalUmkm    = $umkmList->count();
        $totalUlasan  = $mentor ? $mentor->ulasanList()->count() : 0;
        $avgRating    = $mentor ? $mentor->avg_rating           : 0;
        $statusMentor = $mentor->status ?? 'belum_daftar';

        return view('pages.mentor.dashboard', compact(
            'mentor',
            'umkmList',
            'totalUmkm',
            'totalUlasan',
            'avgRating',
            'statusMentor',
        ));
    }

    /**
     * Update profil mentor
     */
    public function updateProfil(Request $request)
    {
        $user   = Auth::user();
        $mentor = Mentor::where('user_id', $user->id)->firstOrFail();

        $request->validate([
            'nama'                   => 'required|string|max:255',
            'bio'                    => 'nullable|string|max:1000',
            'phone'                  => 'nullable|string|max:20',
            'spesialisasi'           => 'nullable|string|max:500',
            'displayed_spesialisasi' => 'nullable|string|max:255',
            'lokasi'                 => 'nullable|string|max:255',
            'foto'                   => 'nullable|image|max:2048',
        ]);

        // Update user name
        $user->name  = $request->nama;
        if ($request->filled('phone')) $user->phone = $request->phone;
        $user->save();

        // Update mentor
        $mentor->nama                   = $request->nama;
        $mentor->bio                    = $request->bio;
        $mentor->phone                  = $request->phone;
        $mentor->spesialisasi           = $request->spesialisasi;
        $mentor->displayed_spesialisasi = $request->displayed_spesialisasi;
        $mentor->lokasi                 = $request->lokasi;

        if ($request->hasFile('foto')) {
            if ($mentor->foto) Storage::disk('public')->delete($mentor->foto);
            $mentor->foto = $request->file('foto')->store('mentor/foto', 'public');
        }

        $mentor->save();

        return redirect()->route('mentor.dashboard', ['#profil'])
                         ->with('success', 'Profil berhasil diperbarui.');
    }
}
