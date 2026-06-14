<?php

namespace App\Http\Controllers;

use App\Models\Dokumentasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    // ── Halaman publik ──────────────────────────────────────────
    public function index(Request $request)
    {
        $query = Dokumentasi::where('is_published', true)->latest('tanggal_kegiatan');

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }
        if ($request->filled('q')) {
            $query->where('judul', 'like', '%' . $request->q . '%');
        }

        $items = $query->paginate(12)->withQueryString();

        return view('media.index', compact('items'));
    }

    // ── ADMIN: list ──────────────────────────────────────────────
    public function adminIndex()
    {
        $items = Dokumentasi::latest()->paginate(15);
        return view('admin.dokumentasi.index', compact('items'));
    }

    // ── ADMIN: form tambah ───────────────────────────────────────
    public function adminCreate()
    {
        return view('admin.dokumentasi.form', ['item' => null]);
    }

    // ── ADMIN: simpan ────────────────────────────────────────────
    public function adminStore(Request $request)
    {
        $request->validate([
            'judul'            => 'required|string|max:255',
            'deskripsi'        => 'nullable|string',
            'tanggal_kegiatan' => 'required|date',
            'kategori'         => 'required|in:foto,video',
            'thumbnail'        => 'nullable|image|max:2048',
            'foto.*'           => 'nullable|image|max:3072',
            'youtube_url'      => 'nullable|url',
        ]);

        $data = $request->only(['judul', 'deskripsi', 'tanggal_kegiatan', 'kategori', 'youtube_url']);
        $data['is_published'] = $request->boolean('is_published', true);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('dokumentasi/thumbnail', 'public');
        }

        if ($request->hasFile('foto')) {
            $paths = [];
            foreach ($request->file('foto') as $file) {
                $paths[] = $file->store('dokumentasi/foto', 'public');
            }
            $data['foto'] = $paths;
        }

        Dokumentasi::create($data);

        return redirect()->route('admin.dokumentasi.index')->with('success', 'Dokumentasi berhasil ditambahkan.');
    }

    // ── ADMIN: form edit ─────────────────────────────────────────
    public function adminEdit(Dokumentasi $dokumentasi)
    {
        return view('admin.dokumentasi.form', ['item' => $dokumentasi]);
    }

    // ── ADMIN: update ────────────────────────────────────────────
    public function adminUpdate(Request $request, Dokumentasi $dokumentasi)
    {
        $request->validate([
            'judul'            => 'required|string|max:255',
            'deskripsi'        => 'nullable|string',
            'tanggal_kegiatan' => 'required|date',
            'kategori'         => 'required|in:foto,video',
            'thumbnail'        => 'nullable|image|max:2048',
            'foto.*'           => 'nullable|image|max:3072',
            'youtube_url'      => 'nullable|url',
        ]);

        $data = $request->only(['judul', 'deskripsi', 'tanggal_kegiatan', 'kategori', 'youtube_url']);
        $data['is_published'] = $request->boolean('is_published', true);

        if ($request->hasFile('thumbnail')) {
            if ($dokumentasi->thumbnail) Storage::disk('public')->delete($dokumentasi->thumbnail);
            $data['thumbnail'] = $request->file('thumbnail')->store('dokumentasi/thumbnail', 'public');
        }

        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($dokumentasi->foto) {
                foreach ($dokumentasi->foto as $lama) Storage::disk('public')->delete($lama);
            }
            $paths = [];
            foreach ($request->file('foto') as $file) {
                $paths[] = $file->store('dokumentasi/foto', 'public');
            }
            $data['foto'] = $paths;
        }

        $dokumentasi->update($data);

        return redirect()->route('admin.dokumentasi.index')->with('success', 'Dokumentasi berhasil diperbarui.');
    }

    // ── ADMIN: hapus ─────────────────────────────────────────────
    public function adminDestroy(Dokumentasi $dokumentasi)
    {
        if ($dokumentasi->thumbnail) Storage::disk('public')->delete($dokumentasi->thumbnail);
        if ($dokumentasi->foto) {
            foreach ($dokumentasi->foto as $f) Storage::disk('public')->delete($f);
        }
        $dokumentasi->delete();

        return back()->with('success', 'Dokumentasi dihapus.');
    }
}