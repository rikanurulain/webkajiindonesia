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

        <div class="bg-emerald-700 px-8 py-10 text-white text-center rounded-xl shadow-md">
            <h2 class="text-3xl font-bold">Formulir Pendaftaran Mitra UMKM</h2>
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
        <form action="{{ route('profile.simpan-umkm') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- ======================== NAMA TOKO & KATEGORI ======================== --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Toko / Usaha *</label>
                    <input type="text" name="nama" required value="{{ old('nama') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition"
                           placeholder="Contoh: Batik Nusantara">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Kategori Usaha *</label>
                    <select name="kategori" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition bg-white">
                        <option value="">Pilih Kategori</option>
                        <option value="Kuliner"   {{ old('kategori') === 'Kuliner'   ? 'selected' : '' }}>Kuliner</option>
                        <option value="Fashion"   {{ old('kategori') === 'Fashion'   ? 'selected' : '' }}>Fashion</option>
                        <option value="Kerajinan" {{ old('kategori') === 'Kerajinan' ? 'selected' : '' }}>Kerajinan</option>
                        <option value="Pertanian" {{ old('kategori') === 'Pertanian' ? 'selected' : '' }}>Pertanian</option>
                        <option value="Jasa"      {{ old('kategori') === 'Jasa'      ? 'selected' : '' }}>Jasa</option>
                    </select>
                </div>
            </div>

            {{-- ======================== PEMILIK & KONTAK ======================== --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Pemilik (Owner) *</label>
                    <input type="text" name="owner" required value="{{ old('owner') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Kontak WhatsApp *</label>
                    <input type="text" name="kontak" required value="{{ old('kontak') }}"
                           placeholder="Contoh: 628123456789"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition">
                    <p class="text-[10px] text-gray-400 mt-1">*Gunakan format angka mulai dari 62</p>
                </div>
            </div>

            {{-- ======================== NIB & ID TKM ======================== --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Induk Berusaha (NIB) <span class="text-gray-400 font-normal">(Opsional)</span></label>
                    <input type="text" name="nib" value="{{ old('nib') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition">
                </div>

            </div>

            {{-- ======================== LOKASI USAHA ======================== --}}
            <div class="space-y-4 bg-gray-50 p-6 rounded-xl border border-gray-200">
                <h3 class="text-sm font-bold text-emerald-700 uppercase tracking-wider">Lokasi Usaha</h3>

                {{-- Detail Alamat --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Detail Alamat (Jalan, No Rumah, RT/RW) *</label>
                    <textarea name="alamat" id="alamat_umkm" rows="2" required
                              placeholder="Contoh: Jl. Sudirman No. 123, RT 01/RW 02"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition">{{ old('alamat') }}</textarea>
                    <p class="text-[10px] text-gray-400 mt-1">*wajib sertakan RT/RW agar peta lebih akurat</p>
                </div>

                {{-- Dropdown Wilayah --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Provinsi *</label>
                        <select name="provinsi" id="provinsi_umkm" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition bg-white">
                            <option value="">Pilih Provinsi</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Kabupaten / Kota *</label>
                        <select name="kabupaten_kota" id="kota_umkm" required disabled
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition bg-white">
                            <option value="">Pilih Kabupaten/Kota</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Kecamatan *</label>
                        <select name="kecamatan" id="kecamatan_umkm" required disabled
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition bg-white">
                            <option value="">Pilih Kecamatan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Kelurahan / Desa *</label>
                        <select name="kelurahan" id="kelurahan_umkm" required disabled
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition bg-white">
                            <option value="">Pilih Kelurahan</option>
                        </select>
                    </div>
                </div>

                {{-- PETA --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Titik Lokasi di Peta <span class="text-red-500">*</span>
                    </label>
                    <p class="text-xs text-gray-500 mb-2">
                        Peta akan otomatis mengarah ke lokasi usaha setelah <strong>Kelurahan/Desa</strong> dipilih.
                        Anda juga bisa klik atau geser marker untuk menyesuaikan titik secara manual.
                    </p>

                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.min.css"/>
                    <script src="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.min.js"></script>

                    <div style="position:relative;">
                        <div id="map-picker-umkm" style="height:320px;border-radius:10px;border:2px solid #a7f3d0;overflow:hidden;"></div>
                        <div id="map-umkm-loading" style="display:none;position:absolute;inset:0;background:rgba(255,255,255,0.75);border-radius:10px;z-index:1000;align-items:center;justify-content:center;flex-direction:column;gap:8px;">
                            <div style="width:32px;height:32px;border:4px solid #a7f3d0;border-top-color:#059669;border-radius:50%;animation:spin-umkm 0.8s linear infinite;"></div>
                            <span style="font-size:12px;color:#666;">Mencari lokasi...</span>
                        </div>
                    </div>
                    <style>@keyframes spin-umkm{to{transform:rotate(360deg)}}</style>

                    <p id="map-hint-umkm" class="text-xs text-gray-500 mt-1">
                        📍 Pilih Kelurahan/Desa terlebih dahulu agar peta otomatis mengarah ke lokasi Anda.
                    </p>
                    <input type="hidden" name="lat" id="lat-umkm" value="{{ old('lat') }}" required>
                    <input type="hidden" name="lng" id="lng-umkm" value="{{ old('lng') }}" required>
                </div>
            </div>

            {{-- ======================== DESKRIPSI ======================== --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi Usaha *</label>
                <textarea name="deskripsi" rows="4" required
                          placeholder="Jelaskan produk unggulan dan keunikan usaha Anda..."
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition">{{ old('deskripsi') }}</textarea>
            </div>

            {{-- ======================== UPLOAD LOGO & FOTO ======================== --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-6 bg-gray-50 rounded-2xl border border-dashed border-gray-300">
                <div class="space-y-3">
                    <label class="block text-sm font-medium text-gray-700">Logo Usaha <span class="text-red-500">*</span></label>
                    <p class="text-xs text-gray-500">Upload 1 file logo (JPG, PNG, WebP). Maks 10 MB.</p>
                    <div class="relative">
                        <input type="file" name="logo" id="file-logo" class="hidden" accept="image/*" required onchange="updateFileName(this, 'name-logo')">
                        <button type="button" onclick="document.getElementById('file-logo').click()"
                                class="flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-md bg-white text-blue-600 font-medium text-sm hover:bg-blue-50 transition shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                            Pilih Logo
                        </button>
                        <p id="name-logo" class="text-xs text-emerald-600 mt-2 font-medium italic"></p>
                    </div>
                </div>

                <div class="space-y-3">
                    <label class="block text-sm font-medium text-gray-700">Foto Produk Unggulan <span class="text-red-500">*</span></label>
                    <p class="text-xs text-gray-500">Upload 1 foto produk terbaik (JPG, PNG, WebP). Maks 10 MB.</p>
                    <div class="relative">
                        <input type="file" name="foto_produk" id="file-produk" class="hidden" accept="image/*" required onchange="updateFileName(this, 'name-produk')">
                        <button type="button" onclick="document.getElementById('file-produk').click()"
                                class="flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-md bg-white text-blue-600 font-medium text-sm hover:bg-blue-50 transition shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                            Pilih Foto
                        </button>
                        <p id="name-produk" class="text-xs text-emerald-600 mt-2 font-medium italic"></p>
                    </div>
                </div>
            </div>

            {{-- ======================== CHECKBOX PERSETUJUAN ======================== --}}
            <div class="flex items-start gap-3 p-4 bg-gray-50 rounded-xl border border-gray-200">
                <input type="checkbox" name="terms" id="terms" required value="1"
                    class="mt-0.5 h-4 w-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500 cursor-pointer flex-shrink-0">
                <label for="terms" class="text-sm text-gray-600 leading-relaxed cursor-pointer">
                    Saya setuju dengan
                    <a href="https://kajiindonesia.com/" target="_blank" class="text-emerald-700 font-semibold underline hover:text-emerald-800">Syarat dan Ketentuan</a>
                    serta
                    <a href="https://kajiindonesia.com/" target="_blank" class="text-emerald-700 font-semibold underline hover:text-emerald-800">Kebijakan Privasi</a>
                    yang berlaku di <span class="font-semibold text-gray-700">KAJI Indonesia</span>.
                </label>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full bg-emerald-600 text-white py-3 rounded-xl font-bold text-lg hover:bg-emerald-700 transition shadow-lg shadow-emerald-200">
                    Kirim Pendaftaran UMKM
                </button>
                <p class="text-center text-xs text-gray-400 mt-4 italic">
                    * Pendaftaran akan ditinjau oleh Admin sebelum ditampilkan di halaman UMKM.
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
    document.getElementById(targetId).textContent = fileName ? '✓ File terpilih: ' + fileName : '';
}

// ======================== PETA + GEOCODE ========================
(function () {
    var map         = L.map('map-picker-umkm').setView([-2.5, 118], 5);
    var marker      = null;
    var debTimer    = null;
    var isGeocoding = false;
    var hintEl      = document.getElementById('map-hint-umkm');
    var loadEl      = document.getElementById('map-umkm-loading');

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors', maxZoom: 19
    }).addTo(map);

    // Restore koordinat lama jika validasi gagal
    var oldLat = document.getElementById('lat-umkm').value;
    var oldLng = document.getElementById('lng-umkm').value;
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
        document.getElementById('lat-umkm').value = lat;
        document.getElementById('lng-umkm').value = lng;
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

    // Fungsi geocode utama
    window.umkmGeocode = function () {
        clearTimeout(debTimer);
        debTimer = setTimeout(doGeocode, 600);
    };

    function doGeocode() {
        if (isGeocoding) return;

        var alamat   = (document.getElementById('alamat_umkm') || {}).value || '';
        var kelVal   = (document.getElementById('kelurahan_umkm') || {}).value || '';
        var kelText  = selText('kelurahan_umkm');
        var kecText  = selText('kecamatan_umkm');
        var kabText  = selText('kota_umkm');
        var provText = selText('provinsi_umkm');

        // Syarat: kelurahan sudah dipilih + alamat terisi
        if (!kelVal || alamat.trim().length < 5) return;

        isGeocoding = true;
        loadEl.style.display = 'flex';
        hintEl.textContent   = '🔍 Mencari lokasi...';
        hintEl.style.color   = '#6b7280';

        // Strategi 1 — structured query (paling presisi)
        var p1 = new URLSearchParams({
            format           : 'json',
            limit            : '1',
            countrycodes     : 'id',
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
                var q2 = [kelText, kecText, kabText, provText].filter(Boolean).join(', ');
                var p2 = new URLSearchParams({
                    format           : 'json',
                    limit            : '1',
                    countrycodes     : 'id',
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
                console.warn('[geocode-umkm] error:', err);
                loadEl.style.display = 'none';
                isGeocoding = false;
                hintEl.textContent = '⚠️ Gagal terhubung ke layanan peta. Klik titik di peta secara manual.';
                hintEl.style.color = '#b45309';
            });
    }

    // Trigger dari kolom alamat — jalan kalau kelurahan sudah dipilih
    var inputAlamat = document.getElementById('alamat_umkm');
    if (inputAlamat) {
        inputAlamat.addEventListener('input', function () {
            var kelVal = (document.getElementById('kelurahan_umkm') || {}).value || '';
            if (kelVal) window.umkmGeocode();
        });
    }
})();

// ======================== WILAYAH API ========================
(function () {
    var BASE = 'https://www.emsifa.com/api-wilayah-indonesia/api';

    var elProv = document.getElementById('provinsi_umkm');
    var elKab  = document.getElementById('kota_umkm');
    var elKec  = document.getElementById('kecamatan_umkm');
    var elKel  = document.getElementById('kelurahan_umkm');

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
                o.value = p.id; o.textContent = p.name;
                elProv.appendChild(o);
            });
        })
        .catch(function () {
            alert('Gagal memuat data provinsi. Pastikan internet aktif!');
        });

    elProv.addEventListener('change', function () {
        resetSelect(elKab, 'Pilih Kabupaten/Kota');
        resetSelect(elKec, 'Pilih Kecamatan');
        resetSelect(elKel, 'Pilih Kelurahan');
        if (!this.value) return;
        elKab.disabled = true;
        fetch(BASE + '/regencies/' + this.value + '.json')
            .then(function (r) { return r.json(); })
            .then(function (data) {
                data.forEach(function (k) {
                    var o = document.createElement('option');
                    o.value = k.id; o.textContent = k.name;
                    elKab.appendChild(o);
                });
                elKab.disabled = false;
            });
    });

    elKab.addEventListener('change', function () {
        resetSelect(elKec, 'Pilih Kecamatan');
        resetSelect(elKel, 'Pilih Kelurahan');
        if (!this.value) return;
        elKec.disabled = true;
        fetch(BASE + '/districts/' + this.value + '.json')
            .then(function (r) { return r.json(); })
            .then(function (data) {
                data.forEach(function (k) {
                    var o = document.createElement('option');
                    o.value = k.id; o.textContent = k.name;
                    elKec.appendChild(o);
                });
                elKec.disabled = false;
            });
    });

    elKec.addEventListener('change', function () {
        resetSelect(elKel, 'Pilih Kelurahan');
        if (!this.value) return;
        elKel.disabled = true;
        fetch(BASE + '/villages/' + this.value + '.json')
            .then(function (r) { return r.json(); })
            .then(function (data) {
                data.forEach(function (k) {
                    var o = document.createElement('option');
                    o.value = k.id; o.textContent = k.name;
                    elKel.appendChild(o);
                });
                elKel.disabled = false;
            });
    });

    // ← SATU-SATUNYA tempat geocode dipanggil dari dropdown
    elKel.addEventListener('change', function () {
        if (!this.value) return;
        if (typeof window.umkmGeocode === 'function') window.umkmGeocode();
    });
})();

// ======================== SUBMIT: kirim nama bukan ID ========================
document.querySelector('form').addEventListener('submit', function () {
    var maps = {
        'provinsi_umkm'   : 'provinsi',
        'kota_umkm'       : 'kabupaten_kota',
        'kecamatan_umkm'  : 'kecamatan',
        'kelurahan_umkm'  : 'kelurahan',
    };
    Object.keys(maps).forEach(function (elId) {
        var el = document.getElementById(elId);
        if (!el || !el.value) return;
        var hidden = document.createElement('input');
        hidden.type  = 'hidden';
        hidden.name  = maps[elId];
        hidden.value = el.options[el.selectedIndex].text;
        document.querySelector('form').appendChild(hidden);
        el.removeAttribute('name');
    });
});
</script>
@endsection