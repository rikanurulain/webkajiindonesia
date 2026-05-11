<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use App\Models\ActivityLog;
use App\Models\Mentor;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit');
    }

    
public function update(Request $request)
{
    $user = Auth::user();

    // 1. Tambahkan 'username' di validasi
    $request->validate([
        'name'     => 'required|string|max:255',
        // alpha_dash memastikan username hanya huruf, angka, dash (-), dan underscore (_)
        'username' => 'required|string|alpha_dash|max:255|unique:users,username,' . $user->id,
        'phone'    => 'nullable|string|max:20',
        'address'  => 'nullable|string|max:500',
        'bio'      => 'nullable|string|max:500',
        'photo'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    // 2. Masukkan data username ke model
    $user->name     = $request->name;
    $user->username = strtolower($request->username); // Disimpan huruf kecil semua agar rapi
    $user->phone    = $request->phone;
    $user->address  = $request->address;
    $user->bio      = $request->bio;

    if ($request->hasFile('photo')) {
        // ... (kode upload foto tetap sama seperti sebelumnya)
        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }
        $path = $request->file('photo')->store('profile-photos', 'public');
        $user->profile_photo_path = $path;
        
        // Log Aktivitas Foto
        ActivityLog::create([
            'user_id'     => $user->id,
            'type'        => 'photo',
            'label'       => 'Ganti foto profil',
            'description' => 'Foto profil diperbarui',
            'ip_address'  => $request->ip(),
            'user_agent'  => $request->userAgent(),
            'is_success'  => true,
        ]);
    }

    $user->save();

    // Log Aktivitas Profil
    ActivityLog::create([
        'user_id'     => $user->id,
        'type'        => 'profile',
        'label'       => 'Update profil',
        'description' => 'Nama, Username, atau informasi lainnya diperbarui', // Update deskripsi
        'ip_address'  => $request->ip(),
        'user_agent'  => $request->userAgent(),
        'is_success'  => true,
    ]);

    return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui!');
}

    public function deletePhoto()
    {
        $user = Auth::user();

        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
            $user->profile_photo_path = null;
            $user->save();

            ActivityLog::create([
                'user_id'     => $user->id,
                'type'        => 'photo',
                'label'       => 'Hapus foto profil',
                'description' => 'Foto profil dihapus',
                'ip_address'  => request()->ip(),
                'user_agent'  => request()->userAgent(),
                'is_success'  => true,
            ]);
        }

        return redirect()->route('profile.edit')
            ->with('success', 'Foto profil berhasil dihapus.');
    }

    public function password()
    {
        return view('profile.password');
    }

    public function updatePhoto(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'photo' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    if ($request->hasFile('photo')) {
        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }
        $path = $request->file('photo')->store('profile-photos', 'public');
        $user->profile_photo_path = $path;
        $user->save();
    }

    return redirect()->route('profile')->with('success', 'Foto profil berhasil diperbarui!');
}

public function unsuspendPengguna(Request $request, User $user)
{
    $user->update(['suspended_at' => null]);

    if ($request->expectsJson()) {
        return response()->json(['message' => 'Pengguna berhasil diaktifkan kembali.']);
    }

    return back()->with('success', 'Pengguna berhasil diaktifkan kembali.');
}

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password'         => ['required', 'confirmed', Password::min(8)],
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors([
                'current_password' => 'Password saat ini tidak sesuai.',
            ]);
        }

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        ActivityLog::create([
            'user_id'     => Auth::id(),
            'type'        => 'password',
            'label'       => 'Ubah password',
            'description' => 'Password berhasil diperbarui',
            'ip_address'  => $request->ip(),
            'user_agent'  => $request->userAgent(),
            'is_success'  => true,
        ]);

        return back()->with('success', 'Password berhasil diubah!');
    }

    // =====================
// NOTIFIKASI
// =====================
public function notifications()
{
    return view('profile.notifications');
}

public function updateNotifications(Request $request)
{
    $user = Auth::user();

    $user->update([
        'notif_email_pelatihan'  => $request->has('notif_email_pelatihan')  ? 1 : 0,
        'notif_email_umkm'       => $request->has('notif_email_umkm')       ? 1 : 0,
        'notif_email_halal'      => $request->has('notif_email_halal')       ? 1 : 0,
        'notif_email_newsletter' => $request->has('notif_email_newsletter')  ? 1 : 0,
        'notif_browser'          => $request->has('notif_browser')           ? 1 : 0,
    ]);

    // Catat aktivitas
    ActivityLog::create([
        'user_id'     => $user->id,
        'type'        => 'profile',
        'label'       => 'Update pengaturan notifikasi',
        'description' => 'Preferensi notifikasi diperbarui',
        'ip_address'  => $request->ip(),
        'user_agent'  => $request->userAgent(),
        'is_success'  => true,
    ]);

    return back()->with('success', 'Pengaturan notifikasi berhasil disimpan!');
}

    // HALAMAN PROFIL UTAMA 
    public function index()
    {
        $user = Auth::user();
        // Mengambil log aktivitas terbaru untuk ditampilkan di profil
        $activities = ActivityLog::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('profile.index', compact('user', 'activities'));
    }

    public function daftarMentor(Request $request)
{
    $user = Auth::user();
    
    ActivityLog::create([
        'user_id'     => $user->id,
        'type'        => 'profile',
        'label'       => 'Pengajuan Trainer', 
        'description' => 'User mengajukan diri menjadi Trainer profesional',
        'ip_address'  => $request->ip(),
        'user_agent'  => $request->userAgent(),
        'is_success'  => true,
    ]);

    return back()->with('success', 'Pengajuan sebagai trainer telah dikirim!');
}
/**
 * Menampilkan halaman formulir persyaratan trainer
 */
public function showDaftarTrainer()
{
    // Mengambil data user yang sedang login
    $user = Auth::user();

    // Mengirim variabel $user ke halaman view
    return view('profile.daftar-trainer', compact('user'));
}

/**
 * Menyimpan data bio dan lokasi calon trainer
 */
public function simpanTrainer(Request $request)
{
    $user = Auth::user();

    // Validasi (Contoh sederhana, bisa diperketat)
    $request->validate([
        'academic_degree' => 'required|string',
        'ktp_scan' => 'required|image|max:2048',
        'bnsp_certificate' => 'required|mimes:pdf,jpg,png|max:2048',
        'white_bg_photo' => 'required|image|max:2048',
    ]);

    // Proses Upload File
    // Kita ambil data dari input form
    $data = $request->only(['academic_degree', 'nik', 'npwp', 'location', 'experience', 'bio']);
    $data['drive_link_documentation'] = $request->drive_link;

    // TAMBAHKAN BARIS INI: Set status pendaftaran menjadi pending
    $data['trainer_status'] = 'pending'; 

    if ($request->hasFile('ktp_scan')) {
        $data['ktp_scan'] = $request->file('ktp_scan')->store('trainer_docs', 'public');
    }
    if ($request->hasFile('bnsp_certificate')) {
        $data['bnsp_certificate'] = $request->file('bnsp_certificate')->store('trainer_docs', 'public');
    }
    if ($request->hasFile('white_bg_photo')) {
        $data['white_bg_photo'] = $request->file('white_bg_photo')->store('trainer_docs', 'public');
    }

    // Update data user yang sedang login
    $user->update($data);

    // Catat ke Log Aktivitas
    \App\Models\ActivityLog::create([
        'user_id'     => $user->id,
        'type'        => 'profile',
        'label'       => 'Menunggu Persetujuan Trainer',
        'description' => 'User melengkapi 13 persyaratan dan menunggu verifikasi admin',
        'ip_address'  => $request->ip(),
        'user_agent'  => $request->userAgent(),
        'is_success'  => true,
    ]);

    return redirect()->route('profile')->with('success', 'Persyaratan dikirim! Admin akan segera meninjau pengajuan Anda.');
}

// Show form daftar UMKM
public function showDaftarUmkm()
{
    return view('profile.daftar-umkm');
}

// Simpan pendaftaran UMKM
public function simpanUmkm(Request $request)
<<<<<<< HEAD
{
    // logika simpan data UMKM
}
=======
    {
    $request->validate([
        'nama' => 'required|string|max:255',
        'kategori' => 'required',
        'owner' => 'required',
        'foto' => 'required|image|max:2048', // Poster
        'foto_produk' => 'required|image|max:2048', // Produk Unggulan
        'deskripsi' => 'required',
        'alamat' => 'required',
        'kontak' => 'required|numeric',
    ]);

    // Proses Upload
    $pathPoster = $request->file('foto')->store('produk-pict', 'public');
    $pathProduk = $request->file('foto_produk')->store('produk-pict', 'public');

    \App\Models\Produk::create([
        'user_id' => auth()->id(),
        'nama' => $request->nama,
        'kategori' => $request->kategori,
        'owner' => $request->owner,
        'nib' => $request->nib,
        'id_tkm' => $request->id_tkm,
        'foto'        => basename($pathPoster), 
        'foto_produk' => basename($pathProduk), 
        'deskripsi' => $request->deskripsi,
        'alamat' => $request->alamat,
        'kontak' => $request->kontak,
        'status' => 'pending', 
    ]);

    return redirect()->route('profile')->with('success', 'Pendaftaran UMKM berhasil dikirim! Menunggu verifikasi Admin.');
    }
>>>>>>> aa4cdecb36c8e9c7c3c72dcaf90468b309427073

// Show form daftar Mentor
public function showDaftarMentor()
{
<<<<<<< HEAD
    $user = auth()->user();
    return view('profile.daftar-mentor', compact('user'));
=======
    return view('profile.daftar-mentor');
>>>>>>> aa4cdecb36c8e9c7c3c72dcaf90468b309427073
}

// Simpan pendaftaran Mentor
public function simpanMentor(Request $request)
{
<<<<<<< HEAD
    $request->validate([
        'full_name'      => 'required|string|max:255',
        'phone'          => 'required|string|max:20',
        'email'          => 'required|email',
        'gmaps_location' => 'required|string',
        'bio'            => 'required|string',
        'white_bg_photo' => 'required|image|max:2048',
        'ktp_scan'       => 'required|max:2048',
    ]);

    $fotoPath = $request->file('white_bg_photo')->store('mentor/foto', 'public');
    $ktpPath  = $request->file('ktp_scan')->store('mentor/ktp', 'public');

    Mentor::create([
        'user_id'        => auth()->id(),
        'full_name'      => $request->full_name,
        'nama'           => $request->full_name,
        'phone'          => $request->phone,
        'email'          => $request->email,
        'gmaps_location' => $request->gmaps_location,
        'lokasi'         => $request->gmaps_location,
        'bio'            => $request->bio,
        'deskripsi'      => $request->bio,
        'white_bg_photo' => $fotoPath,
        'ktp_scan'       => $ktpPath,
        'status'         => 'pending',
    ]);

    return redirect()->route('profile')->with('success', 'Pendaftaran mentor berhasil dikirim, menunggu review admin.');
=======
    // logika simpan data Mentor
>>>>>>> aa4cdecb36c8e9c7c3c72dcaf90468b309427073
}
}
