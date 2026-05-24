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

        {{-- ======================== BANNER STATUS ======================== --}}
        @if ($trainer?->status === 'pending')
            <div class="mt-6 p-4 bg-yellow-50 border-l-4 border-yellow-400 text-yellow-800 rounded-r-xl flex items-start gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <p class="font-bold text-sm">Pendaftaran Sedang Ditinjau</p>
                    <p class="text-xs mt-1">Data kamu sudah diterima dan sedang dalam proses review oleh Admin. Kamu tidak bisa mengubah data saat ini.</p>
                </div>
            </div>
        @elseif ($trainer?->status === 'rejected')
            <div class="mt-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-800 rounded-r-xl flex items-start gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <p class="font-bold text-sm">Pendaftaran Ditolak</p>
                    @if ($trainer->rejection_reason)
                        <p class="text-xs mt-1">Alasan: <span class="font-semibold">{{ $trainer->rejection_reason }}</span></p>
                    @endif
                    <p class="text-xs mt-1 text-red-600">Silakan perbaiki data di bawah dan kirim ulang.</p>
                </div>
            </div>
        @endif

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

        <div class="bg-white p-8 mt-6 rounded-xl shadow-md border border-gray-200">
        <form action="{{ route('profile.simpan-trainer') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6"
            @if ($trainer?->status === 'pending') onsubmit="return false;" @endif>
            @csrf

            {{-- ======================== NAMA LENGKAP & GELAR ======================== --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap & Gelar Akademik *</label>
                <input type="text" name="academic_degree"
                    value="{{ old('academic_degree', $trainer?->academic_degree) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition"
                    required placeholder="Contoh: Martin Louis, S.E., M.M."
                    @if ($trainer?->status === 'pending') readonly @endif>
            </div>

            {{-- ======================== KONTAK ======================== --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">No. WhatsApp *</label>
                    {{-- PERBAIKAN: name="phone" → name="no_hp" --}}
                    <input type="text" name="no_hp"
                        value="{{ old('no_hp', $trainer?->no_hp ?? $user->phone) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition"
                        required
                        @if ($trainer?->status === 'pending') readonly @endif>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Email Aktif *</label>
                    <input type="email" name="email"
                        value="{{ old('email', $trainer?->email ?? $user->email) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition"
                        required
                        @if ($trainer?->status === 'pending') readonly @endif>
                </div>
            </div>

            {{-- ======================== NIK & NPWP ======================== --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor NIK/KTP *</label>
                    <input type="text" name="nik"
                        value="{{ old('nik', $trainer?->nik) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition"
                        required
                        @if ($trainer?->status === 'pending') readonly @endif>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">NPWP <span class="text-gray-400 font-normal">(Opsional)</span></label>
                    <input type="text" name="npwp"
                        value="{{ old('npwp', $trainer?->npwp) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition"
                        @if ($trainer?->status === 'pending') readonly @endif>
                </div>
            </div>

            {{-- ======================== ALAMAT DOMISILI ======================== --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat Domisili Sekarang *</label>
                <input type="text" name="gmaps_location"
                    value="{{ old('gmaps_location', $trainer?->gmaps_location) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition"
                    required placeholder="Contoh: Jl. Raya Darmo No.1, RT 03/RW 05, Wonokromo, Surabaya, Jawa Timur 60241"
                    @if ($trainer?->status === 'pending') readonly @endif>
                <p class="text-[10px] text-gray-400 mt-1">*wajib sertakan RT/RW dan kode pos</p>
            </div>

            {{-- ======================== WILAYAH DROPDOWN ======================== --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Provinsi *</label>
                    <select name="provinsi" id="provinsi"
                        data-selected="{{ old('provinsi', $trainer?->provinsi) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition bg-white"
                        required
                        @if ($trainer?->status === 'pending') disabled @endif>
                        <option value="">Pilih Provinsi</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Kabupaten / Kota *</label>
                    <select name="kabupaten" id="kabupaten"
                        data-selected="{{ old('kabupaten', $trainer?->kabupaten) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition bg-white"
                        required disabled>
                        <option value="">Pilih Kabupaten/Kota</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Kecamatan *</label>
                    <select name="kecamatan" id="kecamatan"
                        data-selected="{{ old('kecamatan', $trainer?->kecamatan) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition bg-white"
                        required disabled>
                        <option value="">Pilih Kecamatan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Desa / Kelurahan *</label>
                    <select name="kelurahan" id="kelurahan"
                        data-selected="{{ old('kelurahan', $trainer?->kelurahan) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition bg-white"
                        required disabled>
                        <option value="">Pilih Desa/Kelurahan</option>
                    </select>
                </div>
            </div>

            {{-- ======================== IJAZAH & DRIVE LINK ======================== --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Ijazah Akademik Terakhir *</label>
                    <select name="ijazah_type" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition"
                        @if ($trainer?->status === 'pending') disabled @endif>
                        @php $selectedIjazah = old('ijazah_type', $trainer?->ijazah_type) @endphp
                        <option value="SMA" {{ $selectedIjazah == 'SMA' ? 'selected' : '' }}>SMA/SMK SEDERAJAT</option>
                        <option value="D3"  {{ $selectedIjazah == 'D3'  ? 'selected' : '' }}>D3</option>
                        <option value="S1"  {{ $selectedIjazah == 'S1'  ? 'selected' : '' }}>S1</option>
                        <option value="S2"  {{ $selectedIjazah == 'S2'  ? 'selected' : '' }}>S2</option>
                        <option value="S3"  {{ $selectedIjazah == 'S3'  ? 'selected' : '' }}>S3</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Link Drive Dokumentasi Pendampingan *</label>
                    {{-- PERBAIKAN: name="drive_link" → name="drive_link_documentation" --}}
                    <input type="url" name="drive_link_documentation"
                        value="{{ old('drive_link_documentation', $trainer?->drive_link_documentation) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition"
                        placeholder="https://drive.google.com/..." required
                        @if ($trainer?->status === 'pending') readonly @endif>
                </div>
            </div>

            {{-- ======================== PENGALAMAN ======================== --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Pengalaman Sebagai Trainer *</label>
                <textarea name="experience" rows="3" required
                    placeholder="Berapa lama anda menjadi Trainer..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition"
                    @if ($trainer?->status === 'pending') readonly @endif>{{ old('experience', $trainer?->experience) }}</textarea>
            </div>

            {{-- ======================== BIO ======================== --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Tentang Diri Anda (Singkat) *</label>
                <textarea name="bio" rows="3" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition"
                    @if ($trainer?->status === 'pending') readonly @endif>{{ old('bio', $trainer?->bio) }}</textarea>
            </div>

            {{-- ======================== UPLOAD DOKUMEN ======================== --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6 bg-gray-50 rounded-2xl border border-dashed border-gray-300">

                {{-- KTP --}}
                <div class="space-y-3">
                    <label class="block text-sm font-medium text-gray-700">Scan KTP <span class="text-red-500">*</span></label>
                    <p class="text-xs text-gray-500">Upload 1 file yang didukung (JPG, PNG, PDF). Maks 2 MB.</p>
                    @if ($trainer?->ktp_scan)
                        <p class="text-xs text-emerald-600 italic">✓ File sudah diupload sebelumnya</p>
                    @endif
                    <div class="relative">
                        <input type="file" name="ktp_scan" id="file-ktp" class="hidden" accept="image/*,.pdf"
                            {{ !$trainer?->ktp_scan ? 'required' : '' }}
                            onchange="updateFileName(this, 'name-ktp')"
                            @if ($trainer?->status === 'pending') disabled @endif>
                        <button type="button" onclick="document.getElementById('file-ktp').click()"
                                @if ($trainer?->status === 'pending') disabled @endif
                                class="flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-md bg-white text-blue-600 font-medium text-sm hover:bg-blue-50 transition shadow-sm disabled:opacity-50 disabled:cursor-not-allowed">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                            {{ $trainer?->ktp_scan ? 'Ganti file' : 'Tambahkan file' }}
                        </button>
                        <p id="name-ktp" class="text-xs text-emerald-600 mt-2 font-medium italic"></p>
                    </div>
                </div>

                {{-- BNSP --}}
                <div class="space-y-3">
                    <label class="block text-sm font-medium text-gray-700">Sertifikat BNSP <span class="text-red-500">*</span></label>
                    <p class="text-xs text-gray-500">Upload 1 file yang didukung (JPG, PNG, PDF). Maks 2 MB.</p>
                    @if ($trainer?->bnsp_certificate)
                        <p class="text-xs text-emerald-600 italic">✓ File sudah diupload sebelumnya</p>
                    @endif
                    <div class="relative">
                        <input type="file" name="bnsp_certificate" id="file-bnsp" class="hidden" accept="image/*,.pdf"
                            {{ !$trainer?->bnsp_certificate ? 'required' : '' }}
                            onchange="updateFileName(this, 'name-bnsp')"
                            @if ($trainer?->status === 'pending') disabled @endif>
                        <button type="button" onclick="document.getElementById('file-bnsp').click()"
                                @if ($trainer?->status === 'pending') disabled @endif
                                class="flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-md bg-white text-blue-600 font-medium text-sm hover:bg-blue-50 transition shadow-sm disabled:opacity-50 disabled:cursor-not-allowed">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                            {{ $trainer?->bnsp_certificate ? 'Ganti file' : 'Tambahkan file' }}
                        </button>
                        <p id="name-bnsp" class="text-xs text-emerald-600 mt-2 font-medium italic"></p>
                    </div>
                </div>

                {{-- Pas Foto --}}
                <div class="space-y-3">
                    <label class="block text-sm font-medium text-gray-700">Pas Foto Background Putih <span class="text-red-500">*</span></label>
                    <p class="text-xs text-gray-500">Upload 1 file yang didukung (JPG, PNG). Maks 2 MB.</p>
                    @if ($trainer?->white_bg_photo)
                        <p class="text-xs text-emerald-600 italic">✓ File sudah diupload sebelumnya</p>
                    @endif
                    <div class="relative">
                        <input type="file" name="white_bg_photo" id="file-pasfoto" class="hidden" accept="image/*"
                            {{ !$trainer?->white_bg_photo ? 'required' : '' }}
                            onchange="updateFileName(this, 'name-pasfoto')"
                            @if ($trainer?->status === 'pending') disabled @endif>
                        <button type="button" onclick="document.getElementById('file-pasfoto').click()"
                                @if ($trainer?->status === 'pending') disabled @endif
                                class="flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-md bg-white text-blue-600 font-medium text-sm hover:bg-blue-50 transition shadow-sm disabled:opacity-50 disabled:cursor-not-allowed">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                            {{ $trainer?->white_bg_photo ? 'Ganti file' : 'Tambahkan file' }}
                        </button>
                        <p id="name-pasfoto" class="text-xs text-emerald-600 mt-2 font-medium italic"></p>
                    </div>
                </div>

            </div>

            {{-- ======================== BIAYA PENDAFTARAN ======================== --}}
            <div class="p-6 rounded-xl border border-gray-200 space-y-4 bg-white">
                <div>
                    <h3 class="text-sm font-bold text-gray-800">Biaya Pendaftaran Trainer</h3>
                    <p class="text-sm text-gray-600 mt-1 leading-relaxed">
                        Silahkan transfer biaya pendaftaran sebesar <span class="font-bold text-gray-900">Rp200.000</span> ke rekening berikut, lalu unggah bukti transfer di bawah.
                    </p>
                </div>

                {{-- Info Rekening --}}
                <div class="rounded-xl border border-gray-200 overflow-hidden">
                    <table class="w-full text-sm">
                        <tbody>
                            <tr class="border-b border-gray-100">
                                <td class="px-5 py-3 text-gray-500 font-medium w-36">Bank</td>
                                <td class="px-2 py-3 text-gray-400 w-4">:</td>
                                <td class="px-5 py-3 font-bold text-gray-900">BNI</td>
                            </tr>
                            <tr class="border-b border-gray-100">
                                <td class="px-5 py-3 text-gray-500 font-medium">Atas Nama</td>
                                <td class="px-2 py-3 text-gray-400">:</td>
                                <td class="px-5 py-3 font-bold text-gray-900">ARI PRABOWO</td>
                            </tr>
                            <tr>
                                <td class="px-5 py-3 text-gray-500 font-medium">No. Rekening</td>
                                <td class="px-2 py-3 text-gray-400">:</td>
                                <td class="px-5 py-3">
                                    <div class="flex items-center gap-3">
                                        <span class="font-bold text-gray-900 tracking-wider" id="nomor-rek">873873298</span>
                                        <button type="button" onclick="copyRekening()"
                                            class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-medium text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-md hover:bg-emerald-100 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                            </svg>
                                            <span id="copy-label">Salin</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Upload Bukti Transfer --}}
                <div class="space-y-2 pt-2">
                    <label class="block text-sm font-medium text-gray-700">Bukti Transfer <span class="text-red-500">*</span></label>
                    <p class="text-xs text-gray-500">Upload 1 file yang didukung (JPG, PNG, PDF). Maks 2 MB.</p>
                    @if ($trainer?->bukti_transfer)
                        <p class="text-xs text-emerald-600 italic">✓ File sudah diupload sebelumnya</p>
                    @endif
                    <div class="relative">
                        <input type="file" name="bukti_transfer" id="file-transfer" class="hidden" accept="image/*,.pdf"
                            {{ !$trainer?->bukti_transfer ? 'required' : '' }}
                            onchange="updateFileName(this, 'name-transfer')"
                            @if ($trainer?->status === 'pending') disabled @endif>
                        <button type="button" onclick="document.getElementById('file-transfer').click()"
                                @if ($trainer?->status === 'pending') disabled @endif
                                class="flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-md bg-white text-blue-700 font-medium text-sm hover:bg-gray-50 transition shadow-sm disabled:opacity-50 disabled:cursor-not-allowed">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                            {{ $trainer?->bukti_transfer ? 'Ganti file' : 'Tambahkan file' }}
                        </button>
                        <p id="name-transfer" class="text-xs text-blue-600 mt-2 font-medium italic"></p>
                    </div>
                </div>
            </div>

            {{-- ======================== CHECKBOX PERSETUJUAN ======================== --}}
            <div class="flex items-start gap-3 p-4 bg-gray-50 rounded-xl border border-gray-200">
                <input type="checkbox" name="agree_terms" id="agree_terms" value="1"
                    {{ $trainer?->agree_terms ? 'checked' : 'required' }}
                    class="mt-0.5 h-4 w-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500 cursor-pointer flex-shrink-0"
                    @if ($trainer?->status === 'pending') disabled @endif>
                <label for="agree_terms" class="text-sm text-gray-600 leading-relaxed cursor-pointer">
                    Saya setuju dengan
                    <a href="https://kajiindonesia.com/" target="_blank" class="text-emerald-700 font-semibold underline hover:text-emerald-800">Syarat dan Ketentuan</a>
                    serta
                    <a href="https://kajiindonesia.com/" target="_blank" class="text-emerald-700 font-semibold underline hover:text-emerald-800">Kebijakan Privasi</a>
                    yang berlaku di <span class="font-semibold text-gray-700">KAJI Indonesia</span>.
                </label>
            </div>

            <div class="pt-4">
                @if ($trainer?->status === 'pending')
                    <button type="button" disabled
                        class="w-full bg-gray-400 text-white py-3 rounded-xl font-bold text-lg cursor-not-allowed">
                        Menunggu Verifikasi Admin...
                    </button>
                @else
                    <button type="submit"
                        class="w-full bg-emerald-600 text-white py-3 rounded-xl font-bold text-lg hover:bg-emerald-700 transition shadow-lg shadow-emerald-200">
                        {{ $trainer?->status === 'rejected' ? 'Kirim Ulang Persyaratan' : 'Kirim Seluruh Persyaratan' }}
                    </button>
                @endif
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

    function copyRekening() {
        const noRek = document.getElementById('nomor-rek').textContent.trim();
        const label = document.getElementById('copy-label');
        if (navigator.clipboard) {
            navigator.clipboard.writeText(noRek).then(() => {
                label.textContent = '✓ Tersalin!';
                setTimeout(() => { label.textContent = 'Salin'; }, 2000);
            });
        } else {
            const el = document.createElement('textarea');
            el.value = noRek;
            document.body.appendChild(el);
            el.select();
            document.execCommand('copy');
            document.body.removeChild(el);
            label.textContent = '✓ Tersalin!';
            setTimeout(() => { label.textContent = 'Salin'; }, 2000);
        }
    }

    // ======================== WILAYAH API ========================
    // Mendukung prefill dari $trainer (data lama tersimpan sebagai nama, bukan ID)
    const BASE_URL = 'https://www.emsifa.com/api-wilayah-indonesia/api';

    const provinsiSelect  = document.getElementById('provinsi');
    const kabupatenSelect = document.getElementById('kabupaten');
    const kecamatanSelect = document.getElementById('kecamatan');
    const kelurahanSelect = document.getElementById('kelurahan');

    // Ambil nilai prefill dari data-selected (diisi oleh Blade)
    const savedProvinsi  = provinsiSelect.dataset.selected  || '';
    const savedKabupaten = kabupatenSelect.dataset.selected || '';
    const savedKecamatan = kecamatanSelect.dataset.selected || '';
    const savedKelurahan = kelurahanSelect.dataset.selected || '';

    // Load provinsi, lalu prefill berantai jika ada data lama
    fetch(`${BASE_URL}/provinces.json`)
        .then(res => res.json())
        .then(data => {
            let savedProvId = null;
            data.forEach(prov => {
                const opt = document.createElement('option');
                opt.value = prov.name;
                opt.dataset.id = prov.id;
                opt.textContent = prov.name;
                if (prov.name === savedProvinsi) {
                    opt.selected = true;
                    savedProvId = prov.id;
                }
                provinsiSelect.appendChild(opt);
            });

            // Prefill kabupaten jika ada data lama
            if (savedProvId && savedKabupaten) {
                loadKabupaten(savedProvId, savedKabupaten);
            }
        });

    function loadKabupaten(provinsiId, prefillKab = '') {
        kabupatenSelect.disabled = true;
        fetch(`${BASE_URL}/regencies/${provinsiId}.json`)
            .then(res => res.json())
            .then(data => {
                kabupatenSelect.innerHTML = '<option value="">Pilih Kabupaten/Kota</option>';
                let savedKabId = null;
                data.forEach(kab => {
                    const opt = document.createElement('option');
                    opt.value = kab.name;
                    opt.dataset.id = kab.id;
                    opt.textContent = kab.name;
                    if (kab.name === prefillKab) {
                        opt.selected = true;
                        savedKabId = kab.id;
                    }
                    kabupatenSelect.appendChild(opt);
                });
                kabupatenSelect.disabled = false;
                if (savedKabId && savedKecamatan) {
                    loadKecamatan(savedKabId, savedKecamatan);
                }
            });
    }

    function loadKecamatan(kabupatenId, prefillKec = '') {
        kecamatanSelect.disabled = true;
        fetch(`${BASE_URL}/districts/${kabupatenId}.json`)
            .then(res => res.json())
            .then(data => {
                kecamatanSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
                let savedKecId = null;
                data.forEach(kec => {
                    const opt = document.createElement('option');
                    opt.value = kec.name;
                    opt.dataset.id = kec.id;
                    opt.textContent = kec.name;
                    if (kec.name === prefillKec) {
                        opt.selected = true;
                        savedKecId = kec.id;
                    }
                    kecamatanSelect.appendChild(opt);
                });
                kecamatanSelect.disabled = false;
                if (savedKecId && savedKelurahan) {
                    loadKelurahan(savedKecId, savedKelurahan);
                }
            });
    }

    function loadKelurahan(kecamatanId, prefillKel = '') {
        kelurahanSelect.disabled = true;
        fetch(`${BASE_URL}/villages/${kecamatanId}.json`)
            .then(res => res.json())
            .then(data => {
                kelurahanSelect.innerHTML = '<option value="">Pilih Desa/Kelurahan</option>';
                data.forEach(kel => {
                    const opt = document.createElement('option');
                    opt.value = kel.name;
                    opt.dataset.id = kel.id;
                    opt.textContent = kel.name;
                    if (kel.name === prefillKel) opt.selected = true;
                    kelurahanSelect.appendChild(opt);
                });
                kelurahanSelect.disabled = false;
            });
    }

    // Event listeners untuk user memilih manual
    provinsiSelect.addEventListener('change', function () {
        resetSelect(kabupatenSelect, '-- Pilih Kabupaten/Kota --');
        resetSelect(kecamatanSelect, '-- Pilih Kecamatan --');
        resetSelect(kelurahanSelect, '-- Pilih Desa/Kelurahan --');
        if (!this.value) return;
        const provinsiId = this.options[this.selectedIndex].dataset.id;
        loadKabupaten(provinsiId);
    });

    kabupatenSelect.addEventListener('change', function () {
        resetSelect(kecamatanSelect, '-- Pilih Kecamatan --');
        resetSelect(kelurahanSelect, '-- Pilih Desa/Kelurahan --');
        if (!this.value) return;
        const kabupatenId = this.options[this.selectedIndex].dataset.id;
        loadKecamatan(kabupatenId);
    });

    kecamatanSelect.addEventListener('change', function () {
        resetSelect(kelurahanSelect, '-- Pilih Desa/Kelurahan --');
        if (!this.value) return;
        const kecamatanId = this.options[this.selectedIndex].dataset.id;
        loadKelurahan(kecamatanId);
    });

    function resetSelect(selectEl, placeholder) {
        selectEl.innerHTML = `<option value="">${placeholder}</option>`;
        selectEl.disabled = true;
    }
</script>
@endsection