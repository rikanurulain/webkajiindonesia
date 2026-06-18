<?php $__env->startSection('content'); ?>
<div class="tf-page">
    <div class="tf-container">

        
        <a href="<?php echo e(route('profile')); ?>" class="tf-back">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Profil
        </a>

        
        <div class="tf-hero">
            <h1>Formulir Pendaftaran Mentor</h1>
            <p>Lengkapi data di bawah ini dengan benar untuk ditinjau oleh Admin.</p>
        </div>

        
        <?php if($errors->any()): ?>
            <div class="tf-banner tf-banner--rejected">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="tf-banner__icon">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                </svg>
                <div>
                    <p class="tf-banner__title">Ada kesalahan input:</p>
                    <ul class="tf-error-list">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>

        
        <form
            action="<?php echo e(route('profile.simpan-mentor')); ?>"
            method="POST"
            enctype="multipart/form-data"
        >
            <?php echo csrf_field(); ?>

            
            <div class="tf-card">
                <div class="tf-card__header">Data Diri</div>

                <div class="tf-field">
                    <label class="tf-label">Nama Lengkap <span class="tf-req">*</span></label>
                    <input
                        type="text"
                        name="full_name"
                        value="<?php echo e(old('full_name', $user->name)); ?>"
                        placeholder="Masukkan nama lengkap Anda"
                        class="tf-input"
                        required
                    >
                </div>

                <div class="tf-grid-2">
                    <div class="tf-field">
                        <label class="tf-label">No. WhatsApp <span class="tf-req">*</span></label>
                        <input
                            type="text"
                            name="phone"
                            value="<?php echo e(old('phone', $user->phone)); ?>"
                            placeholder="Contoh: 08123456789"
                            class="tf-input"
                            required
                        >
                    </div>
                    <div class="tf-field">
                        <label class="tf-label">Email Aktif <span class="tf-req">*</span></label>
                        <input
                            type="email"
                            name="email"
                            value="<?php echo e(old('email', $user->email)); ?>"
                            class="tf-input"
                            required
                        >
                    </div>
                </div>
            </div>

            
            <div class="tf-card">
                <div class="tf-card__header">Alamat Domisili</div>

                <div class="tf-field">
                    <label class="tf-label">Lokasi Tinggal (Sesuai Google Maps) <span class="tf-req">*</span></label>
                    <input
                        type="text"
                        name="gmaps_location"
                        id="gmaps_location"
                        value="<?php echo e(old('gmaps_location')); ?>"
                        placeholder="Jl. Raya Darmo No.1, RT 03/RW 05, Wonokromo, Surabaya 60241"
                        class="tf-input"
                        required
                    >
                    <p class="tf-hint">* Wajib sertakan RT/RW dan kode pos</p>
                </div>

                <div class="tf-grid-2">
                    <div class="tf-field">
                        <label class="tf-label">Provinsi <span class="tf-req">*</span></label>
                        <select name="provinsi" id="provinsi" class="tf-select" required>
                            <option value="">Pilih Provinsi</option>
                        </select>
                    </div>
                    <div class="tf-field">
                        <label class="tf-label">Kabupaten / Kota <span class="tf-req">*</span></label>
                        <select name="kabupaten" id="kabupaten" class="tf-select" required disabled>
                            <option value="">Pilih Kabupaten/Kota</option>
                        </select>
                    </div>
                    <div class="tf-field">
                        <label class="tf-label">Kecamatan <span class="tf-req">*</span></label>
                        <select name="kecamatan" id="kecamatan" class="tf-select" required disabled>
                            <option value="">Pilih Kecamatan</option>
                        </select>
                    </div>
                    <div class="tf-field">
                        <label class="tf-label">Desa / Kelurahan <span class="tf-req">*</span></label>
                        <select name="kelurahan" id="kelurahan" class="tf-select" required disabled>
                            <option value="">Pilih Desa/Kelurahan</option>
                        </select>
                    </div>
                </div>

                
                <div class="tf-field">
                    <label class="tf-label">
                        Titik Lokasi di Peta <span class="tf-req">*</span>
                    </label>
                    <p class="tf-hint" style="margin-bottom:8px">
                        Peta akan otomatis mengarah ke lokasi Anda setelah <strong>Desa/Kelurahan</strong> dipilih.
                        Anda juga bisa klik atau geser marker untuk menyesuaikan titik secara manual.
                    </p>

                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.min.css"/>
                    <script src="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.min.js"></script>

                    <div style="position:relative;">
                        <div id="map-picker-mentor" style="height:280px;border-radius:10px;border:1.5px solid #d1d5db;overflow:hidden;"></div>
                        <div id="map-mentor-loading" style="display:none;position:absolute;inset:0;background:rgba(255,255,255,0.75);border-radius:10px;z-index:1000;align-items:center;justify-content:center;flex-direction:column;gap:8px;">
                            <div style="width:28px;height:28px;border:3px solid #a7d8be;border-top-color:#0f6e56;border-radius:50%;animation:tf-spin 0.8s linear infinite;"></div>
                            <span style="font-size:12px;color:#666;">Mencari lokasi...</span>
                        </div>
                    </div>

                    <p id="map-picker-hint-mentor" class="tf-hint" style="margin-top:6px">
                        📍 Pilih Desa/Kelurahan terlebih dahulu agar peta otomatis mengarah ke lokasi Anda.
                    </p>
                    <input type="hidden" name="lat" id="lat-mentor" value="<?php echo e(old('lat')); ?>" required>
                    <input type="hidden" name="lng" id="lng-mentor" value="<?php echo e(old('lng')); ?>" required>
                </div>
            </div>

            
            <div class="tf-card">
                <div class="tf-card__header">Tentang Diri</div>

                <div class="tf-field">
                    <label class="tf-label">Bio / Tentang Diri Anda <span class="tf-req">*</span></label>
                    <textarea
                        name="bio"
                        rows="4"
                        placeholder="Ceritakan latar belakang, keahlian, dan motivasi Anda menjadi mentor UMKM..."
                        class="tf-textarea"
                        required
                    ><?php echo e(old('bio')); ?></textarea>
                </div>
            </div>

            
            <div class="tf-card">
                <div class="tf-card__header">Upload Dokumen</div>

                <div class="tf-grid-2">
                    
                    <div class="tf-field">
                        <label class="tf-label">Pas Foto Background Putih <span class="tf-req">*</span></label>
                        <div class="tf-upload" onclick="triggerFile('file-pasfoto')" role="button" tabindex="0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span class="tf-upload__label" id="label-pasfoto">Tambahkan file</span>
                            <span class="tf-upload__hint">JPG, PNG · Maks 2 MB</span>
                        </div>
                        <input type="file" name="white_bg_photo" id="file-pasfoto" class="tf-file-hidden" accept="image/*" required onchange="updateUploadLabel(this,'label-pasfoto')">
                    </div>

                    
                    <div class="tf-field">
                        <label class="tf-label">Scan KTP <span class="tf-req">*</span></label>
                        <div class="tf-upload" onclick="triggerFile('file-ktp')" role="button" tabindex="0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0"/>
                            </svg>
                            <span class="tf-upload__label" id="label-ktp">Tambahkan file</span>
                            <span class="tf-upload__hint">JPG, PNG, PDF · Maks 2 MB</span>
                        </div>
                        <input type="file" name="ktp_scan" id="file-ktp" class="tf-file-hidden" accept="image/*,.pdf" required onchange="updateUploadLabel(this,'label-ktp')">
                    </div>
                </div>
            </div>

            
            <div class="tf-card">
                <div class="tf-card__header">Biaya Pendaftaran</div>

                <p class="tf-biaya-desc">
                    Transfer biaya pendaftaran sebesar <strong>Rp100.000</strong> ke rekening berikut, lalu unggah bukti transfer.
                </p>

                <div class="tf-rekening">
                    <div class="tf-rek-row">
                        <span class="tf-rek-label">Bank</span>
                        <span class="tf-rek-val">BNI</span>
                    </div>
                    <div class="tf-rek-row">
                        <span class="tf-rek-label">Atas Nama</span>
                        <span class="tf-rek-val">ARI PRABOWO</span>
                    </div>
                    <div class="tf-rek-row">
                        <span class="tf-rek-label">No. Rekening</span>
                        <span class="tf-rek-val" id="nomor-rek">873873298</span>
                        <button type="button" class="tf-copy-btn" onclick="copyRekening()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                            <span id="copy-label">Salin</span>
                        </button>
                    </div>
                </div>

                <div class="tf-field" style="margin-top:14px">
                    <label class="tf-label">Bukti Transfer <span class="tf-req">*</span></label>
                    <div class="tf-upload tf-upload--wide" onclick="triggerFile('file-transfer')" role="button" tabindex="0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/>
                        </svg>
                        <div>
                            <span class="tf-upload__label" id="label-transfer">Tambahkan file</span>
                            <span class="tf-upload__hint" style="display:block">JPG, PNG, PDF · Maks 2 MB</span>
                        </div>
                    </div>
                    <input type="file" name="bukti_transfer" id="file-transfer" class="tf-file-hidden" accept="image/*,.pdf" required onchange="updateUploadLabel(this,'label-transfer')">
                </div>
            </div>

            
            <div class="tf-agree">
                <input
                    type="checkbox"
                    name="agree_terms"
                    id="agree_terms"
                    value="1"
                    required
                    class="tf-agree__check"
                >
                <label for="agree_terms" class="tf-agree__label">
                    Saya setuju dengan
                    <a href="https://kajiindonesia.com/" target="_blank" rel="noopener">Syarat dan Ketentuan</a>
                    serta
                    <a href="https://kajiindonesia.com/" target="_blank" rel="noopener">Kebijakan Privasi</a>
                    yang berlaku di <strong>KAJI Indonesia</strong>.
                </label>
            </div>

            
            <button type="submit" class="tf-submit">
                Kirim Pendaftaran Mentor
            </button>

            <p class="tf-footer-note">
                * Pendaftaran akan ditinjau oleh Admin sebelum ditampilkan di halaman Mentor.
            </p>

        </form>
    </div>
</div>


<style>
@keyframes tf-spin { to { transform: rotate(360deg); } }

.tf-page {
    min-height: 100vh;
    background: #f4f6f5;
    padding: 20px 0 40px;
}
.tf-container {
    max-width: 640px;
    margin: 0 auto;
    padding: 0 16px;
}

/* Back */
.tf-back {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    font-weight: 500;
    color: #0f6e56;
    text-decoration: none;
    margin-bottom: 14px;
    transition: color .15s;
}
.tf-back:hover { color: #085041; }

/* Hero */
.tf-hero {
    background: #0f6e56;
    border-radius: 14px;
    padding: 22px 20px;
    text-align: center;
    color: #fff;
    margin-bottom: 10px;
}
.tf-hero h1 { font-size: 20px; font-weight: 700; margin-bottom: 5px; }
.tf-hero p { font-size: 13px; color: #a9d9c6; line-height: 1.5; }

/* Banner */
.tf-banner {
    display: flex;
    gap: 10px;
    align-items: flex-start;
    padding: 12px 14px;
    border-radius: 0 10px 10px 0;
    margin-bottom: 10px;
    border-left: 3px solid;
}
.tf-banner--rejected { background: #fef2f2; border-color: #ef4444; }
.tf-banner__icon { flex-shrink: 0; margin-top: 1px; }
.tf-banner--rejected .tf-banner__icon { color: #dc2626; }
.tf-banner__title { font-size: 13px; font-weight: 700; margin-bottom: 3px; }
.tf-banner--rejected .tf-banner__title { color: #991b1b; }
.tf-error-list {
    list-style: disc;
    padding-left: 16px;
    font-size: 12px;
    color: #991b1b;
    margin-top: 4px;
    line-height: 1.7;
}

/* Card */
.tf-card {
    background: #fff;
    border-radius: 14px;
    border: 1px solid #e8ede9;
    padding: 16px;
    margin-bottom: 10px;
}
.tf-card__header {
    font-size: 11px;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: .06em;
    padding-bottom: 10px;
    margin-bottom: 14px;
    border-bottom: 1px solid #f0f4f1;
}

/* Field */
.tf-field { margin-bottom: 12px; }
.tf-field:last-child { margin-bottom: 0; }
.tf-label {
    display: block;
    font-size: 12px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 5px;
}
.tf-req { color: #dc2626; font-weight: 400; }
.tf-hint { font-size: 10px; color: #9ca3af; margin-top: 4px; }

/* Inputs */
.tf-input,
.tf-select,
.tf-textarea {
    width: 100%;
    padding: 9px 12px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 13px;
    color: #111827;
    background: #fff;
    outline: none;
    font-family: inherit;
    transition: border-color .15s, box-shadow .15s;
    -webkit-appearance: none;
    box-sizing: border-box;
}
.tf-input:focus,
.tf-select:focus,
.tf-textarea:focus {
    border-color: #0f6e56;
    box-shadow: 0 0 0 3px rgba(15,110,86,.1);
}
.tf-select {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='none' viewBox='0 0 24 24'%3E%3Cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 10px center;
    padding-right: 36px;
}
.tf-select:disabled { background-color: #f9fafb; color: #9ca3af; cursor: not-allowed; }
.tf-textarea { resize: vertical; line-height: 1.55; min-height: 80px; }

/* Grid */
.tf-grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}
@media (max-width: 400px) {
    .tf-grid-2 { grid-template-columns: 1fr; }
}

/* Upload */
.tf-upload {
    border: 1.5px dashed #d1d5db;
    border-radius: 10px;
    padding: 14px 10px;
    text-align: center;
    background: #fafafa;
    cursor: pointer;
    transition: border-color .15s, background .15s;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 5px;
    min-height: 88px;
    justify-content: center;
    box-sizing: border-box;
}
.tf-upload:hover { border-color: #0f6e56; background: #f0faf6; }
.tf-upload svg { color: #0f6e56; flex-shrink: 0; }
.tf-upload__label { font-size: 12px; font-weight: 600; color: #0f6e56; line-height: 1.5; }
.tf-upload__hint { font-size: 10px; color: #9ca3af; }
.tf-upload--wide {
    flex-direction: row;
    text-align: left;
    gap: 12px;
    padding: 12px 16px;
    min-height: auto;
}
.tf-file-hidden { display: none; }

/* Rekening */
.tf-biaya-desc { font-size: 13px; color: #4b5563; line-height: 1.6; margin-bottom: 12px; }
.tf-biaya-desc strong { color: #111827; }
.tf-rekening { border: 1px solid #e5e7eb; border-radius: 10px; overflow: hidden; }
.tf-rek-row {
    display: flex;
    align-items: center;
    padding: 9px 14px;
    border-bottom: 1px solid #f3f4f6;
    font-size: 13px;
    gap: 8px;
}
.tf-rek-row:last-child { border-bottom: none; }
.tf-rek-label { color: #6b7280; font-size: 12px; width: 90px; flex-shrink: 0; }
.tf-rek-val { font-weight: 600; color: #111827; flex: 1; letter-spacing: .02em; }
.tf-copy-btn {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 4px 10px;
    font-size: 11px;
    font-weight: 600;
    color: #0f6e56;
    background: #e6f4ee;
    border: 1px solid #a7d8be;
    border-radius: 6px;
    cursor: pointer;
    transition: background .15s;
    white-space: nowrap;
}
.tf-copy-btn:hover { background: #c3e9d7; }

/* Agree */
.tf-agree {
    display: flex;
    gap: 10px;
    align-items: flex-start;
    padding: 14px;
    background: #fff;
    border-radius: 12px;
    border: 1px solid #e8ede9;
    margin-bottom: 14px;
}
.tf-agree__check {
    width: 16px;
    height: 16px;
    flex-shrink: 0;
    margin-top: 2px;
    accent-color: #0f6e56;
    cursor: pointer;
}
.tf-agree__label { font-size: 12px; color: #4b5563; line-height: 1.7; cursor: pointer; }
.tf-agree__label a { color: #0f6e56; font-weight: 600; text-decoration: none; }
.tf-agree__label a:hover { text-decoration: underline; }
.tf-agree__label strong { color: #111827; }

/* Submit */
.tf-submit {
    width: 100%;
    padding: 14px;
    background: #0f6e56;
    color: #fff;
    border: none;
    border-radius: 12px;
    font-size: 15px;
    font-weight: 700;
    cursor: pointer;
    font-family: inherit;
    transition: background .15s, transform .1s;
    letter-spacing: .01em;
    box-shadow: 0 4px 14px rgba(15,110,86,.25);
}
.tf-submit:hover { background: #085041; transform: translateY(-1px); }
.tf-submit:active { transform: translateY(0); }
.tf-footer-note {
    text-align: center;
    font-size: 11px;
    color: #9ca3af;
    margin-top: 12px;
    font-style: italic;
}

/* Responsive */
@media (min-width: 480px) {
    .tf-hero h1 { font-size: 22px; }
    .tf-card { padding: 20px; }
    .tf-container { padding: 0 20px; }
}
@media (min-width: 640px) {
    .tf-page { padding: 32px 0 60px; }
    .tf-hero { padding: 28px 24px; }
}
</style>


<script>
function triggerFile(id) {
    const el = document.getElementById(id);
    if (el) el.click();
}

function updateUploadLabel(input, labelId) {
    const label = document.getElementById(labelId);
    if (!label) return;
    if (input.files && input.files[0]) {
        label.innerHTML = '<span style="color:#059669;font-style:italic;font-weight:400">✓ ' + input.files[0].name + '</span>';
    }
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

/* ======================== PETA + GEOCODE ======================== */
(function () {
    var map         = L.map('map-picker-mentor').setView([-2.5, 118], 5);
    var marker      = null;
    var debTimer    = null;
    var isGeocoding = false;
    var hintEl      = document.getElementById('map-picker-hint-mentor');
    var loadEl      = document.getElementById('map-mentor-loading');

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors', maxZoom: 19
    }).addTo(map);

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

    map.on('click', function (e) { setMarker(e.latlng.lat, e.latlng.lng, false); });

    function selText(id) {
        var el = document.getElementById(id);
        if (!el || !el.value) return '';
        return el.options[el.selectedIndex].text;
    }

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
        if (!kelVal || alamat.trim().length < 5) return;

        isGeocoding = true;
        loadEl.style.display = 'flex';
        hintEl.textContent   = '🔍 Mencari lokasi...';
        hintEl.style.color   = '#6b7280';

        var p1 = new URLSearchParams({
            format: 'json', limit: '1', countrycodes: 'id', 'accept-language': 'id,en',
            street: alamat.trim(), suburb: kelText, city: kabText, state: provText, country: 'Indonesia'
        });

        fetch('https://nominatim.openstreetmap.org/search?' + p1.toString())
            .then(function (r) { return r.json(); })
            .then(function (h1) {
                if (h1 && h1.length > 0) return h1[0];
                var q2 = [kelText, kecText, kabText, provText].filter(Boolean).join(', ');
                var p2 = new URLSearchParams({ format: 'json', limit: '1', countrycodes: 'id', 'accept-language': 'id,en', q: q2 + ', Indonesia' });
                return fetch('https://nominatim.openstreetmap.org/search?' + p2.toString())
                    .then(function (r2) { return r2.json(); })
                    .then(function (h2) { return (h2 && h2.length > 0) ? h2[0] : null; });
            })
            .then(function (result) {
                loadEl.style.display = 'none';
                isGeocoding = false;
                if (!result) { hintEl.textContent = '⚠️ Lokasi tidak ditemukan otomatis. Klik langsung di peta.'; hintEl.style.color = '#b45309'; return; }
                var lat = parseFloat(result.lat);
                var lng = parseFloat(result.lon);
                if (lat >= -11 && lat <= 6 && lng >= 95 && lng <= 141) {
                    setMarker(lat, lng, true);
                } else {
                    hintEl.textContent = '⚠️ Hasil di luar Indonesia. Klik langsung di peta.';
                    hintEl.style.color = '#b45309';
                }
            })
            .catch(function (err) {
                loadEl.style.display = 'none';
                isGeocoding = false;
                hintEl.textContent = '⚠️ Gagal terhubung ke layanan peta. Klik titik di peta secara manual.';
                hintEl.style.color = '#b45309';
            });
    }
})();

/* ======================== WILAYAH API ======================== */
(function () {
    var BASE = 'https://www.emsifa.com/api-wilayah-indonesia/api';
    var elProv = document.getElementById('provinsi');
    var elKab  = document.getElementById('kabupaten');
    var elKec  = document.getElementById('kecamatan');
    var elKel  = document.getElementById('kelurahan');

    function resetSelect(el, label) {
        el.innerHTML = '<option value="">' + label + '</option>';
        el.disabled = true;
    }

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
        fetch(BASE + '/districts/' + kabId + '.json')
            .then(function (r) { return r.json(); })
            .then(function (data) {
                data.forEach(function (k) {
                    var o = document.createElement('option');
                    o.value = k.name; o.dataset.id = k.id; o.textContent = k.name;
                    elKec.appendChild(o);
                });
                elKec.disabled = false;
            });
    });

    elKec.addEventListener('change', function () {
        resetSelect(elKel, 'Pilih Desa/Kelurahan');
        if (!this.value) return;
        var kecId = this.options[this.selectedIndex].dataset.id;
        fetch(BASE + '/villages/' + kecId + '.json')
            .then(function (r) { return r.json(); })
            .then(function (data) {
                data.forEach(function (k) {
                    var o = document.createElement('option');
                    o.value = k.name; o.dataset.id = k.id; o.textContent = k.name;
                    elKel.appendChild(o);
                });
                elKel.disabled = false;
            });
    });

    elKel.addEventListener('change', function () {
        if (!this.value) return;
        if (typeof window.mentorGeocode === 'function') window.mentorGeocode();
    });

    var inputLokasi = document.getElementById('gmaps_location');
    if (inputLokasi) {
        inputLokasi.addEventListener('input', function () {
            var kelVal = (document.getElementById('kelurahan') || {}).value || '';
            if (kelVal) window.mentorGeocode();
        });
    }
})();
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\webkajiindonesia\resources\views/profile/daftar-mentor.blade.php ENDPATH**/ ?>