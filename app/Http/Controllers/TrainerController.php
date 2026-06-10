<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Program;
use App\Models\Event;



class TrainerController extends Controller
{
    private const ALLOWED_TAGS = '<p><br><strong><em><u><s><ol><ul><li><h1><h2><h3><h4><a><span><blockquote>';

    // ═══════════════════════════════════════════════════════════════
    // DASHBOARD
    // ═══════════════════════════════════════════════════════════════

    public function index()
    {
        $user = Auth::user();
        $trainer = \App\Models\Trainer::where('user_id', $user->id)->first();

    
        $pelatihanList = Program::where('trainer_id', $user->id)->latest()->get();
        $eventList     = Event::where('trainer_id', $user->id)->latest()->get();
    
        // ✅ Pisah hitungan kurikulum dan modul
        $totalKurikulum = $pelatihanList->where('tipe', 'kurikulum')->count();
        $totalModul     = $pelatihanList->where('tipe', 'modul')->count();
    
        $totalEvent            = $eventList->count();
        $pendingPelatihanCount = $pelatihanList->where('status', 'pending')->count();
        $pendingEventCount     = $eventList->where('status', 'pending')->count();
        $pendingTotal          = $pendingPelatihanCount + $pendingEventCount;
    
        $recentSubmissions = $pelatihanList
        ->map(fn($item) => tap(clone $item, fn($i) => $i->tipe = $i->tipe)) // sudah ada tipe-nya
        ->concat(
            $eventList->map(fn($item) => tap(clone $item, fn($i) => $i->tipe = 'event')) // ← fix: set tipe
        )
        ->sortByDesc('created_at')
        ->take(5);
    
        return view('trainer.dashboard', compact(
            'user',
            'totalKurikulum',  
            'totalModul',      
            'totalEvent',
            'pendingTotal',
            'pendingPelatihanCount',
            'pendingEventCount',
            'pelatihanList',
            'eventList',
            'recentSubmissions',
            'trainer'
        ));
    }

    // ═══════════════════════════════════════════════════════════════
    // PROGRAM — STORE
    // ═══════════════════════════════════════════════════════════════

    public function storeProgram(Request $request)
{
    $request->validate([
        'judul'          => 'required|string|max:255',
        'tipe'           => 'required|in:kurikulum,materi',
        'deskripsi'      => 'nullable|string|max:500',
        'metode'         => 'nullable|in:online,offline,hybrid',
        'tingkat'        => 'nullable|in:pemula,menengah,lanjut',
        'bahasa'         => 'nullable|string|max:100',
        'total_jam'      => 'nullable|integer|min:0',
        'jumlah_sesi'    => 'nullable|integer|min:0',
        'sertifikat'     => 'nullable|boolean',
        'phone'          => 'nullable|string|max:20',
        'biaya'          => 'nullable|string|max:100',
        'alamat'         => 'nullable|string|max:500',
        'gambar'         => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        'absensi_aktif'  => 'nullable|boolean',
        'absensi_mulai'  => 'nullable|date',
        'absensi_selesai'=> 'nullable|date|after:absensi_mulai',
        'absensi_url'    => 'nullable|url|max:255',
    ]);

    $gambar = null;
    if ($request->hasFile('gambar')) {
        $gambar = $request->file('gambar')->store('program', 'public');
    }

    Program::create([
        'trainer_id'     => Auth::id(),
        'judul'          => $request->judul,
        'tipe'           => $request->tipe,
        'deskripsi'      => $request->deskripsi,
        'metode'         => $request->metode,
        'tingkat'        => $request->tingkat,
        'bahasa'         => $request->bahasa,
        'total_jam'      => $request->total_jam,
        'jumlah_sesi'    => $request->jumlah_sesi,
        'sertifikat'     => $request->boolean('sertifikat'),
        'phone'          => $request->phone ?? Auth::user()->phone,
        'biaya'          => $request->biaya,
        'alamat'         => $request->alamat,
        'gambar'         => $gambar,
        'status'         => 'pending',
        'absensi_aktif'  => $request->boolean('absensi_aktif'),
        'absensi_mulai'  => $request->absensi_aktif ? $request->absensi_mulai   : null,
        'absensi_selesai'=> $request->absensi_aktif ? $request->absensi_selesai : null,
        'absensi_url'    => $request->absensi_aktif ? $request->absensi_url     : null,
    ]);

    return redirect()->route('trainer.dashboard')
        ->with('success', 'Kurikulum berhasil dikirim dan menunggu persetujuan admin.')
        ->with('active_page', 'program');
}
    // ═══════════════════════════════════════════════════════════════
    // PROGRAM — UPDATE
    // ═══════════════════════════════════════════════════════════════

    public function updateProgram(Request $request, $id)
{
    $program = Program::where('id', $id)
        ->where('trainer_id', Auth::id())
        ->firstOrFail();

    // FIX 3: approved boleh edit HANYA field absensi
    if ($program->status === 'approved') {
        $program->update([
            'absensi_aktif'  => $request->boolean('absensi_aktif'),
            'absensi_mulai'  => $request->absensi_aktif ? $request->absensi_mulai   : null,
            'absensi_selesai'=> $request->absensi_aktif ? $request->absensi_selesai : null,
            'absensi_url'    => $request->absensi_aktif ? $request->absensi_url     : null,
            'phone'          => $request->phone ?? Auth::user()->phone,
        ]);
        return redirect()->route('trainer.dashboard')
            ->with('success', 'Jadwal absensi berhasil diperbarui.')
            ->with('active_page', 'program');
    }

    $request->validate([
        'judul'          => 'required|string|max:255',
        'tipe'           => 'required|in:kurikulum,materi',
        'deskripsi'      => 'nullable|string|max:500',
        'metode'         => 'nullable|in:online,offline,hybrid',
        'tingkat'        => 'nullable|in:pemula,menengah,lanjut',
        'bahasa'         => 'nullable|string|max:100',
        'total_jam'      => 'nullable|integer|min:0',
        'jumlah_sesi'    => 'nullable|integer|min:0',
        'sertifikat'     => 'nullable|boolean',
        'phone'          => 'nullable|string|max:20',
        'biaya'          => 'nullable|string|max:100',
        'alamat'         => 'nullable|string|max:500',
        'gambar'         => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        'absensi_aktif'  => 'nullable|boolean',
        'absensi_mulai'  => 'nullable|date',
        'absensi_selesai'=> 'nullable|date|after:absensi_mulai',
        'absensi_url'    => 'nullable|url|max:255',
    ]);

    if ($request->hasFile('gambar')) {
        if ($program->gambar) Storage::disk('public')->delete($program->gambar);
        $program->gambar = $request->file('gambar')->store('program', 'public');
    }

    $program->update([
        'judul'          => $request->judul,
        'tipe'           => $request->tipe,
        'deskripsi'      => $request->deskripsi,
        'metode'         => $request->metode,
        'tingkat'        => $request->tingkat,
        'bahasa'         => $request->bahasa,
        'total_jam'      => $request->total_jam,
        'jumlah_sesi'    => $request->jumlah_sesi,
        'sertifikat'     => $request->boolean('sertifikat'),
        'phone'          => $request->phone ?? Auth::user()->phone,
        'biaya'          => $request->biaya,
        'alamat'         => $request->alamat,
        'gambar'         => $program->gambar,
        'status'         => 'pending',
        'catatan_admin'  => null,
        'absensi_aktif'  => $request->boolean('absensi_aktif'),
        'absensi_mulai'  => $request->absensi_aktif ? $request->absensi_mulai   : null,
        'absensi_selesai'=> $request->absensi_aktif ? $request->absensi_selesai : null,
        'absensi_url'    => $request->absensi_aktif ? $request->absensi_url     : null,
    ]);

    return redirect()->route('trainer.dashboard')
        ->with('success', 'Kurikulum diperbarui dan dikirim ulang untuk disetujui.')
        ->with('active_page', 'program');
}

    // ═══════════════════════════════════════════════════════════════
    // PROGRAM — DESTROY
    // ═══════════════════════════════════════════════════════════════

    public function destroyProgram($id)
    {
        $program = Program::where('id', $id)
            ->where('trainer_id', Auth::id())
            ->firstOrFail();

        if ($program->status === 'approved') {
            return back()->with('error', 'Program yang sudah disetujui tidak dapat dihapus.');
        }

        if ($program->gambar) Storage::disk('public')->delete($program->gambar);
        $program->delete();

        return redirect()->route('trainer.dashboard')
            ->with('success', 'Program berhasil dihapus.')
            ->with('active_page', 'program');
    }

    // ═══════════════════════════════════════════════════════════════
    // EVENT — STORE
    // FIX: tambah tipe, kapasitas, biaya; gunakan 'gambar' (bukan banner)
    // ═══════════════════════════════════════════════════════════════

    public function storeEvent(Request $request)
    {
        $request->validate([
            'judul'         => 'required|string|max:255',
            'tanggal'       => 'required|date',
            'waktu_mulai'   => 'nullable|date_format:H:i',
            'waktu_selesai' => 'nullable|date_format:H:i|after:waktu_mulai',
            'lokasi'        => 'nullable|string|max:255',
            'kapasitas'     => 'nullable|integer|min:1',
            'biaya'         => 'nullable|string|max:100',
            'deskripsi'     => 'required|string',
            'gambar'        => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'phone' => 'nullable|string|max:20',
        ]);
    
        $gambar = null;
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar')->store('event', 'public');
        }
    
        \App\Models\Event::create([
            'trainer_id'    => Auth::id(),
            'judul'         => $request->judul,
            'tanggal'       => $request->tanggal,
            'waktu_mulai'   => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'lokasi'        => $request->lokasi,
            'kapasitas'     => $request->kapasitas,
            'biaya'         => $request->biaya,
            'deskripsi'     => $request->deskripsi,
            'gambar'        => $gambar,
            'status'        => 'pending',
            'phone'         => $request->phone ?? Auth::user()->phone,
        ]);
    
        return redirect()->route('trainer.dashboard')
            ->with('success', 'Event berhasil dikirim, menunggu persetujuan admin.')
            ->with('active_page', 'event');
    }


    // ═══════════════════════════════════════════════════════════════
    // EVENT — UPDATE
    // ═══════════════════════════════════════════════════════════════

    public function updateEvent(Request $request, $id)
    {
        $event = \App\Models\Event::where('id', $id)
            ->where('trainer_id', Auth::id())
            ->firstOrFail();
    
            
        $request->validate([
            'judul'         => 'required|string|max:255',
            'tanggal'       => 'required|date',
            'waktu_mulai'   => 'nullable|date_format:H:i',
            'waktu_selesai' => 'nullable|date_format:H:i|after:waktu_mulai',
            'lokasi'        => 'nullable|string|max:255',
            'kapasitas'     => 'nullable|integer|min:1',
            'biaya'         => 'nullable|string|max:100',
            'deskripsi'     => 'required|string',
            'gambar'        => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'phone' => 'nullable|string|max:20', 
        ]);
    
        if ($request->hasFile('gambar')) {
            if ($event->gambar) \Illuminate\Support\Facades\Storage::disk('public')->delete($event->gambar);
            $event->gambar = $request->file('gambar')->store('event', 'public');
        }
    
        $event->update([
            'judul'         => $request->judul,
            'tanggal'       => $request->tanggal,
            'waktu_mulai'   => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'lokasi'        => $request->lokasi,
            'kapasitas'     => $request->kapasitas,
            'biaya'         => $request->biaya,
            'deskripsi'     => $request->deskripsi,
            'gambar'        => $event->gambar,
            'status'        => 'pending',
            'catatan_admin' => null,
            'phone' => $request->phone ?? Auth::user()->phone,
        ]);
    
        return redirect()->route('trainer.dashboard')
            ->with('success', 'Event diperbarui dan dikirim ulang untuk disetujui.')
            ->with('active_page', 'event');
    }
    // ═══════════════════════════════════════════════════════════════
    // EVENT — DESTROY
    // ═══════════════════════════════════════════════════════════════

    public function destroyEvent($id)
    {
        $event = Event::where('id', $id)
            ->where('trainer_id', Auth::id())
            ->firstOrFail();

        // Trainer boleh hapus event apapun statusnya
        if ($event->gambar) Storage::disk('public')->delete($event->gambar);
        $event->delete();

        return redirect()->route('trainer.dashboard')
            ->with('success', 'Event berhasil dihapus.')
            ->with('active_page', 'event');
    }

    public function updateDisplayedBidang(Request $request)
{
    $user    = Auth::user();
    $trainer = \App\Models\Trainer::where('user_id', $user->id)->first();

    if (!$trainer) {
        return back()->with('error', 'Data trainer tidak ditemukan.');
    }

    $request->validate([
        'displayed_bidang' => 'required|string|max:100',
    ]);

    $trainer->update(['displayed_bidang' => $request->displayed_bidang]);

    return back()->with('success', 'Bidang keahlian berhasil diperbarui!');
}



    // ═══════════════════════════════════════════════════════════════
    // PROFIL — UPDATE
    // FIX: handle semua field dari form: name, email, no_hp,
    //      bidang_keahlian, bio, linkedin, foto, password
    // ═══════════════════════════════════════════════════════════════

    public function updateProfil(Request $request)
{
    $user = Auth::user();

    \Log::info('=== UPDATE PROFIL ===');
    \Log::info('Request data:', $request->all());
    \Log::info('User ID:', [$user->id]);

    $request->validate([
        'name'                  => 'required|string|max:255',
        'email'                 => 'required|email|max:255|unique:users,email,' . $user->id,
        'phone'                 => 'nullable|string|max:20',
        'academic_degree'       => 'nullable|string|max:255',
        'bidang_keahlian'       => 'nullable|string|max:1000',
        'displayed_bidang'      => 'nullable|string|max:255',
        'bio'                   => 'nullable|string|max:1000',
        'foto'                  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'password' => [
            'nullable',
            'string',
            'min:8',
            function ($attribute, $value, $fail) use ($request) {
                if ($value && $value !== $request->password_confirmation) {
                    $fail('Konfirmasi password tidak cocok.');
                }
            },
        ],
        'password_confirmation' => 'nullable|string',
    ]);

    // ── Update tabel users ──────────────────────────────────────
    $userData = $request->only(['name', 'email', 'phone']);
    if ($request->filled('password')) {
        $userData['password'] = Hash::make($request->password);
    }
    $user->update($userData);

    // ── Update tabel trainer ────────────────────────────────────
    $trainer = \App\Models\Trainer::firstOrNew(['user_id' => $user->id]);

    \Log::info('Trainer exists:', [$trainer->exists]);
    \Log::info('Trainer ID:', [$trainer->id ?? 'NULL - record baru']);

    $trainer->fill([
        'bio'              => $request->bio,
        'keahlian'         => $request->bidang_keahlian,
        'academic_degree'  => $request->academic_degree,
        'displayed_bidang' => $request->displayed_bidang,
        'nama'             => $request->name,
    ]);

    if ($request->hasFile('foto')) {
        if ($trainer->foto) Storage::disk('public')->delete($trainer->foto);
        $trainer->foto = $request->file('foto')->store('profil', 'public');
        $trainer->white_bg_photo = null;
    }

    if (!$trainer->exists) {
        $trainer->user_id = $user->id;
        $trainer->status  = 'pending';
    }

    \Log::info('Trainer dirty (akan disimpan):', $trainer->getDirty());

    $trainer->save();

    \Log::info('Trainer setelah save:', $trainer->toArray());

    return back()
        ->with('success', 'Profil berhasil diperbarui.')
        ->with('active_page', 'profil');
}
    // ═══════════════════════════════════════════════════════════════
    // HELPER PRIVATE
    // ═══════════════════════════════════════════════════════════════

    private function sanitize(?string $html): ?string
    {
        if (!$html) return null;
        return strip_tags($html, self::ALLOWED_TAGS);
    }
}