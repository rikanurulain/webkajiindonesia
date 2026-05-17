<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Produk;
use App\Models\Program; // Model program trainer

class UmkmDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. Ambil produk milik UMKM ini
        $myProducts = Produk::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();

        // 2. AMBIL PROGRAM YANG SUDAH DI-ACC ADMIN (Memakai scopePublished asli dari model Program)
        $availablePrograms = Program::published()->latest()->get(); 

        // 3. Ambil ID program yang sudah diikuti oleh UMKM ini
        $joinedProgramIds = $user->programs()->pluck('program_id')->toArray();

        // 4. Hitung statistik ringkas untuk widget counter atas
        $stats = [
            'total_produk'    => $myProducts->count(),
            'pending_produk'  => $myProducts->where('status', 'pending')->count(),
            'active_produk'   => $myProducts->where('status', 'approved')->count(),
            'program_diikuti' => count($joinedProgramIds) 
        ];

        return view('profile.dashboard-umkm', compact('user', 'myProducts', 'availablePrograms', 'joinedProgramIds', 'stats'));
    }

    // Fungsi saat UMKM klik tombol "Daftar"
    public function joinProgram($id)
    {
        $user = Auth::user();

        // Cek mencegah duplikasi data
        if (!$user->programs()->where('program_id', $id)->exists()) {
            $user->programs()->attach($id, ['status' => 'joined']);
        }

        return back()->with('success', 'Berhasil mendaftar program pelatihan!');
    }
}