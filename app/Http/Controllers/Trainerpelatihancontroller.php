<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class Trainerpelatihancontroller extends Controller
{
    public function storeKurikulum(Request $request)
    {
        $request->validate([
            'judul'           => 'required|string|max:255',
            'deskripsi'       => 'nullable|string|max:500',
            'metode'          => 'nullable|in:online,offline,hybrid',
            'tingkat'         => 'nullable|in:pemula,menengah,lanjut',
            'bahasa'          => 'nullable|string|max:100',
            'jumlah_materi'   => 'nullable|integer|min:0',
            'total_jam'       => 'nullable|numeric|min:0',
            'jumlah_sesi'     => 'nullable|integer|min:0',
            'sertifikat'      => 'nullable|in:0,1',
            'gambar'          => 'nullable|image|max:5120',
            'absensi_aktif'   => 'nullable',
            'absensi_mulai'   => 'nullable|date',
            'absensi_selesai' => 'nullable|date|after:absensi_mulai',
            'absensi_url'     => 'nullable|url|max:500',
        ]);

        // ✅ BENAR: gunakan variabel $absensiAktif secara konsisten
        $absensiAktif = $request->input('absensi_aktif') == '1';

        $data = [
            'trainer_id'      => Auth::id(),
            'tipe'            => 'kurikulum',
            'judul'           => $request->judul,
            'deskripsi'       => $request->deskripsi,
            'metode'          => $request->metode,
            'tingkat'         => $request->tingkat,
            'bahasa'          => $request->bahasa ?? 'Bahasa Indonesia',
            'jumlah_materi'   => $request->jumlah_materi,
            'total_jam'       => $request->total_jam,
            'jumlah_sesi'     => $request->jumlah_sesi,
            'phone'           => $request->phone,
            'sertifikat'      => $request->sertifikat ?? 0,
            'status'          => 'pending',
            // ✅ TAMBAHAN: absensi_aktif wajib ikut disimpan
            'absensi_aktif'   => $absensiAktif,
            'absensi_mulai'   => $absensiAktif ? $request->absensi_mulai   : null,
            'absensi_selesai' => $absensiAktif ? $request->absensi_selesai : null,
            'absensi_url'     => $absensiAktif ? $request->absensi_url     : null,
        ];

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('programs', 'public');
        }

        Program::create($data);

        return redirect()->back()
            ->with('success', 'Kurikulum berhasil diajukan.')
            ->with('active_page', 'program');
    }

    public function updateKurikulum(Request $request, $id)
    {
        $program = Program::where('id', $id)
            ->where('trainer_id', Auth::id())
            ->where('tipe', 'kurikulum')
            ->firstOrFail();

        $request->validate([
            'judul'           => 'required|string|max:255',
            'deskripsi'       => 'nullable|string|max:500',
            'metode'          => 'nullable|in:online,offline,hybrid',
            'tingkat'         => 'nullable|in:pemula,menengah,lanjut',
            'bahasa'          => 'nullable|string|max:100',
            'jumlah_materi'   => 'nullable|integer|min:0',
            'total_jam'       => 'nullable|numeric|min:0',
            'jumlah_sesi'     => 'nullable|integer|min:0',
            'sertifikat'      => 'nullable|in:0,1',
            'gambar'          => 'nullable|image|max:5120',
            'phone'           => 'nullable|string|max:20',
            // ✅ TAMBAHAN: validasi absensi di update
            'absensi_aktif'   => 'nullable',
            'absensi_mulai'   => 'nullable|date',
            'absensi_selesai' => 'nullable|date|after:absensi_mulai',
            'absensi_url'     => 'nullable|url|max:500',
        ]);

        // ✅ TAMBAHAN: sama seperti store
        $absensiAktif = $request->input('absensi_aktif') == '1';

        $data = [
            'judul'           => $request->judul,
            'deskripsi'       => $request->deskripsi,
            'metode'          => $request->metode,
            'tingkat'         => $request->tingkat,
            'bahasa'          => $request->bahasa ?? 'Bahasa Indonesia',
            'jumlah_materi'   => $request->jumlah_materi,
            'total_jam'       => $request->total_jam,
            'jumlah_sesi'     => $request->jumlah_sesi,
            'phone'           => $request->phone,
            'sertifikat'      => $request->sertifikat ?? 0,
            // ✅ TAMBAHAN: absensi masuk ke update
            'absensi_aktif'   => $absensiAktif,
            'absensi_mulai'   => $absensiAktif ? $request->absensi_mulai   : null,
            'absensi_selesai' => $absensiAktif ? $request->absensi_selesai : null,
            'absensi_url'     => $absensiAktif ? $request->absensi_url     : null,
        ];

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('programs', 'public');
        }

        $program->update($data);

        return redirect()->back()
            ->with('success', 'Kurikulum berhasil diperbarui.')
            ->with('active_page', 'program');
    }

    // updateModul, storeModul, destroy — tidak perlu diubah
    public function updateModul(Request $request, $id)
    {
        $modul = Program::where('id', $id)
            ->where('trainer_id', Auth::id())
            ->where('tipe', 'modul')
            ->firstOrFail();

        $request->validate([
            'kurikulum_id' => 'required|exists:programs,id',
            'judul'        => 'required|string|max:255',
            'deskripsi'    => 'nullable|string|max:500',
            'urutan'       => 'nullable|integer|min:1',
        ]);

        $modul->update([
            'judul'        => $request->judul,
            'deskripsi'    => $request->deskripsi,
            'urutan'       => $request->urutan,
            'kurikulum_id' => $request->kurikulum_id,
        ]);

        return redirect()->back()
            ->with('success', 'Modul berhasil diperbarui.')
            ->with('active_page', 'program');
    }

    public function storeModul(Request $request)
    {
        $request->validate([
            'kurikulum_id' => 'required|exists:programs,id',
            'judul'        => 'required|string|max:255',
            'deskripsi'    => 'nullable|string|max:500',
            'urutan'       => 'nullable|integer|min:1',
        ]);

        Program::where('id', $request->kurikulum_id)
            ->where('trainer_id', Auth::id())
            ->where('tipe', 'kurikulum')
            ->firstOrFail();

        Program::create([
            'trainer_id'   => Auth::id(),
            'tipe'         => 'modul',
            'judul'        => $request->judul,
            'deskripsi'    => $request->deskripsi,
            'urutan'       => $request->urutan,
            'kurikulum_id' => $request->kurikulum_id,
            'bahasa'       => 'Bahasa Indonesia',
            'status'       => 'pending',
        ]);

        return redirect()->back()
            ->with('success', 'Modul berhasil ditambahkan.')
            ->with('active_page', 'program');
    }

    public function destroy($id)
    {
        $program = Program::where('id', $id)
            ->where('trainer_id', Auth::id())
            ->firstOrFail();

        $label = $program->tipe === 'modul' ? 'Modul' : ucfirst($program->tipe);
        $program->delete();

        return redirect()->back()
            ->with('success', $label . ' berhasil dihapus.')
            ->with('active_page', 'program');
    }
}