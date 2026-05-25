<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; 
use App\Models\Produk;
use App\Models\Program; // Model program trainer

class UmkmDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. Ambil produk milik UMKM ini LENGKAP dengan data relasi mentornya (FIXED)
        $myProducts = Produk::with('mentor')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

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

    // =========================================================
    // 🌟 FUNGSI UNTUK MENGHUBUNGKAN UMKM KE MENTOR
    // =========================================================
    public function pilihMentor($mentorId)
    {
        $user = Auth::user();

        // 1. Ambil data UMKM (produk) milik user yang sedang login
        $umkm = Produk::where('user_id', $user->id)->first();

        // 2. Validasi: Cek apakah user sudah punya akun UMKM
        if (!$umkm) {
            return redirect()->route('umkm.mentor.detail', $mentorId)->with('error', 'Anda harus mendaftarkan profil UMKM terlebih dahulu sebelum memilih mentor.');
        }
        
        // 3. Validasi: Cek apakah status UMKM sudah di-acc admin atau belum
        if ($umkm->status !== 'approved') {
            return redirect()->route('umkm.mentor.detail', $mentorId)->with('error', 'Profil UMKM Anda belum disetujui oleh admin. Tunggu persetujuan admin terlebih dahulu.');
        }

        // 4. Update kolom mentor_id di tabel produks
        $umkm->update([
            'mentor_id' => $mentorId
        ]);

        return redirect()->route('umkm.mentor.detail', $mentorId)->with('success', 'Berhasil terhubung dengan Mentor pendamping!');
    }

    // =========================================================
    // 🌟 TAMBAHAN BARU: MANAJEMEN EDIT & UPDATE PRODUK UMKM
    // =========================================================
    
    // 1. Menampilkan Halaman Form Edit
    public function editProduk($id)
    {
        // Cari produk berdasarkan ID dan pastikan milik user yang sedang login
        $product = Produk::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        
        return view('profile.edit-produk', compact('product'));
    }

    // 2. Memproses Perubahan Data (Form Submission)
    public function updateProduk(Request $request, $id)
    {
        // Pastikan keamanan data milik user terkait
        $product = Produk::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        // Validasi input data dari form edit
        $request->validate([
            'nama'        => 'required|string|max:255',
            'kategori'    => 'required',
            'deskripsi'   => 'required|string',
            'foto_produk' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
        ]);

        // Siapkan array data baru
        $data = [
            'nama'      => $request->nama,
            'kategori'  => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'status'    => 'pending', // Diubah kembali ke pending agar di-review ulang oleh admin
        ];

        // Jika user memasukkan berkas file foto produk baru
        if ($request->hasFile('foto_produk')) {
            // Bersihkan file foto lama dari folder biar storage local lapak laptopmu hemat space
            if ($product->foto_produk) {
                Storage::disk('public')->delete($product->foto_produk);
            }
            // Upload simpan file baru ke folder produk-pict di storage/app/public
            $data['foto_produk'] = $request->file('foto_produk')->store('produk-pict', 'public');
        }

        // Eksekusi update data ke baris database
        $product->update($data);

        return redirect()->route('dashboard-umkm')->with('success', 'Data produk berhasil diperbarui! Menunggu persetujuan ulang pihak admin.');
    }
}