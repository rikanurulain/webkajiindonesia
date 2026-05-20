<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use App\Models\ActivityLog;
use App\Models\Mentor;
use App\Models\Produk;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit');
    }

    
public function update(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'name'    => 'required|string|max:255',
        'phone'   => 'nullable|string|max:20',
        'address' => 'nullable|string|max:500',
        'bio'     => 'nullable|string|max:500',
    ]);

    $user->name    = $request->name;
    $user->phone   = $request->phone;
    $user->address = $request->address;
    $user->bio     = $request->bio;

    $user->save();

    ActivityLog::create([
        'user_id'     => $user->id,
        'type'        => 'profile',
        'label'       => 'Update profil',
        'description' => 'Informasi profil diperbarui',
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
        $user       = Auth::user()->fresh(); // ← pastikan ada fresh()
        $activities = ActivityLog::where('user_id', $user->id)->latest()->take(5)->get();
        $umkm       = \App\Models\Produk::where('user_id', $user->id)->latest()->first();
        $mentor     = \App\Models\Mentor::where('user_id', $user->id)->latest()->first();
    
        return view('profile.index', compact('user', 'activities', 'umkm', 'mentor')); // ← umkm & mentor ikut dipass
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
    $user = Auth::user();
    if (!$user->profile_photo_path) {
        return redirect()->route('profile')->with('error', 'Upload foto profil dulu sebelum mendaftar sebagai Trainer.');
    }
    return view('profile.daftar-trainer', compact('user'));
}

/**
 * Menyimpan data bio dan lokasi calon trainer
 */
public function simpanTrainer(Request $request)
{
    $user = Auth::user();

    // Cek foto profil wajib ada
    if (!$user->profile_photo_path) {
        return back()->with('error', 'Anda harus mengupload foto profil terlebih dahulu sebelum mendaftar sebagai Trainer.');
    }
    $user = Auth::user();

    $request->validate([
        'academic_degree' => 'required|string|max:255',
        'phone'           => 'required|string|max:20',
        'email'           => 'required|email|max:255',
        'nik'             => 'required|string|max:20',
        'npwp'            => 'nullable|string|max:30',
        'gmaps_location'  => 'required|string|max:500',
        'provinsi'        => 'required|string|max:255',
        'kabupaten'       => 'required|string|max:255',
        'kecamatan'       => 'required|string|max:255',
        'kelurahan'       => 'required|string|max:255',
        'ijazah_type'     => 'required|in:SMA,D3,S1,S2,S3',
        'drive_link'      => 'required|url',
        'experience'      => 'required|string',
        'bio'             => 'required|string',
        'ktp_scan'        => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        'bnsp_certificate'=> 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        'white_bg_photo'  => 'required|image|mimes:jpg,jpeg,png|max:2048',
        'bukti_transfer'  => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        'agree_terms'     => 'required|accepted',
    ], [
        'academic_degree.required' => 'Nama lengkap & gelar wajib diisi.',
        'phone.required'           => 'Nomor WhatsApp wajib diisi.',
        'email.required'           => 'Email aktif wajib diisi.',
        'nik.required'             => 'Nomor NIK/KTP wajib diisi.',
        'gmaps_location.required'  => 'Alamat domisili wajib diisi.',
        'provinsi.required'        => 'Provinsi wajib dipilih.',
        'kabupaten.required'       => 'Kabupaten/Kota wajib dipilih.',
        'kecamatan.required'       => 'Kecamatan wajib dipilih.',
        'kelurahan.required'       => 'Desa/Kelurahan wajib dipilih.',
        'ijazah_type.required'     => 'Ijazah terakhir wajib dipilih.',
        'drive_link.required'      => 'Link Drive dokumentasi wajib diisi.',
        'drive_link.url'           => 'Link Drive harus berupa URL yang valid.',
        'experience.required'      => 'Pengalaman wajib diisi.',
        'bio.required'             => 'Tentang diri Anda wajib diisi.',
        'ktp_scan.required'        => 'Scan KTP wajib diunggah.',
        'bnsp_certificate.required'=> 'Sertifikat BNSP wajib diunggah.',
        'white_bg_photo.required'  => 'Pas foto background putih wajib diunggah.',
        'bukti_transfer.required'  => 'Bukti transfer wajib diunggah.',
        'agree_terms.accepted'     => 'Anda wajib menyetujui Syarat dan Ketentuan.',
    ]);

    // Gabungkan wilayah jadi string lokasi ringkas
    $lokasi = implode(', ', array_filter([
        $request->kelurahan,
        $request->kecamatan,
        $request->kabupaten,
        $request->provinsi,
    ]));

    $data = [
        'academic_degree'        => $request->academic_degree,
        'nik'                    => $request->nik,
        'npwp'                   => $request->npwp,
        'location'               => $lokasi,           // kolom lama tetap terisi
        'gmaps_location'         => $request->gmaps_location,
        'provinsi'               => $request->provinsi,
        'kabupaten'              => $request->kabupaten,
        'kecamatan'              => $request->kecamatan,
        'kelurahan'              => $request->kelurahan,
        'ijazah_type'            => $request->ijazah_type,
        'drive_link_documentation' => $request->drive_link,
        'experience'             => $request->experience,
        'bio'                    => $request->bio,
        'trainer_status'         => 'pending',
    ];

    if ($request->hasFile('ktp_scan')) {
        $data['ktp_scan'] = $request->file('ktp_scan')->store('trainer_docs', 'public');
    }
    if ($request->hasFile('bnsp_certificate')) {
        $data['bnsp_certificate'] = $request->file('bnsp_certificate')->store('trainer_docs', 'public');
    }
    if ($request->hasFile('white_bg_photo')) {
        $data['white_bg_photo'] = $request->file('white_bg_photo')->store('trainer_docs', 'public');
    }
    if ($request->hasFile('bukti_transfer')) {
        $data['bukti_transfer'] = $request->file('bukti_transfer')->store('trainer_docs', 'public');
    }

    $user->update($data);

    ActivityLog::create([
        'user_id'     => $user->id,
        'type'        => 'profile',
        'label'       => 'Menunggu Persetujuan Trainer',
        'description' => 'User melengkapi persyaratan dan menunggu verifikasi admin',
        'ip_address'  => $request->ip(),
        'user_agent'  => $request->userAgent(),
        'is_success'  => true,
    ]);

    return redirect()->route('profile')->with('success', 'Persyaratan dikirim! Admin akan segera meninjau pengajuan Anda.');
}

// Show form daftar UMKM
public function showDaftarUmkm()
{
    $user = Auth::user();
    if (!$user->profile_photo_path) {
        return redirect()->route('profile')->with('error', 'Upload foto profil dulu sebelum mendaftar sebagai UMKM.');
    }
    return view('profile.daftar-umkm');
}


// Simpan pendaftaran UMKM
public function simpanUmkm(Request $request)
{
    $user = Auth::user();

    // Cek foto profil wajib ada
    if (!$user->profile_photo_path) {
        return back()->with('error', 'Anda harus mengupload foto profil terlebih dahulu sebelum mendaftar sebagai UMKM.');
    }
    // 1. Validasi Input
    $request->validate([
        'nama'           => 'required|string|max:255',
        'kategori'       => 'required',
        'owner'          => 'required|string|max:255',
        'kontak'         => 'required|string|max:20',
        'provinsi'       => 'required',
        'kabupaten_kota' => 'required',
        'kecamatan'      => 'required',
        'kelurahan'      => 'required',
        'alamat'         => 'required|string',
        'deskripsi'      => 'required|string',
        'logo'           => 'required|image|mimes:jpg,jpeg,png,webp|max:10240',
        'foto_produk'    => 'required|image|mimes:jpg,jpeg,png,webp|max:10240',
        'lat'            => 'required|numeric|between:-11,6',
        'lng'            => 'required|numeric|between:95,141',
        'terms'          => 'required', // Memastikan checkbox dicentang
    ], [
        'terms.required' => 'Anda harus menyetujui Syarat dan Ketentuan.',
        'logo.required'  => 'Logo usaha wajib diunggah.',
        'lat.required'   => 'Titik lokasi di peta wajib dipilih.',
        'lng.required'   => 'Titik lokasi di peta wajib dipilih.',
        'lat.between'    => 'Koordinat tidak valid, pastikan lokasi berada di wilayah Indonesia.',
        'lng.between'    => 'Koordinat tidak valid, pastikan lokasi berada di wilayah Indonesia.',
    ]);

    // 2. Proses Upload File
    // Simpan ke folder storage/app/public/produk-pict
    $logoPath = $request->file('logo')->store('produk-pict', 'public');
    $fotoProdukPath = $request->file('foto_produk')->store('produk-pict', 'public');

    // 3. Simpan ke Database
    \App\Models\Produk::create([
        'user_id'        => auth()->id(),
        'nama'           => $request->nama,
        'kategori'       => $request->kategori,
        'owner'          => $request->owner,
        'kontak'         => $request->kontak,
        'nib'            => $request->nib,
        'id_tkm'         => $request->id_tkm,
        'provinsi'       => $request->provinsi,
        'kabupaten_kota' => $request->kabupaten_kota,
        'kecamatan'      => $request->kecamatan,
        'kelurahan'      => $request->kelurahan,
        'alamat'         => $request->alamat,
        'deskripsi'      => $request->deskripsi,
        'logo'           => $logoPath,        // Kolom logo baru
        'foto_produk'    => $fotoProdukPath,
        'lat'            => $request->lat,
        'lng'            => $request->lng,
        'status'         => 'pending',       // Default pending menunggu acc admin
    ]);

    // 4. Catat Aktivitas
    ActivityLog::create([
        'user_id'     => auth()->id(),
        'type'        => 'profile',
        'label'       => 'Pendaftaran UMKM',
        'description' => 'User mendaftarkan unit usaha UMKM: ' . $request->nama,
        'ip_address'  => $request->ip(),
        'user_agent'  => $request->userAgent(),
        'is_success'  => true,
    ]);

    return redirect()->route('profile')->with('success', 'Pendaftaran UMKM berhasil dikirim! Mohon tunggu verifikasi admin.');
}

// Show form daftar Mentor
public function showDaftarMentor()
{
    $user = Auth::user();
    if (!$user->profile_photo_path) {
        return redirect()->route('profile')->with('error', 'Upload foto profil dulu sebelum mendaftar sebagai Mentor.');
    }
    return view('profile.daftar-mentor', compact('user'));
}


// Simpan pendaftaran Mentor
// Simpan pendaftaran Mentor
public function simpanMentor(Request $request)
{

    $user = Auth::user();

    // Cek foto profil wajib ada
    if (!$user->profile_photo_path) {
        return back()->with('error', 'Anda harus mengupload foto profil terlebih dahulu sebelum mendaftar sebagai Mentor.');
    }

    $request->validate([
        'full_name'      => 'required|string|max:255',
        'phone'          => 'required|string|max:20',
        'email'          => 'required|email|max:255',
        'gmaps_location' => 'required|string|max:500',
        'provinsi'       => 'required|string|max:255',
        'kabupaten'      => 'required|string|max:255',
        'kecamatan'      => 'required|string|max:255',
        'kelurahan'      => 'required|string|max:255',
        'bio'            => 'required|string',
        'white_bg_photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        'ktp_scan'       => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        'bukti_transfer' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        'agree_terms'    => 'required|accepted',
        'lat'            => 'required|numeric|between:-11,6',
        'lng'            => 'required|numeric|between:95,141',
    ], [
        'full_name.required'      => 'Nama lengkap wajib diisi.',
        'phone.required'          => 'Nomor WhatsApp wajib diisi.',
        'email.required'          => 'Email aktif wajib diisi.',
        'email.email'             => 'Format email tidak valid.',
        'gmaps_location.required' => 'Lokasi tinggal wajib diisi.',
        'provinsi.required'       => 'Provinsi wajib dipilih.',
        'kabupaten.required'      => 'Kabupaten/Kota wajib dipilih.',
        'kecamatan.required'      => 'Kecamatan wajib dipilih.',
        'kelurahan.required'      => 'Desa/Kelurahan wajib dipilih.',
        'bio.required'            => 'Tentang diri Anda wajib diisi.',
        'white_bg_photo.required' => 'Pas foto background putih wajib diunggah.',
        'white_bg_photo.image'    => 'Pas foto harus berupa gambar (JPG/PNG).',
        'white_bg_photo.max'      => 'Ukuran pas foto maksimal 2 MB.',
        'ktp_scan.required'       => 'Scan KTP wajib diunggah.',
        'ktp_scan.mimes'          => 'Scan KTP harus berformat JPG, PNG, atau PDF.',
        'ktp_scan.max'            => 'Ukuran scan KTP maksimal 2 MB.',
        'bukti_transfer.required' => 'Bukti transfer wajib diunggah.',
        'bukti_transfer.mimes'    => 'Bukti transfer harus berformat JPG, PNG, atau PDF.',
        'bukti_transfer.max'      => 'Ukuran bukti transfer maksimal 2 MB.',
        'agree_terms.required'    => 'Anda wajib menyetujui Syarat dan Ketentuan.',
        'agree_terms.accepted'    => 'Anda wajib menyetujui Syarat dan Ketentuan.',
        'lat.required'            => 'Titik lokasi di peta wajib dipilih.',
        'lng.required'            => 'Titik lokasi di peta wajib dipilih.',
        'lat.between'             => 'Koordinat tidak valid, pastikan lokasi di wilayah Indonesia.',
        'lng.between'             => 'Koordinat tidak valid, pastikan lokasi di wilayah Indonesia.',
    ]);
 
    $fotoPath     = $request->file('white_bg_photo')->store('mentor/foto', 'public');
    $ktpPath      = $request->file('ktp_scan')->store('mentor/ktp', 'public');
    $transferPath = $request->file('bukti_transfer')->store('mentor/transfer', 'public');
 
    // Gabungkan wilayah sebagai lokasi ringkas
    $lokasi = implode(', ', array_filter([
        $request->kelurahan,
        $request->kecamatan,
        $request->kabupaten,
        $request->provinsi,
    ]));
 
    Mentor::create([
        'user_id'        => auth()->id(),
        'full_name'      => $request->full_name,
        'nama'           => $request->full_name,
        'phone'          => $request->phone,
        'email'          => $request->email,
        'gmaps_location' => $request->gmaps_location,
        'provinsi'       => $request->provinsi,
        'kabupaten'      => $request->kabupaten,
        'kecamatan'      => $request->kecamatan,
        'kelurahan'      => $request->kelurahan,
        'lokasi'         => $lokasi,
        'bio'            => $request->bio,
        'deskripsi'      => $request->bio,
        'white_bg_photo' => $fotoPath,
        'ktp_scan'       => $ktpPath,
        'bukti_transfer' => $transferPath,
        'agree_terms'    => true,
        'role'           => 'Pembimbing',
        'lat'            => $request->lat,
        'lng'            => $request->lng,
        'status'         => 'pending',
    ]);
 
    ActivityLog::create([
        'user_id'     => auth()->id(),
        'type'        => 'profile',
        'label'       => 'Pendaftaran Mentor',
        'description' => 'User mengajukan diri menjadi Mentor: ' . $request->full_name,
        'ip_address'  => $request->ip(),
        'user_agent'  => $request->userAgent(),
        'is_success'  => true,
    ]);
 
    return redirect()->route('profile')->with('success', 'Pendaftaran mentor berhasil dikirim, menunggu review admin.');
}
}
