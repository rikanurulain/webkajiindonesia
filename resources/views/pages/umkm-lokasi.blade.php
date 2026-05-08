@extends('layouts.app')

@section('content')

{{-- Hero Section --}}
<section class="bg-gradient-to-br from-primary-dark via-primary to-primary- py-16 text-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-8">
        <div class="max-w-2xl">
            <h1 class="font-serif text-4xl font-bold sm:text-5xl">
                Lokasi UMKM
            </h1>
            <p class="mt-4 text-lg text-white/90">
                Temukan sebaran mitra UMKM yang didampingi oleh Karya Kami di seluruh Indonesia.
            </p>
        </div>
        <div>
                <img src="{{ asset('storage/logo/KARYAKAMI.png') }}"
                 alt="Logo Karya Kami"
                 class="w-64 md:w-80 object-contain">
        </div>
    </div>
</section>

{{-- Info Bar --}}
<div class="bg-white border-b border-gray-200 shadow-sm" style="position: relative; z-index: 1;">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between">
        <p class="text-sm text-gray-500">Klik marker pada peta untuk melihat detail UMKM</p>
        <span id="jumlah-umkm"
              class="text-sm font-semibold bg-green-100 text-green-800 px-4 py-1 rounded-full border border-green-200">
            Memuat...
        </span>
    </div>
</div>

{{-- Leaflet CSS --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.min.css"/>

<style>
    #map { z-index: 0; }

    .leaflet-popup-content-wrapper {
        border-radius: 12px !important;
        padding: 0 !important;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,.15) !important;
    }
    .leaflet-popup-content {
        margin: 0 !important;
        width: 240px !important;
    }
    .popup-foto {
        width: 100%;
        height: 140px;
        object-fit: cover;
        display: block;
        background: #f3f4f6;
    }
    .popup-foto-placeholder {
        width: 100%;
        height: 100px;
        background: #e8f0fe;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 36px;
    }
    .popup-body {
        padding: 12px 14px 14px;
    }
    .popup-nama {
        font-size: 14px;
        font-weight: 600;
        color: #1a1a2e;
        margin-bottom: 5px;
        line-height: 1.3;
    }
    .popup-alamat {
        font-size: 12px;
        color: #666;
        line-height: 1.5;
        margin-bottom: 10px;
    }
    .popup-btn-detail {
        display: block;
        text-align: center;
        background: #1a73e8;
        color: #fff !important;
        font-size: 12px;
        font-weight: 600;
        padding: 7px 14px;
        border-radius: 8px;
        text-decoration: none;
    }
    .popup-btn-detail:hover {
        background: #1557b0;
    }
</style>

{{-- Peta --}}
<div class="relative">

    {{-- Loading --}}
    <div id="loading"
         class="absolute inset-0 flex flex-col items-center justify-center bg-white/80 gap-3"
         style="z-index: 1;">
        <div class="w-10 h-10 border-4 border-gray-200 border-t-primary rounded-full animate-spin"></div>
        <p class="text-sm text-gray-500">Memuat data UMKM...</p>
    </div>

    {{-- Error --}}
    <div id="error-box"
         class="hidden absolute top-4 left-1/2 -translate-x-1/2
                bg-red-50 border border-red-200 text-red-700
                text-sm px-5 py-3 rounded-lg shadow max-w-md text-center"
         style="z-index: 2;">
    </div>

    {{-- Map --}}
    <div id="map" class="w-full" style="height: 600px;"></div>

</div>

{{-- Leaflet JS --}}
<script src="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.min.js"></script>

<script>
const API_URL    = '{{ url("/umkm-peta-data") }}';
const DETAIL_URL = '{{ url("/produk") }}'; // base URL detail produk

const map = L.map('map').setView([-2.5, 118], 5);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    maxZoom: 19,
}).addTo(map);

// ── Marker: coba load logo, fallback ke huruf K ──────────
function buatMarkerIcon() {
    const logoUrl = '{{ asset("storage/logo/KARYAKAMI.png") }}';
    const html = `
        <div style="position:relative;width:44px;height:56px;">
            <div style="
                width:44px;height:44px;
                background:#1a73e8;
                border-radius:50% 50% 50% 0;
                transform:rotate(-45deg);
                position:absolute;top:0;left:0;
                border:2px solid #fff;
                box-shadow:0 2px 6px rgba(0,0,0,.25);
            "></div>
            <div style="
                position:absolute;top:4px;left:4px;
                width:36px;height:36px;
                border-radius:50%;
                background:#fff;
                display:flex;align-items:center;justify-content:center;
                overflow:hidden;
            ">
                <img src="${logoUrl}"
                     style="width:28px;height:28px;object-fit:contain;"
                     onerror="this.style.display='none';this.nextElementSibling.style.display='block'"/>
                <span style="display:none;font-size:14px;font-weight:700;color:#1a73e8;">K</span>
            </div>
        </div>`;

    return L.divIcon({
        className  : '',
        html       : html,
        iconSize   : [44, 56],
        iconAnchor : [22, 56],
        popupAnchor: [0, -60],
    });
}

// ── Buat konten popup ────────────────────────────────────
function buatPopup(umkm) {
    const foto = umkm.foto
        ? `<img class="popup-foto" src="${escHtml(umkm.foto)}" alt="${escHtml(umkm.nama)}"
               onerror="this.outerHTML='<div class=\'popup-foto-placeholder\'>🏪</div>'">`
        : `<div class="popup-foto-placeholder">🏪</div>`;

    const alamat = umkm.alamat
        ? `<div class="popup-alamat">📍 ${escHtml(umkm.alamat)}</div>`
        : '';

    const detailUrl = DETAIL_URL + '/' + umkm.id;

    return `
        ${foto}
        <div class="popup-body">
            <div class="popup-nama">${escHtml(umkm.nama)}</div>
            ${alamat}
            <a class="popup-btn-detail" href="${detailUrl}">Lihat Detail Produk →</a>
        </div>`;
}

// ── Muat data UMKM ───────────────────────────────────────
async function muatDataUMKM() {
    try {
        const res = await fetch(API_URL);
        if (!res.ok) throw new Error('HTTP ' + res.status);

        const json = await res.json();
        const data = json.data || [];

        document.getElementById('loading').style.display = 'none';
        document.getElementById('jumlah-umkm').textContent = data.length + ' UMKM Terdaftar';

        if (data.length === 0) {
            tampilError('Belum ada data UMKM dengan koordinat. Pastikan kolom alamat sudah terisi.');
            return;
        }

        const icon    = buatMarkerIcon();
        const markers = [];

        data.forEach(umkm => {
            const marker = L.marker([umkm.lat, umkm.lng], { icon });
            marker.bindPopup(buatPopup(umkm), { maxWidth: 260 });
            marker.addTo(map);
            markers.push(marker);
        });

        const group = L.featureGroup(markers);
        map.fitBounds(group.getBounds().pad(0.2));

    } catch (err) {
        document.getElementById('loading').style.display = 'none';
        tampilError('Gagal memuat data: ' + err.message);
        console.error(err);
    }
}

function tampilError(msg) {
    const el = document.getElementById('error-box');
    el.textContent = '⚠️ ' + msg;
    el.classList.remove('hidden');
}

function escHtml(s) {
    if (!s) return '';
    return String(s)
        .replace(/&/g, '&amp;').replace(/</g, '&lt;')
        .replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

muatDataUMKM();
setInterval(muatDataUMKM, 300000);
</script>

@endsection