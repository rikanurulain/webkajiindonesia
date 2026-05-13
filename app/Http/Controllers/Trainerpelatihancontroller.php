<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class TrainerPelatihanController extends Controller
{
    // ─────────────────────────────────────────────────────────────
    // STORE KURIKULUM
    // ─────────────────────────────────────────────────────────────
    public function storeKurikulum(Request $request)
    {
        $request->validate([
            'judul'         => 'required|string|max:255',
            'deskripsi'     => 'nullable|string|max:500',
            'metode'        => 'nullable|in:online,offline,hybrid',
            'tingkat'       => 'nullable|in:pemula,menengah,lanjut',
            'bahasa'        => 'nullable|string|max:100',
            'jumlah_materi' => 'nullable|integer|min:0',
            'total_jam'     => 'nullable|numeric|min:0',
            'jumlah_sesi'   => 'nullable|integer|min:0',
            'sertifikat'    => 'nullable|in:0,1',
            'status_aktif'  => 'nullable|in:aktif,nonaktif',
            'gambar'        => 'nullable|image|max:5120',
        ]);

        $data = [
            'trainer_id'    => Auth::id(),
            'tipe'          => 'kurikulum',
            'slug'          => Str::slug($request->judul) . '-' . Str::random(6),
            'judul'         => $request->judul,
            'deskripsi'     => $request->deskripsi,
            'metode'        => $request->metode,
            'tingkat'       => $request->tingkat,
            'bahasa'        => $request->bahasa ?? 'Bahasa Indonesia',
            'jumlah_materi' => $request->jumlah_materi,
            'total_jam'     => $request->total_jam,
            'jumlah_sesi'   => $request->jumlah_sesi,
            'sertifikat'    => $request->sertifikat ?? 0,
            // status_aktif disimpan di field lain agar tidak konflik dengan approval workflow
            // kita simpan di deskripsi_panjang sementara, atau bisa tambah kolom status_aktif
            'status'        => 'pending', // tetap pending untuk approval admin
        ];

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('programs', 'public');
        }

        Program::create($data);

        return redirect()->back()
            ->with('success', 'Kurikulum berhasil diajukan, menunggu persetujuan admin.')
            ->with('active_page', 'program');
    }

    // ─────────────────────────────────────────────────────────────
    // UPDATE KURIKULUM
    // ─────────────────────────────────────────────────────────────
    public function updateKurikulum(Request $request, $id)
    {
        $program = Program::where('id', $id)
            ->where('trainer_id', Auth::id())
            ->where('tipe', 'kurikulum')
            ->firstOrFail();

        $request->validate([
            'judul'         => 'required|string|max:255',
            'deskripsi'     => 'nullable|string|max:500',
            'metode'        => 'nullable|in:online,offline,hybrid',
            'tingkat'       => 'nullable|in:pemula,menengah,lanjut',
            'bahasa'        => 'nullable|string|max:100',
            'jumlah_materi' => 'nullable|integer|min:0',
            'total_jam'     => 'nullable|numeric|min:0',
            'jumlah_sesi'   => 'nullable|integer|min:0',
            'sertifikat'    => 'nullable|in:0,1',
            'gambar'        => 'nullable|image|max:5120',
        ]);

        $data = [
            'judul'         => $request->judul,
            'deskripsi'     => $request->deskripsi,
            'metode'        => $request->metode,
            'tingkat'       => $request->tingkat,
            'bahasa'        => $request->bahasa ?? 'Bahasa Indonesia',
            'jumlah_materi' => $request->jumlah_materi,
            'total_jam'     => $request->total_jam,
            'jumlah_sesi'   => $request->jumlah_sesi,
            'sertifikat'    => $request->sertifikat ?? 0,
            'status'        => 'pending', // reset ke pending setelah edit
        ];

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('programs', 'public');
        }

        $program->update($data);

        return redirect()->back()
            ->with('success', 'Kurikulum berhasil diperbarui.')
            ->with('active_page', 'program');
    }

    public function index()
{
    $user = Auth::user();

    $pelatihanList = Program::where('trainer_id', $user->id)->latest()->get();
    $eventList     = Event::where('trainer_id', $user->id)->latest()->get();

    // ── Tambah ini ──
    $totalKurikulum = $pelatihanList->where('tipe', 'kurikulum')->count();
    $totalMateri    = $pelatihanList->where('tipe', 'materi')->count();

    $totalPelatihan        = $pelatihanList->count();
    $pelatihanDisetujui    = $pelatihanList->where('status', 'approved')->count();
    $pendingPelatihanCount = $pelatihanList->where('status', 'pending')->count();
    $totalEvent            = $eventList->count();
    $pendingEventCount     = $eventList->where('status', 'pending')->count();
    $pendingTotal          = $pendingPelatihanCount + $pendingEventCount;

    $recentSubmissions = $pelatihanList
        ->map(fn($item) => tap(clone $item, fn($i) => $i->jenis = 'Program'))
        ->concat(
            $eventList->map(fn($item) => tap(clone $item, fn($i) => $i->jenis = 'Event'))
        )
        ->sortByDesc('created_at')
        ->take(5);

    return view('trainer.dashboard', compact(
        'user',
        'totalKurikulum',   // ── tambah
        'totalMateri',      // ── tambah
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

    // ─────────────────────────────────────────────────────────────
    // STORE MATERI
    // ─────────────────────────────────────────────────────────────
    public function storeMateri(Request $request)
    {
        $request->validate([
            'judul'          => 'required|string|max:255',
            'kurikulum_id'   => 'required|exists:programs,id',
            'deskripsi'      => 'nullable|string|max:500',
            'tipe_konten'    => 'required|in:teks,video,file',
            'konten_materi'  => 'nullable|string',
            'link_video'     => 'nullable|url',
            'file_materi'    => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip|max:20480',
            'durasi'         => 'nullable|integer|min:1',
            'urutan'         => 'nullable|integer|min:1',
        ]);

        // Pastikan kurikulum_id milik trainer ini
        $kurikulum = Program::where('id', $request->kurikulum_id)
            ->where('trainer_id', Auth::id())
            ->where('tipe', 'kurikulum')
            ->firstOrFail();

        $data = [
            'trainer_id'    => Auth::id(),
            'tipe'          => 'materi',
            'slug'          => Str::slug($request->judul) . '-' . Str::random(6),
            'judul'         => $request->judul,
            'deskripsi'     => $request->deskripsi,
            'konten_materi' => $request->konten_materi,
            'link_video'    => $request->link_video,
            'durasi'        => $request->durasi,
            'urutan'        => $request->urutan,
            'kurikulum_id'  => $request->kurikulum_id,
            // simpan tipe_konten di kolom metode (reuse) atau tambah kolom baru
            'metode'        => $request->tipe_konten,
            'bahasa'        => 'Bahasa Indonesia',
            'status'        => 'pending',
        ];

        if ($request->hasFile('file_materi')) {
            $data['file_materi'] = $request->file('file_materi')->store('materi', 'public');
        }

        Program::create($data);

        return redirect()->back()
            ->with('success', 'Materi berhasil ditambahkan, menunggu persetujuan admin.')
            ->with('active_page', 'program');
    }

    // ─────────────────────────────────────────────────────────────
    // UPDATE MATERI
    // ─────────────────────────────────────────────────────────────
    public function updateMateri(Request $request, $id)
    {
        $materi = Program::where('id', $id)
            ->where('trainer_id', Auth::id())
            ->where('tipe', 'materi')
            ->firstOrFail();

        $request->validate([
            'judul'         => 'required|string|max:255',
            'kurikulum_id'  => 'required|exists:programs,id',
            'deskripsi'     => 'nullable|string|max:500',
            'tipe_konten'   => 'required|in:teks,video,file',
            'konten_materi' => 'nullable|string',
            'link_video'    => 'nullable|url',
            'file_materi'   => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip|max:20480',
            'durasi'        => 'nullable|integer|min:1',
            'urutan'        => 'nullable|integer|min:1',
        ]);

        $data = [
            'judul'         => $request->judul,
            'deskripsi'     => $request->deskripsi,
            'konten_materi' => $request->konten_materi,
            'link_video'    => $request->link_video,
            'durasi'        => $request->durasi,
            'urutan'        => $request->urutan,
            'kurikulum_id'  => $request->kurikulum_id,
            'metode'        => $request->tipe_konten,
            'status'        => 'pending',
        ];

        if ($request->hasFile('file_materi')) {
            $data['file_materi'] = $request->file('file_materi')->store('materi', 'public');
        }

        $materi->update($data);

        return redirect()->back()
            ->with('success', 'Materi berhasil diperbarui.')
            ->with('active_page', 'program');
    }

    // ─────────────────────────────────────────────────────────────
    // DESTROY (kurikulum atau materi)
    // ─────────────────────────────────────────────────────────────
    public function destroy($id)
    {
        $program = Program::where('id', $id)
            ->where('trainer_id', Auth::id())
            ->firstOrFail();

        $program->delete();

        return redirect()->back()
            ->with('success', ucfirst($program->tipe) . ' berhasil dihapus.')
            ->with('active_page', 'program');
    }
}