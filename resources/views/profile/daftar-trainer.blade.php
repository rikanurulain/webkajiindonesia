@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-4xl mx-auto px-4">
        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="bg-emerald-700 p-8 text-white text-center">
                <h2 class="text-2xl font-bold">Formulir Pendaftaran Trainer</h2>
                <p class="text-emerald-100 text-sm mt-2">Lengkapi data di bawah ini dengan benar untuk ditinjau oleh Admin.</p>
            </div>

            <!-- Menampilkan Pesan Error -->
            @if ($errors->any())
                <div class="mx-8 mt-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-xl">
                    <p class="font-bold text-sm">Ada kesalahan input:</p>
                    <ul class="list-disc list-inside text-xs mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('profile.simpan-trainer') }}" method="POST" enctype="multipart/form-data" class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                @csrf
                
                <!-- 1. Nama & Gelar -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap & Gelar Akademik *</label>
                    <input type="text" name="academic_degree" value="{{ old('academic_degree') }}" class="w-full px-4 py-2 border rounded-xl" required placeholder="Contoh: Martin Louis, S.E., M.M.">
                </div>

                <!-- 2. WhatsApp & 3. Email -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">No. WhatsApp *</label>
                    <!-- Jika ada input sebelumnya pakai old, jika tidak pakai data dari profil -->
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full px-4 py-2 border rounded-xl" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Email Aktif *</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full px-4 py-2 border rounded-xl" required>
                </div>

                <!-- 4. NIK & 5. NPWP -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nomor NIK/KTP *</label>
                    <input type="text" name="nik" value="{{ old('nik') }}" class="w-full px-4 py-2 border rounded-xl" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">NPWP (Opsional)</label>
                    <input type="text" name="npwp" value="{{ old('npwp') }}" class="w-full px-4 py-2 border rounded-xl">
                </div>

                <!-- 6. Domisili -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Alamat Domisili Sekarang *</label>
                    <textarea name="location" rows="2" class="w-full px-4 py-2 border rounded-xl" required>{{ old('location') }}</textarea>
                </div>

                <!-- 7. Jenjang Ijazah -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Ijazah Akademik Terakhir *</label>
                    <select name="ijazah_type" class="w-full px-4 py-2 border rounded-xl" required>
                        <option value="D3" {{ old('ijazah_type') == 'D3' ? 'selected' : '' }}>D3</option>
                        <option value="S1" {{ old('ijazah_type') == 'S1' ? 'selected' : '' }}>S1</option>
                        <option value="S2" {{ old('ijazah_type') == 'S2' ? 'selected' : '' }}>S2</option>
                        <option value="S3" {{ old('ijazah_type') == 'S3' ? 'selected' : '' }}>S3</option>
                    </select>
                </div>

                <!-- 13. Link Drive Dokumentasi -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Link Drive Dokumentasi Pendampingan *</label>
                    <input type="url" name="drive_link" value="{{ old('drive_link') }}" class="w-full px-4 py-2 border rounded-xl" placeholder="https://drive.google.com/..." required>
                </div>

                <!-- 8. Pengalaman & 9. Deskripsi Diri -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Pengalaman Pendampingan UMKM *</label>
                    <textarea name="experience" rows="3" class="w-full px-4 py-2 border rounded-xl" required placeholder="Berapa lama anda menjadi pendamping UMKM...">{{ old('experience') }}</textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Tentang Diri Anda (Singkat) *</label>
                    <textarea name="bio" rows="3" class="w-full px-4 py-2 border rounded-xl" required>{{ old('bio') }}</textarea>
                </div>

                <!-- Section Upload -->
                <div class="md:col-span-2 border-t pt-6 mt-4">
                    <h3 class="font-bold text-gray-800 mb-2">Upload Dokumen (Format: JPG/PNG/PDF)</h3>
                    <p class="text-xs text-red-500 mb-4">* File harus di-upload ulang jika terjadi kesalahan pengiriman form.</p>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
                        <div>
                            <label class="font-bold">Scan KTP *</label>
                            <input type="file" name="ktp_scan" class="mt-1" required>
                        </div>
                        <div>
                            <label class="font-bold">Sertifikat BNSP *</label>
                            <input type="file" name="bnsp_certificate" class="mt-1" required>
                        </div>
                        <div>
                            <label class="font-bold">Pas Foto Background Putih *</label>
                            <input type="file" name="white_bg_photo" class="mt-1" required>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2 pt-8 text-center">
                    <button type="submit" class="w-full bg-emerald-700 text-white py-4 rounded-2xl font-bold hover:bg-emerald-800 transition shadow-lg">
                        Kirim Seluruh Persyaratan
                    </button>
                    <a href="{{ route('profile') }}" class="inline-block mt-4 text-sm text-gray-400 hover:text-gray-600 font-medium">Batal & Kembali ke Profil</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection