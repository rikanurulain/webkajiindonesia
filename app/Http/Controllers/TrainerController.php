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

        $pelatihanList = Program::where('trainer_id', $user->id)->latest()->get();
        $eventList     = Event::where('trainer_id', $user->id)->latest()->get();

        $totalPelatihan        = $pelatihanList->count();
        $pelatihanDisetujui    = $pelatihanList->where('status', 'approved')->count();
        $pendingPelatihanCount = $pelatihanList->where('status', 'pending')->count();
        $totalEvent            = $eventList->count();
        $pendingEventCount     = $eventList->where('status', 'pending')->count();
        $pendingTotal          = $pendingPelatihanCount + $pendingEventCount;

        // 5 submission terbaru (gabungan program & event)
        $recentSubmissions = $pelatihanList
            ->map(fn($item) => tap(clone $item, fn($i) => $i->jenis = 'Program'))
            ->concat(
                $eventList->map(fn($item) => tap(clone $item, fn($i) => $i->jenis = 'Event'))
            )
            ->sortByDesc('created_at')
            ->take(5);

        return view('trainer.dashboard', compact(
            'user',
            'totalPelatihan',
            'pelatihanDisetujui',
            'totalEvent',
            'pendingTotal',
            'pendingPelatihanCount',
            'pendingEventCount',
            'pelatihanList',
            'eventList',
            'recentSubmissions'
        ));
    }

    // ═══════════════════════════════════════════════════════════════
    // PROGRAM — STORE
    // ═══════════════════════════════════════════════════════════════

    public function storeProgram(Request $request)
    {
        $request->validate([
            'judul'             => 'required|string|max:255',
            // FIX: nilai enum DB adalah kurikulum / materi
            'tipe'              => 'required|in:kurikulum,materi',
            'deskripsi'         => 'required|string|max:500',
            'deskripsi_panjang' => 'nullable|string',
            'konten_kurikulum'  => 'nullable|string',
            'konten_materi'     => 'nullable|string',
            'target'            => 'nullable|string|max:255',
            'metode'            => 'nullable|in:online,offline,hybrid',
            'tingkat'           => 'nullable|in:pemula,menengah,lanjut',
            'bahasa'            => 'nullable|string|max:100',
            'tanggal'           => 'nullable|date',
            'gambar'            => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $gambar = null;
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar')->store('program', 'public');
        }

        Program::create([
            'trainer_id'        => Auth::id(),
            'judul'             => $request->judul,
            'tipe'              => $request->tipe,
            'deskripsi'         => $request->deskripsi,
            'deskripsi_panjang' => $this->sanitize($request->deskripsi_panjang),
            'konten_kurikulum'  => $request->tipe === 'kurikulum'
                                    ? $this->sanitize($request->konten_kurikulum) : null,
            'konten_materi'     => $request->tipe === 'materi'
                                    ? $this->sanitize($request->konten_materi) : null,
            'target'            => $request->target,
            'metode'            => $request->metode,
            'tingkat'           => $request->tingkat,
            'bahasa'            => $request->bahasa,
            'tanggal'           => $request->tanggal,
            'gambar'            => $gambar,
            'status'            => 'pending',
        ]);

        return redirect()->route('trainer.dashboard')
            ->with('success', 'Program berhasil dikirim dan menunggu persetujuan admin.')
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

        if ($program->status === 'approved') {
            return back()->with('error', 'Program yang sudah disetujui tidak dapat diedit. Hubungi admin.');
        }

        $request->validate([
            'judul'             => 'required|string|max:255',
            'tipe'              => 'required|in:kurikulum,materi',
            'deskripsi'         => 'required|string|max:500',
            'deskripsi_panjang' => 'nullable|string',
            'konten_kurikulum'  => 'nullable|string',
            'konten_materi'     => 'nullable|string',
            'target'            => 'nullable|string|max:255',
            'metode'            => 'nullable|in:online,offline,hybrid',
            'tingkat'           => 'nullable|in:pemula,menengah,lanjut',
            'bahasa'            => 'nullable|string|max:100',
            'tanggal'           => 'nullable|date',
            'gambar'            => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        if ($request->hasFile('gambar')) {
            if ($program->gambar) Storage::disk('public')->delete($program->gambar);
            $program->gambar = $request->file('gambar')->store('program', 'public');
        }

        $program->update([
            'judul'             => $request->judul,
            'tipe'              => $request->tipe,
            'deskripsi'         => $request->deskripsi,
            'deskripsi_panjang' => $this->sanitize($request->deskripsi_panjang),
            'konten_kurikulum'  => $request->tipe === 'kurikulum'
                                    ? $this->sanitize($request->konten_kurikulum) : null,
            'konten_materi'     => $request->tipe === 'materi'
                                    ? $this->sanitize($request->konten_materi) : null,
            'target'            => $request->target,
            'metode'            => $request->metode,
            'tingkat'           => $request->tingkat,
            'bahasa'            => $request->bahasa,
            'tanggal'           => $request->tanggal,
            'gambar'            => $program->gambar,
            'status'            => 'pending', // reset ke pending untuk review ulang
            'catatan_admin'     => null,
        ]);

        return redirect()->route('trainer.dashboard')
            ->with('success', 'Program diperbarui dan dikirim ulang untuk disetujui.')
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
            'judul'     => 'required|string|max:255',
            'tipe'      => 'nullable|string|max:100',
            'tanggal'   => 'required|date',
            'lokasi'    => 'nullable|string|max:255',
            'kapasitas' => 'nullable|integer|min:1',
            'biaya'     => 'nullable|string|max:100',
            'deskripsi' => 'required|string',
            // FIX: field gambar, bukan banner
            'gambar'    => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $gambar = null;
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar')->store('event', 'public');
        }

        Event::create([
            'trainer_id' => Auth::id(),
            'judul'      => $request->judul,   // pastikan kolom Event: judul
            'tipe'       => $request->tipe,
            'tanggal'    => $request->tanggal,
            'lokasi'     => $request->lokasi,
            'kapasitas'  => $request->kapasitas,
            'biaya'      => $request->biaya,
            'deskripsi'  => $request->deskripsi,
            'gambar'     => $gambar,
            'status'     => 'pending',
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
        $event = Event::where('id', $id)
            ->where('trainer_id', Auth::id())
            ->firstOrFail();

        if ($event->status === 'approved') {
            return back()->with('error', 'Event yang sudah disetujui tidak dapat diedit.');
        }

        $request->validate([
            'judul'     => 'required|string|max:255',
            'tipe'      => 'nullable|string|max:100',
            'tanggal'   => 'required|date',
            'lokasi'    => 'nullable|string|max:255',
            'kapasitas' => 'nullable|integer|min:1',
            'biaya'     => 'nullable|string|max:100',
            'deskripsi' => 'required|string',
            'gambar'    => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        if ($request->hasFile('gambar')) {
            if ($event->gambar) Storage::disk('public')->delete($event->gambar);
            $event->gambar = $request->file('gambar')->store('event', 'public');
        }

        $event->update([
            'judul'     => $request->judul,
            'tipe'      => $request->tipe,
            'tanggal'   => $request->tanggal,
            'lokasi'    => $request->lokasi,
            'kapasitas' => $request->kapasitas,
            'biaya'     => $request->biaya,
            'deskripsi' => $request->deskripsi,
            'gambar'    => $event->gambar,
            'status'    => 'pending',
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

    // ═══════════════════════════════════════════════════════════════
    // PROFIL — UPDATE
    // FIX: handle semua field dari form: name, email, no_hp,
    //      bidang_keahlian, bio, linkedin, foto, password
    // ═══════════════════════════════════════════════════════════════

    public function updateProfil(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|max:255|unique:users,email,' . $user->id,
            'no_hp'           => 'nullable|string|max:20',
            'bidang_keahlian' => 'nullable|string|max:255',
            'bio'             => 'nullable|string|max:1000',
            'linkedin'        => 'nullable|url|max:255',
            'foto'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'password'        => 'nullable|string|min:8',
        ]);

        $data = $request->only(['name', 'email', 'no_hp', 'bidang_keahlian', 'bio', 'linkedin']);

        // Ganti foto jika ada upload baru
        if ($request->hasFile('foto')) {
            if ($user->foto) Storage::disk('public')->delete($user->foto);
            $data['foto'] = $request->file('foto')->store('profil', 'public');
        }

        // Update password jika diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

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