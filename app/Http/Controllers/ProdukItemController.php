<?php
// app/Http/Controllers/ProdukItemController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\ProdukItem;
use App\Models\Produk;

class ProdukItemController extends Controller
{
    // ── Tambah produk item baru ──────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'kategori' => 'nullable|string',
            'deskripsi'=> 'nullable|string',
            'harga'    => 'nullable|integer|min:0',
            'stok'     => 'nullable|string|max:100',
            'satuan'   => 'nullable|string|max:50',
            'foto'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        // Pastikan user punya profil UMKM yang approved
        $umkm = Produk::where('user_id', Auth::id())
                       ->where('status', 'approved')
                       ->latest()->first();

        if (!$umkm) {
            return back()->with('error', 'Profil UMKM Anda belum disetujui admin.');
        }

        $data = [
            'produk_id' => $umkm->id,
            'user_id'   => Auth::id(),
            'nama'      => $request->nama,
            'kategori'  => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'harga'     => $request->harga ?? 0,
            'stok'      => $request->stok,
            'satuan'    => $request->satuan,
        ];

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('produk-items', 'public');
        }

        ProdukItem::create($data);

        return back()->with('success', 'Produk berhasil ditambahkan!');
    }

    // ── Edit produk item ─────────────────────────────────────
    public function update(Request $request, $id)
    {
        $item = ProdukItem::where('id', $id)
                           ->where('user_id', Auth::id())
                           ->firstOrFail();

        $request->validate([
            'nama'     => 'required|string|max:255',
            'kategori' => 'nullable|string',
            'deskripsi'=> 'nullable|string',
            'harga'    => 'nullable|integer|min:0',
            'stok'     => 'nullable|string|max:100',
            'satuan'   => 'nullable|string|max:50',
            'foto'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $data = [
            'nama'      => $request->nama,
            'kategori'  => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'harga'     => $request->harga ?? 0,
            'stok'      => $request->stok,
            'satuan'    => $request->satuan,
        ];

        if ($request->hasFile('foto')) {
            if ($item->foto) Storage::disk('public')->delete($item->foto);
            $data['foto'] = $request->file('foto')->store('produk-items', 'public');
        }

        $item->update($data);

        return back()->with('success', 'Produk berhasil diperbarui!');
    }

    // ── Hapus produk item ────────────────────────────────────
    public function destroy($id)
    {
        $item = ProdukItem::where('id', $id)
                           ->where('user_id', Auth::id())
                           ->firstOrFail();

        if ($item->foto) Storage::disk('public')->delete($item->foto);
        $item->delete();

        return back()->with('success', 'Produk berhasil dihapus.');
    }

    // ── Set produk ini jadi unggulan ─────────────────────────
    public function setUnggulan($id)
    {
        $item = ProdukItem::where('id', $id)
                           ->where('user_id', Auth::id())
                           ->firstOrFail();

        // Reset semua produk user ini dulu, baru set yang dipilih
        ProdukItem::where('user_id', Auth::id())
                   ->update(['is_unggulan' => false]);

        $item->update(['is_unggulan' => true]);

        return back()->with('success', "\"$item->nama\" dijadikan produk unggulan! ⭐");
    }

    // ── Lepas status unggulan ────────────────────────────────
    public function unsetUnggulan($id)
    {
        $item = ProdukItem::where('id', $id)
                           ->where('user_id', Auth::id())
                           ->firstOrFail();

        $item->update(['is_unggulan' => false]);

        return back()->with('success', 'Status unggulan dilepas.');
    }
}