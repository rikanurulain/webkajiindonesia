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

        <div class="bg-white p-8 mt-6 rounded-xl shadow-md border border-gray-200">
        <form action="{{ route('profile.simpan-mentor') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- ======================== NAMA LENGKAP ======================== --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap *</label>
                <input type="text" name="full_name" value="{{ old('full_name', $user->name) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition"
                    required placeholder="Masukkan nama lengkap Anda">
            </div>

            {{-- ======================== KONTAK ======================== --}}
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
                <input type="text" name="gmaps_location" id="gmaps_location" value="{{ old('gmaps_location') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition"
                    required placeholder="Contoh: Jl. Raya Darmo No.1, RT 03/RW 05, Wonokromo, Surabaya, Jawa Timur 60241">
                <p class="text-[10px] text-gray-400 mt-1">*wajib sertakan RT/RW dan kode pos</p>
            </div>

            {{-- ======================== WILAYAH ======================== --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Provinsi *</label>
                    <select name="provinsi" id="provinsi"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition bg-white"
                        required>
                        <option value="">Pilih Provinsi</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Kabupaten / Kota *</label>
                    <select name="kabupaten" id="kabupaten"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition bg-white"
                        required disabled>
                        <option value="">Pilih Kabupaten/Kota</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Kecamatan *</label>
                    <select name="kecamatan" id="kecamatan"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition bg-white"
                        required disabled>
                        <option value="">Pilih Kecamatan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Desa / Kelurahan *</label>
                    <select name="kelurahan" id="kelurahan"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition bg-white"
                        required disabled>
                        <option value="">Pilih Desa/Kelurahan</option>
                    </select>
                </div>
            </div>

            {{-- ======================== PETA ======================== --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Titik Lokasi di Peta <span class="text-red-500">*</span>
                </label>
                <p class="text-xs text-gray-500 mb-2">
                    Peta akan otomatis mengarah ke lokasi Anda setelah <strong>Desa/Kelurahan</strong> dipilih.
                    Anda juga bisa klik atau geser marker untuk menyesuaikan titik secara manual.
                </p>

                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.min.css"/>
                <script src="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.min.js"></script>

                <div style="position:relative;">
                    <div id="map-picker-mentor" style="height:320px;border-radius:10px;border:2px solid #fecaca;overflow:hidden;"></div>
                    <div id="map-mentor-loading" style="display:none;position:absolute;inset:0;background:rgba(255,255,255,0.75);border-radius:10px;z-index:1000;align-items:center;justify-content:center;flex-direction:column;gap:8px;">
                        <div style="width:32px;height:32px;border:4px solid #fecaca;border-top-color:#e53935;border-radius:50%;animation:spin-mentor 0.8s linear infinite;"></div>
                        <span style="font-size:12px;color:#666;">Mencari lokasi...</span>
                    </div>
                </div>
                <style>@keyframes spin-mentor{to{transform:rotate(360deg)}}</style>

                <p id="map-picker-hint-mentor" class="text-xs text-gray-500 mt-1">
                    📍 Pilih Desa/Kelurahan terlebih dahulu agar peta otomatis mengarah ke lokasi Anda.
                </p>
                <input type="hidden" name="lat" id="lat-mentor" value="{{ old('lat') }}" required>
                <input type="hidden" name="lng" id="lng-mentor" value="{{ old('lng') }}" required>
            </div>

            {{-- ======================== TENTANG DIRI ======================== --}}
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

            {{-- ======================== BIAYA PENDAFTARAN ======================== --}}
            <div class="p-6 rounded-xl border border-gray-200 space-y-4 bg-white">
                <div>
                    <h3 class="text-sm font-bold text-gray-800">Biaya Pendaftaran Mentor</h3>
                    <p class="text-sm text-gray-600 mt-1 leading-relaxed">
                        Silahkan transfer biaya pendaftaran sebesar <span class="font-bold text-gray-900">Rp100.000</span> ke rekening berikut, lalu unggah bukti transfer di bawah.
                    </p>
                </div>

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

                <div class="space-y-2 pt-2">
                    <label class="block text-sm font-medium text-gray-700">Bukti Transfer <span class="text-red-500">*</span></label>
                    <p class="text-xs text-gray-500">Upload 1 file yang didukung (JPG, PNG, PDF). Maks 2 MB.</p>
                    <div class="relative">
                        <input type="file" name="bukti_transfer" id="file-transfer" class="hidden" accept="image/*,.pdf" required onchange="updateFileName(this, 'name-transfer')">
                        <button type="button" onclick="document.getElementById('file-transfer').click()"
                                class="flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-md bg-white text-blue-700 font-medium text-sm hover:bg-gray-50 transition shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                            Tambahkan file
                        </button>
                        <p id="name-transfer" class="text-xs text-blue-600 mt-2 font-medium italic"></p>
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
// ======================== UTILITY ========================
function updateFileName(input, targetId) {
    const fileName = input.files[0] ? input.files[0].name : '';
    const label = document.getElementById(targetId);
    label.textContent = fileName ? '✓ File terpilih: ' + fileName : '';
}

function copyRekening() {
    const noRek = document.getElementById('nomor-rek').textContent.trim();
    const label = document.getElementById('copy-label');
    const done  = () => { label.textContent = '✓ Tersalin!'; setTimeout(() => { label.textContent = 'Salin'; }, 2000); };
    if (navigator.clipboard) {
        navigator.clipboard.writeText(noRek).then(done);
    } else {
        const el = document.createElement('textarea');
        el.value = noRek; document.body.appendChild(el); el.select();
        document.execCommand('copy'); document.body.removeChild(el); done();
    }
}

// ======================== PETA + GEOCODE ========================
(function () {
    var map        = L.map('map-picker-mentor').setView([-2.5, 118], 5);
    var marker     = null;
    var debTimer   = null;
    var isGeocoding = false;
    var hintEl     = document.getElementById('map-picker-hint-mentor');
    var loadEl     = document.getElementById('map-mentor-loading');

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors', maxZoom: 19
    }).addTo(map);

    // Restore koordinat lama jika validasi gagal
    var oldLat = document.getElementById('lat-mentor').value;
    var oldLng = document.getElementById('lng-mentor').value;
    if (oldLat && oldLng) setMarker(parseFloat(oldLat), parseFloat(oldLng), true);

    function setMarker(lat, lng, zoomIn) {
        if (marker) {
            marker.setLatLng([lat, lng]);
        } else {
            marker = L.marker([lat, lng], { draggable: true }).addTo(map);
            marker.on('dragend', function (e) {
                var p = e.target.getLatLng();
                simpanKoordinat(p.lat, p.lng);
            });
        }
        if (zoomIn) map.setView([lat, lng], 16);
        simpanKoordinat(lat, lng);
    }

    function simpanKoordinat(lat, lng) {
        document.getElementById('lat-mentor').value = lat;
        document.getElementById('lng-mentor').value = lng;
        hintEl.textContent = '✅ ' + lat.toFixed(6) + ', ' + lng.toFixed(6) + ' — Geser marker untuk menyesuaikan.';
        hintEl.style.color = '#16a34a';
    }

    // Klik manual di peta
    map.on('click', function (e) { setMarker(e.latlng.lat, e.latlng.lng, false); });

    // Helper ambil teks option terpilih
    function selText(id) {
        var el = document.getElementById(id);
        if (!el || !el.value) return '';
        return el.options[el.selectedIndex].text;
    }

    // Fungsi geocode — dipanggil HANYA dari kelurahan.change
    window.mentorGeocode = function () {
        clearTimeout(debTimer);
        debTimer = setTimeout(doGeocode, 600);
    };

    function doGeocode() {
        if (isGeocoding) return;

        var alamat   = (document.getElementById('gmaps_location') || {}).value || '';
        var kelVal   = (document.getElementById('kelurahan') || {}).value || '';
        var kelText  = selText('kelurahan');
        var kecText  = selText('kecamatan');
        var kabText  = selText('kabupaten');
        var provText = selText('provinsi');

        // Syarat: kelurahan sudah dipilih + gmaps_location terisi
        if (!kelVal || alamat.trim().length < 5) return;

        isGeocoding = true;
        loadEl.style.display = 'flex';
        hintEl.textContent   = '🔍 Mencari lokasi...';
        hintEl.style.color   = '#6b7280';

        // Strategi 1 — structured query: paling presisi
        // street = isi gmaps_location, suburb = kelurahan, city = kabupaten, state = provinsi
        var p1 = new URLSearchParams({
            format          : 'json',
            limit           : '1',
            countrycodes    : 'id',
            'accept-language': 'id,en',
            street  : alamat.trim(),
            suburb  : kelText,
            city    : kabText,
            state   : provText,
            country : 'Indonesia'
        });

        fetch('https://nominatim.openstreetmap.org/search?' + p1.toString())
            .then(function (r) { return r.json(); })
            .then(function (h1) {
                if (h1 && h1.length > 0) return h1[0];

                // Strategi 2 — fallback: q= kelurahan + kecamatan + kabupaten + provinsi
                // Hilangkan nama jalan sama sekali agar tidak ambigu
                var q2 = [kelText, kecText, kabText, provText].filter(Boolean).join(', ');
                var p2 = new URLSearchParams({
                    format          : 'json',
                    limit           : '1',
                    countrycodes    : 'id',
                    'accept-language': 'id,en',
                    q       : q2 + ', Indonesia'
                });
                return fetch('https://nominatim.openstreetmap.org/search?' + p2.toString())
                    .then(function (r2) { return r2.json(); })
                    .then(function (h2) { return (h2 && h2.length > 0) ? h2[0] : null; });
            })
            .then(function (result) {
                loadEl.style.display = 'none';
                isGeocoding = false;
                if (!result) {
                    hintEl.textContent = '⚠️ Lokasi tidak ditemukan otomatis. Klik langsung di peta.';
                    hintEl.style.color = '#b45309';
                    return;
                }
                var lat = parseFloat(result.lat);
                var lng = parseFloat(result.lon);
                // Validasi: harus di wilayah Indonesia
                if (lat >= -11 && lat <= 6 && lng >= 95 && lng <= 141) {
                    setMarker(lat, lng, true);
                } else {
                    hintEl.textContent = '⚠️ Hasil di luar Indonesia. Klik langsung di peta.';
                    hintEl.style.color = '#b45309';
                }
            })
            .catch(function (err) {
                console.warn('[geocode] error:', err);
                loadEl.style.display = 'none';
                isGeocoding = false;
                hintEl.textContent = '⚠️ Gagal terhubung ke layanan peta. Klik titik di peta secara manual.';
                hintEl.style.color = '#b45309';
            });
    }
})();

// ======================== WILAYAH API ========================
(function () {
    var BASE = 'https://www.emsifa.com/api-wilayah-indonesia/api';

    var elProv = document.getElementById('provinsi');
    var elKab  = document.getElementById('kabupaten');
    var elKec  = document.getElementById('kecamatan');
    var elKel  = document.getElementById('kelurahan');

    function resetSelect(el, label) {
        el.innerHTML = '<option value="">' + label + '</option>';
        el.disabled  = true;
    }

    // Muat provinsi
    fetch(BASE + '/provinces.json')
        .then(function (r) { return r.json(); })
        .then(function (data) {
            data.forEach(function (p) {
                var o = document.createElement('option');
                o.value = p.name; o.dataset.id = p.id; o.textContent = p.name;
                elProv.appendChild(o);
            });
        });

    elProv.addEventListener('change', function () {
        resetSelect(elKab, 'Pilih Kabupaten/Kota');
        resetSelect(elKec, 'Pilih Kecamatan');
        resetSelect(elKel, 'Pilih Desa/Kelurahan');
        if (!this.value) return;
        var provId = this.options[this.selectedIndex].dataset.id;
        elKab.disabled = true;
        fetch(BASE + '/regencies/' + provId + '.json')
            .then(function (r) { return r.json(); })
            .then(function (data) {
                data.forEach(function (k) {
                    var o = document.createElement('option');
                    o.value = k.name; o.dataset.id = k.id; o.textContent = k.name;
                    elKab.appendChild(o);
                });
                elKab.disabled = false;
            });
    });

    elKab.addEventListener('change', function () {
        resetSelect(elKec, 'Pilih Kecamatan');
        resetSelect(elKel, 'Pilih Desa/Kelurahan');
        if (!this.value) return;
        var kabId = this.options[this.selectedIndex].dataset.id;
        elKec.disabled = true;
        fetch(BASE + '/districts/' + kabId + '.json')
            .then(function (r) { return r.json(); })
            .then(function (data) {
                data.forEach(function (k) {
                    var o = document.createElement('option');
                    o.value = k.name; o.dataset.id = k.id; o.textContent = k.name;
                    elKec.appendChild(o);
                });
                elKec.disabled = false;
                // TIDAK trigger geocode di sini
            });
    });

    elKec.addEventListener('change', function () {
        resetSelect(elKel, 'Pilih Desa/Kelurahan');
        if (!this.value) return;
        var kecId = this.options[this.selectedIndex].dataset.id;
        elKel.disabled = true;
        fetch(BASE + '/villages/' + kecId + '.json')
            .then(function (r) { return r.json(); })
            .then(function (data) {
                data.forEach(function (k) {
                    var o = document.createElement('option');
                    o.value = k.name; o.dataset.id = k.id; o.textContent = k.name;
                    elKel.appendChild(o);
                });
                elKel.disabled = false;
                // TIDAK trigger geocode di sini — tunggu kelurahan dipilih
            });
    });

    // ← SATU-SATUNYA tempat geocode dipanggil dari dropdown
    elKel.addEventListener('change', function () {
        if (!this.value) return;
        if (typeof window.mentorGeocode === 'function') window.mentorGeocode();
    });

    // Trigger dari kolom gmaps_location — jalan kalau kelurahan sudah dipilih
    var inputLokasi = document.getElementById('gmaps_location');
    if (inputLokasi) {
        inputLokasi.addEventListener('input', function () {
            // Hanya jalankan kalau kelurahan sudah dipilih
            var kelVal = (document.getElementById('kelurahan') || {}).value || '';
            if (kelVal) window.mentorGeocode();
        });
    }
})();
</script>
@endsection