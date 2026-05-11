@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-10">
    <div class="max-w-4xl mx-auto px-4">

        <div class="mb-6">
            <a href="{{ route('profile') }}" class="inline-flex items-center text-sm font-medium text-emerald-700 hover:text-emerald-800 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Profil
            </a>
        </div>

        <div class="bg-emerald-700 p-8 mt-6 rounded-xl shadow-md border border-gray-200 text-white text-center">
            <h2 class="text-3xl font-bold">Formulir Pendaftaran Trainer</h2>
            <p class="text-emerald-50 text-sm mt-2">Lengkapi data di bawah ini dengan benar untuk ditinjau oleh Admin.</p>
        </div>

        @if ($errors->any())
            <div class="mx-0 mt-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-xl">
                <p class="font-bold text-sm">Ada kesalahan input:</p>
                <ul class="list-disc list-inside text-xs mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white-900 p-8 mt-6 rounded-xl shadow-md border border-gray-200">
        <form action="{{ route('profile.simpan-trainer') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap & Gelar Akademik *</label>
                <input type="text" name="academic_degree" value="{{ old('academic_degree') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition"
                    required placeholder="Contoh: Martin Louis, S.E., M.M.">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">No. WhatsApp *</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition"
                        required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Email Aktif *</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition"
                        required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor NIK/KTP *</label>
                    <input type="text" name="nik" value="{{ old('nik') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition"
                        required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">NPWP <span class="text-gray-400 font-normal">(Opsional)</span></label>
                    <input type="text" name="npwp" value="{{ old('npwp') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat Domisili Sekarang *</label>
                <textarea name="location" rows="2" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition">{{ old('location') }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Ijazah Akademik Terakhir *</label>
                    <select name="ijazah_type" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition">
                        <option value="D3" {{ old('ijazah_type') == 'D3' ? 'selected' : '' }}>D3</option>
                        <option value="S1" {{ old('ijazah_type') == 'S1' ? 'selected' : '' }}>S1</option>
                        <option value="S2" {{ old('ijazah_type') == 'S2' ? 'selected' : '' }}>S2</option>
                        <option value="S3" {{ old('ijazah_type') == 'S3' ? 'selected' : '' }}>S3</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Link Drive Dokumentasi Pendampingan *</label>
                    <input type="url" name="drive_link" value="{{ old('drive_link') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition"
                        placeholder="https://drive.google.com/..." required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Pengalaman Pendampingan UMKM *</label>
                <textarea name="experience" rows="3" required
                    placeholder="Berapa lama anda menjadi pendamping UMKM..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition">{{ old('experience') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Tentang Diri Anda (Singkat) *</label>
                <textarea name="bio" rows="3" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition">{{ old('bio') }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6 bg-gray-50 rounded-2xl border border-dashed border-gray-300">

                <div class="space-y-3">
                    <label class="block text-sm font-medium text-gray-700">Scan KTP <span class="text-red-500">*</span></label>
                    <p class="text-xs text-gray-500">Upload 1 file yang didukung (JPG, PNG, PDF). Maks 2 MB.</p>
                    <div class="relative">
                        <input type="file" name="ktp_scan" id="file-ktp" class="hidden" accept="image/*,.pdf" required onchange="updateFileName(this, 'name-ktp')">
                        <button type="button" onclick="document.getElementById('file-ktp').click()"
                                class="flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-md bg-white text-blue-600 font-medium text-sm hover:bg-blue-50 transition shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                            Tambahkan file
                        </button>
                        <p id="name-ktp" class="text-xs text-emerald-600 mt-2 font-medium italic"></p>
                    </div>
                </div>

                <div class="space-y-3">
                    <label class="block text-sm font-medium text-gray-700">Sertifikat BNSP <span class="text-red-500">*</span></label>
                    <p class="text-xs text-gray-500">Upload 1 file yang didukung (JPG, PNG, PDF). Maks 2 MB.</p>
                    <div class="relative">
                        <input type="file" name="bnsp_certificate" id="file-bnsp" class="hidden" accept="image/*,.pdf" required onchange="updateFileName(this, 'name-bnsp')">
                        <button type="button" onclick="document.getElementById('file-bnsp').click()"
                                class="flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-md bg-white text-blue-600 font-medium text-sm hover:bg-blue-50 transition shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                            Tambahkan file
                        </button>
                        <p id="name-bnsp" class="text-xs text-emerald-600 mt-2 font-medium italic"></p>
                    </div>
                </div>

                <div class="space-y-3">
                    <label class="block text-sm font-medium text-gray-700">Pas Foto Background Putih <span class="text-red-500">*</span></label>
                    <p class="text-xs text-gray-500">Upload 1 file yang didukung (JPG, PNG). Maks 2 MB.</p>
                    <div class="relative">
                        <input type="file" name="white_bg_photo" id="file-pasfoto" class="hidden" accept="image/*" required onchange="updateFileName(this, 'name-pasfoto')">
                        <button type="button" onclick="document.getElementById('file-pasfoto').click()"
                                class="flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-md bg-white text-blue-600 font-medium text-sm hover:bg-blue-50 transition shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                            Tambahkan file
                        </button>
                        <p id="name-pasfoto" class="text-xs text-emerald-600 mt-2 font-medium italic"></p>
                    </div>
                </div>

            </div>

            <div class="pt-4">
                <button type="submit" class="w-full bg-emerald-600 text-white py-3 rounded-xl font-bold text-lg hover:bg-emerald-700 transition shadow-lg shadow-emerald-200">
                    Kirim Seluruh Persyaratan
                </button>
                <p class="text-center text-xs text-gray-400 mt-4 italic">
                    * Pendaftaran akan ditinjau oleh Admin sebelum ditampilkan di halaman Trainer.
                </p>
            </div>

        </form>
        </div>
    </div>
</div>

<script>
    function updateFileName(input, targetId) {
        const fileName = input.files[0] ? input.files[0].name : "";
        const label = document.getElementById(targetId);
        if (fileName) {
            label.textContent = "✓ File terpilih: " + fileName;
        } else {
            label.textContent = "";
        }
    }
</script>
@endsection