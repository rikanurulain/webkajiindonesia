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
            <h2 class="text-3xl font-bold">Formulir Pendaftaran Mentor</h2>
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
        <form action="{{ route('profile.simpan-mentor') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap *</label>
                <input type="text" name="full_name" value="{{ old('full_name', $user->name) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition"
                    required placeholder="Masukkan nama lengkap Anda">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">No. WhatsApp *</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition"
                        required placeholder="Contoh: 08123456789">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Email Aktif *</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition"
                        required>
                </div>
            </div>

            {{-- ======================== LOKASI TINGGAL ======================== --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Lokasi Tinggal (Sesuai Google Maps) *</label>
                <input type="text" name="gmaps_location" value="{{ old('gmaps_location') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition"
                    required placeholder="Contoh: Jl. Raya Darmo No.1, RT 03/RW 05, Wonokromo, Surabaya, Jawa Timur 60241">
                <p class="text-[10px] text-gray-400 mt-1">💡 Salin alamat lengkap dari Google Maps agar mudah ditemukan.</p>
                <p class="text-[10px] text-red-400 mt-0.5 font-medium">⚠️ Wajib menyertakan RT/RW dan kode pos.</p>
            </div>

            {{-- ======================== WILAYAH ======================== --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Provinsi *</label>
                    <select name="provinsi" id="provinsi"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition bg-white"
                        required>
                        <option value="">-- Pilih Provinsi --</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Kabupaten / Kota *</label>
                    <select name="kabupaten" id="kabupaten"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition bg-white"
                        required disabled>
                        <option value="">-- Pilih Kabupaten/Kota --</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Kecamatan *</label>
                    <select name="kecamatan" id="kecamatan"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition bg-white"
                        required disabled>
                        <option value="">-- Pilih Kecamatan --</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Desa / Kelurahan *</label>
                    <select name="kelurahan" id="kelurahan"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition bg-white"
                        required disabled>
                        <option value="">-- Pilih Desa/Kelurahan --</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Tentang Diri Anda *</label>
                <textarea name="bio" rows="4" required
                    placeholder="Ceritakan latar belakang, keahlian, dan motivasi Anda menjadi mentor UMKM..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition">{{ old('bio') }}</textarea>
            </div>

            {{-- ======================== UPLOAD DOKUMEN ======================== --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-6 bg-gray-50 rounded-2xl border border-dashed border-gray-300">

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

            </div>

            {{-- ======================== BUKTI TRANSFER ======================== --}}
            <div class="p-6 bg-amber-50 rounded-2xl border border-amber-200 space-y-4">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-9 h-9 bg-amber-100 rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-amber-800">Biaya Pendaftaran Mentor</h3>
                        <p class="text-sm text-amber-700 mt-1 leading-relaxed">
                            Biaya pendaftaran mentor sebesar <span class="font-bold">Rp100.000</span>. Silahkan lakukan pembayaran ke rekening:
                        </p>
                        <div class="mt-3 bg-white border border-amber-200 rounded-xl px-4 py-3 inline-flex flex-col gap-1 shadow-sm">
                            <div class="flex items-center gap-2 text-sm text-gray-700">
                                <span class="text-gray-400 font-medium w-20">Bank</span>
                                <span class="font-bold text-gray-900">BNI</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-700">
                                <span class="text-gray-400 font-medium w-20">Atas Nama</span>
                                <span class="font-bold text-gray-900">ARI PRABOWO</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-700">
                                <span class="text-gray-400 font-medium w-20">No. Rekening</span>
                                <span class="font-bold text-gray-900 tracking-wider">4975 8348</span>
                                <button type="button" onclick="copyRekening()" title="Salin nomor rekening"
                                    class="ml-1 text-emerald-600 hover:text-emerald-700 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                </button>
                                <span id="copy-msg" class="text-xs text-emerald-600 font-medium hidden">Tersalin!</span>
                            </div>
                        </div>
                        <p class="text-xs text-amber-600 mt-3">Lalu unggah bukti transfer di bawah ini.</p>
                    </div>
                </div>

                <div class="space-y-2 mt-2">
                    <label class="block text-sm font-medium text-gray-700">Bukti Transfer <span class="text-red-500">*</span></label>
                    <p class="text-xs text-gray-500">Upload 1 file yang didukung (JPG, PNG, PDF). Maks 2 MB.</p>
                    <div class="relative">
                        <input type="file" name="bukti_transfer" id="file-transfer" class="hidden" accept="image/*,.pdf" required onchange="updateFileName(this, 'name-transfer')">
                        <button type="button" onclick="document.getElementById('file-transfer').click()"
                                class="flex items-center gap-2 px-4 py-2 border border-amber-300 rounded-md bg-white text-amber-700 font-medium text-sm hover:bg-amber-50 transition shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                            Tambahkan file
                        </button>
                        <p id="name-transfer" class="text-xs text-emerald-600 mt-2 font-medium italic"></p>
                    </div>
                </div>
            </div>

            {{-- ======================== CHECKBOX PERSETUJUAN ======================== --}}
            <div class="flex items-start gap-3 p-4 bg-gray-50 rounded-xl border border-gray-200">
                <input type="checkbox" name="agree_terms" id="agree_terms" required value="1"
                    class="mt-0.5 h-4 w-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500 cursor-pointer flex-shrink-0">
                <label for="agree_terms" class="text-sm text-gray-600 leading-relaxed cursor-pointer">
                    Saya setuju dengan
                    <a href="https://kajiindonesia.com/" target="_blank" class="text-emerald-700 font-semibold underline hover:text-emerald-800">Syarat dan Ketentuan</a>
                    serta
                    <a href="https://kajiindonesia.com/" target="_blank" class="text-emerald-700 font-semibold underline hover:text-emerald-800">Kebijakan Privasi</a>
                    yang berlaku di <span class="font-semibold text-gray-700">KAJI Indonesia</span>.
                </label>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full bg-emerald-600 text-white py-3 rounded-xl font-bold text-lg hover:bg-emerald-700 transition shadow-lg shadow-emerald-200">
                    Kirim Pendaftaran Mentor
                </button>
                <p class="text-center text-xs text-gray-400 mt-4 italic">
                    * Pendaftaran akan ditinjau oleh Admin sebelum ditampilkan di halaman Mentor.
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
        navigator.clipboard.writeText('49758348').then(() => {
            const msg = document.getElementById('copy-msg');
            msg.classList.remove('hidden');
            setTimeout(() => msg.classList.add('hidden'), 2000);
        });
    }

    // ======================== WILAYAH API ========================
    const BASE_URL = 'https://www.emsifa.com/api-wilayah-indonesia/api';

    const provinsiSelect   = document.getElementById('provinsi');
    const kabupatenSelect  = document.getElementById('kabupaten');
    const kecamatanSelect  = document.getElementById('kecamatan');
    const kelurahanSelect  = document.getElementById('kelurahan');

    // Load provinsi on page ready
    fetch(`${BASE_URL}/provinces.json`)
        .then(res => res.json())
        .then(data => {
            data.forEach(prov => {
                const opt = document.createElement('option');
                opt.value = prov.id;
                opt.textContent = prov.name;
                provinsiSelect.appendChild(opt);
            });
        });

    provinsiSelect.addEventListener('change', function () {
        resetSelect(kabupatenSelect, '-- Pilih Kabupaten/Kota --');
        resetSelect(kecamatanSelect, '-- Pilih Kecamatan --');
        resetSelect(kelurahanSelect, '-- Pilih Desa/Kelurahan --');

        if (!this.value) return;

        kabupatenSelect.disabled = true;
        fetch(`${BASE_URL}/regencies/${this.value}.json`)
            .then(res => res.json())
            .then(data => {
                data.forEach(kab => {
                    const opt = document.createElement('option');
                    opt.value = kab.id;
                    opt.textContent = kab.name;
                    kabupatenSelect.appendChild(opt);
                });
                kabupatenSelect.disabled = false;
            });
    });

    kabupatenSelect.addEventListener('change', function () {
        resetSelect(kecamatanSelect, '-- Pilih Kecamatan --');
        resetSelect(kelurahanSelect, '-- Pilih Desa/Kelurahan --');

        if (!this.value) return;

        kecamatanSelect.disabled = true;
        fetch(`${BASE_URL}/districts/${this.value}.json`)
            .then(res => res.json())
            .then(data => {
                data.forEach(kec => {
                    const opt = document.createElement('option');
                    opt.value = kec.id;
                    opt.textContent = kec.name;
                    kecamatanSelect.appendChild(opt);
                });
                kecamatanSelect.disabled = false;
            });
    });

    kecamatanSelect.addEventListener('change', function () {
        resetSelect(kelurahanSelect, '-- Pilih Desa/Kelurahan --');

        if (!this.value) return;

        kelurahanSelect.disabled = true;
        fetch(`${BASE_URL}/villages/${this.value}.json`)
            .then(res => res.json())
            .then(data => {
                data.forEach(kel => {
                    const opt = document.createElement('option');
                    opt.value = kel.id;
                    opt.textContent = kel.name;
                    kelurahanSelect.appendChild(opt);
                });
                kelurahanSelect.disabled = false;
            });
    });

    function resetSelect(selectEl, placeholder) {
        selectEl.innerHTML = `<option value="">${placeholder}</option>`;
        selectEl.disabled = true;
    }
</script>
@endsection