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
            <h1>Formulir Pendaftaran Trainer</h1>
            <p>Lengkapi data di bawah ini dengan benar untuk ditinjau oleh Admin.</p>
        </div>

        
        <?php if($trainer?->status === 'pending'): ?>
            <div class="tf-banner tf-banner--pending">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="tf-banner__icon">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <p class="tf-banner__title">Pendaftaran Sedang Ditinjau</p>
                    <p class="tf-banner__body">Data kamu sudah diterima dan sedang dalam proses review oleh Admin. Kamu tidak bisa mengubah data saat ini.</p>
                </div>
            </div>
        <?php elseif($trainer?->status === 'rejected'): ?>
            <div class="tf-banner tf-banner--rejected">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="tf-banner__icon">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <p class="tf-banner__title">Pendaftaran Ditolak</p>
                    <?php if($trainer->rejection_reason): ?>
                        <p class="tf-banner__body">Alasan: <strong><?php echo e($trainer->rejection_reason); ?></strong></p>
                    <?php endif; ?>
                    <p class="tf-banner__body" style="color:#dc2626">Silakan perbaiki data di bawah dan kirim ulang.</p>
                </div>
            </div>
        <?php endif; ?>

        
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
            action="<?php echo e(route('profile.simpan-trainer')); ?>"
            method="POST"
            enctype="multipart/form-data"
            <?php if($trainer?->status === 'pending'): ?> onsubmit="return false;" <?php endif; ?>
        >
            <?php echo csrf_field(); ?>

            
            <div class="tf-card">
                <div class="tf-card__header">Data Diri</div>

                <div class="tf-field">
                    <label class="tf-label">Nama Lengkap & Gelar Akademik <span class="tf-req">*</span></label>
                    <input
                        type="text"
                        name="academic_degree"
                        value="<?php echo e(old('academic_degree', $trainer?->academic_degree)); ?>"
                        placeholder="Contoh: Martin Louis, S.E., M.M."
                        class="tf-input"
                        required
                        <?php if($trainer?->status === 'pending'): ?> readonly <?php endif; ?>
                    >
                </div>

                <div class="tf-grid-2">
                    <div class="tf-field">
                        <label class="tf-label">No. WhatsApp <span class="tf-req">*</span></label>
                        <input
                            type="text"
                            name="no_hp"
                            value="<?php echo e(old('no_hp', $trainer?->no_hp ?? $user->phone)); ?>"
                            class="tf-input"
                            required
                            <?php if($trainer?->status === 'pending'): ?> readonly <?php endif; ?>
                        >
                    </div>
                    <div class="tf-field">
                        <label class="tf-label">Email Aktif <span class="tf-req">*</span></label>
                        <input
                            type="email"
                            name="email"
                            value="<?php echo e(old('email', $trainer?->email ?? $user->email)); ?>"
                            class="tf-input"
                            required
                            <?php if($trainer?->status === 'pending'): ?> readonly <?php endif; ?>
                        >
                    </div>
                </div>

                <div class="tf-grid-2">
                    <div class="tf-field">
                        <label class="tf-label">Nomor NIK/KTP <span class="tf-req">*</span></label>
                        <input
                            type="text"
                            name="nik"
                            value="<?php echo e(old('nik', $trainer?->nik)); ?>"
                            class="tf-input"
                            required
                            <?php if($trainer?->status === 'pending'): ?> readonly <?php endif; ?>
                        >
                    </div>
                    <div class="tf-field">
                        <label class="tf-label">
                            NPWP
                            <span class="tf-label--optional">(Opsional)</span>
                        </label>
                        <input
                            type="text"
                            name="npwp"
                            value="<?php echo e(old('npwp', $trainer?->npwp)); ?>"
                            class="tf-input"
                            <?php if($trainer?->status === 'pending'): ?> readonly <?php endif; ?>
                        >
                    </div>
                </div>
            </div>

            
            <div class="tf-card">
                <div class="tf-card__header">Alamat Domisili</div>

                <div class="tf-field">
                    <label class="tf-label">Alamat Domisili Sekarang <span class="tf-req">*</span></label>
                    <input
                        type="text"
                        name="gmaps_location"
                        value="<?php echo e(old('gmaps_location', $trainer?->gmaps_location)); ?>"
                        placeholder="Jl. Raya Darmo No.1, RT 03/RW 05, Wonokromo, Surabaya 60241"
                        class="tf-input"
                        required
                        <?php if($trainer?->status === 'pending'): ?> readonly <?php endif; ?>
                    >
                    <p class="tf-hint">* Wajib sertakan RT/RW dan kode pos</p>
                </div>

                <div class="tf-grid-2">
                    <div class="tf-field">
                        <label class="tf-label">Provinsi <span class="tf-req">*</span></label>
                        <select
                            name="provinsi"
                            id="provinsi"
                            data-selected="<?php echo e(old('provinsi', $trainer?->provinsi)); ?>"
                            class="tf-select"
                            required
                            <?php if($trainer?->status === 'pending'): ?> disabled <?php endif; ?>
                        >
                            <option value="">Pilih Provinsi</option>
                        </select>
                    </div>
                    <div class="tf-field">
                        <label class="tf-label">Kabupaten / Kota <span class="tf-req">*</span></label>
                        <select
                            name="kabupaten"
                            id="kabupaten"
                            data-selected="<?php echo e(old('kabupaten', $trainer?->kabupaten)); ?>"
                            class="tf-select"
                            required
                            disabled
                        >
                            <option value="">Pilih Kabupaten/Kota</option>
                        </select>
                    </div>
                    <div class="tf-field">
                        <label class="tf-label">Kecamatan <span class="tf-req">*</span></label>
                        <select
                            name="kecamatan"
                            id="kecamatan"
                            data-selected="<?php echo e(old('kecamatan', $trainer?->kecamatan)); ?>"
                            class="tf-select"
                            required
                            disabled
                        >
                            <option value="">Pilih Kecamatan</option>
                        </select>
                    </div>
                    <div class="tf-field">
                        <label class="tf-label">Desa / Kelurahan <span class="tf-req">*</span></label>
                        <select
                            name="kelurahan"
                            id="kelurahan"
                            data-selected="<?php echo e(old('kelurahan', $trainer?->kelurahan)); ?>"
                            class="tf-select"
                            required
                            disabled
                        >
                            <option value="">Pilih Desa/Kelurahan</option>
                        </select>
                    </div>
                </div>
            </div>

            
            <div class="tf-card">
                <div class="tf-card__header">Kualifikasi</div>

                <div class="tf-grid-2">
                    <div class="tf-field">
                        <label class="tf-label">Ijazah Terakhir <span class="tf-req">*</span></label>
                        <?php $selectedIjazah = old('ijazah_type', $trainer?->ijazah_type) ?>
                        <select
                            name="ijazah_type"
                            class="tf-select"
                            required
                            <?php if($trainer?->status === 'pending'): ?> disabled <?php endif; ?>
                        >
                            <option value="SMA" <?php echo e($selectedIjazah == 'SMA' ? 'selected' : ''); ?>>SMA/SMK Sederajat</option>
                            <option value="D3"  <?php echo e($selectedIjazah == 'D3'  ? 'selected' : ''); ?>>D3</option>
                            <option value="S1"  <?php echo e($selectedIjazah == 'S1'  ? 'selected' : ''); ?>>S1</option>
                            <option value="S2"  <?php echo e($selectedIjazah == 'S2'  ? 'selected' : ''); ?>>S2</option>
                            <option value="S3"  <?php echo e($selectedIjazah == 'S3'  ? 'selected' : ''); ?>>S3</option>
                        </select>
                    </div>
                    <div class="tf-field">
                        <label class="tf-label">Link Drive Dokumentasi <span class="tf-req">*</span></label>
                        <input
                            type="url"
                            name="drive_link_documentation"
                            value="<?php echo e(old('drive_link_documentation', $trainer?->drive_link_documentation)); ?>"
                            placeholder="https://drive.google.com/..."
                            class="tf-input"
                            required
                            <?php if($trainer?->status === 'pending'): ?> readonly <?php endif; ?>
                        >
                    </div>
                </div>

                <div class="tf-field">
                    <label class="tf-label">Pengalaman Sebagai Trainer <span class="tf-req">*</span></label>
                    <textarea
                        name="experience"
                        rows="3"
                        placeholder="Berapa lama dan di bidang apa Anda menjadi Trainer..."
                        class="tf-textarea"
                        required
                        <?php if($trainer?->status === 'pending'): ?> readonly <?php endif; ?>
                    ><?php echo e(old('experience', $trainer?->experience)); ?></textarea>
                </div>

                <div class="tf-field">
                    <label class="tf-label">Tentang Diri Anda <span class="tf-req">*</span></label>
                    <textarea
                        name="bio"
                        rows="3"
                        placeholder="Deskripsi singkat tentang diri Anda..."
                        class="tf-textarea"
                        required
                        <?php if($trainer?->status === 'pending'): ?> readonly <?php endif; ?>
                    ><?php echo e(old('bio', $trainer?->bio)); ?></textarea>
                </div>
            </div>

            
            <div class="tf-card">
                <div class="tf-card__header">Upload Dokumen</div>

                <div class="tf-grid-2">

                    
                    <div class="tf-field">
                        <label class="tf-label">Scan KTP <span class="tf-req">*</span></label>
                        <div class="tf-upload" onclick="triggerFile('file-ktp')" role="button" tabindex="0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0"/>
                            </svg>
                            <span class="tf-upload__label" id="label-ktp">
                                <?php if($trainer?->ktp_scan): ?>
                                    <span class="tf-upload__existing">✓ Sudah diupload</span><br>Ganti file
                                <?php else: ?>
                                    Tambahkan file
                                <?php endif; ?>
                            </span>
                            <span class="tf-upload__hint">JPG, PNG, PDF · Maks 2 MB</span>
                        </div>
                        <input
                            type="file"
                            name="ktp_scan"
                            id="file-ktp"
                            class="tf-file-hidden"
                            accept="image/*,.pdf"
                            <?php echo e(!$trainer?->ktp_scan ? 'required' : ''); ?>

                            onchange="updateUploadLabel(this, 'label-ktp')"
                            <?php if($trainer?->status === 'pending'): ?> disabled <?php endif; ?>
                        >
                    </div>

                    
                    <div class="tf-field">
                        <label class="tf-label">Sertifikat BNSP <span class="tf-req">*</span></label>
                        <div class="tf-upload" onclick="triggerFile('file-bnsp')" role="button" tabindex="0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                            </svg>
                            <span class="tf-upload__label" id="label-bnsp">
                                <?php if($trainer?->bnsp_certificate): ?>
                                    <span class="tf-upload__existing">✓ Sudah diupload</span><br>Ganti file
                                <?php else: ?>
                                    Tambahkan file
                                <?php endif; ?>
                            </span>
                            <span class="tf-upload__hint">JPG, PNG, PDF · Maks 2 MB</span>
                        </div>
                        <input
                            type="file"
                            name="bnsp_certificate"
                            id="file-bnsp"
                            class="tf-file-hidden"
                            accept="image/*,.pdf"
                            <?php echo e(!$trainer?->bnsp_certificate ? 'required' : ''); ?>

                            onchange="updateUploadLabel(this, 'label-bnsp')"
                            <?php if($trainer?->status === 'pending'): ?> disabled <?php endif; ?>
                        >
                    </div>
                </div>

                
                <div class="tf-field">
                    <label class="tf-label">Pas Foto Background Putih <span class="tf-req">*</span></label>
                    <div class="tf-upload tf-upload--wide" onclick="triggerFile('file-pasfoto')" role="button" tabindex="0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <div>
                            <span class="tf-upload__label" id="label-pasfoto">
                                <?php if($trainer?->white_bg_photo): ?>
                                    <span class="tf-upload__existing">✓ Sudah diupload</span>&nbsp; Ganti file
                                <?php else: ?>
                                    Tambahkan file
                                <?php endif; ?>
                            </span>
                            <span class="tf-upload__hint" style="display:block">JPG, PNG · Maks 2 MB</span>
                        </div>
                    </div>
                    <input
                        type="file"
                        name="white_bg_photo"
                        id="file-pasfoto"
                        class="tf-file-hidden"
                        accept="image/*"
                        <?php echo e(!$trainer?->white_bg_photo ? 'required' : ''); ?>

                        onchange="updateUploadLabel(this, 'label-pasfoto')"
                        <?php if($trainer?->status === 'pending'): ?> disabled <?php endif; ?>
                    >
                </div>
            </div>

            
            <div class="tf-card">
                <div class="tf-card__header">Biaya Pendaftaran</div>

                <p class="tf-biaya-desc">
                    Transfer biaya pendaftaran sebesar <strong>Rp200.000</strong> ke rekening berikut, lalu unggah bukti transfer.
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
                            <span class="tf-upload__label" id="label-transfer">
                                <?php if($trainer?->bukti_transfer): ?>
                                    <span class="tf-upload__existing">✓ Sudah diupload</span>&nbsp; Ganti file
                                <?php else: ?>
                                    Tambahkan file
                                <?php endif; ?>
                            </span>
                            <span class="tf-upload__hint" style="display:block">JPG, PNG, PDF · Maks 2 MB</span>
                        </div>
                    </div>
                    <input
                        type="file"
                        name="bukti_transfer"
                        id="file-transfer"
                        class="tf-file-hidden"
                        accept="image/*,.pdf"
                        <?php echo e(!$trainer?->bukti_transfer ? 'required' : ''); ?>

                        onchange="updateUploadLabel(this, 'label-transfer')"
                        <?php if($trainer?->status === 'pending'): ?> disabled <?php endif; ?>
                    >
                </div>
            </div>

            
            <div class="tf-agree">
                <input
                    type="checkbox"
                    name="agree_terms"
                    id="agree_terms"
                    value="1"
                    <?php echo e($trainer?->agree_terms ? 'checked' : 'required'); ?>

                    class="tf-agree__check"
                    <?php if($trainer?->status === 'pending'): ?> disabled <?php endif; ?>
                >
                <label for="agree_terms" class="tf-agree__label">
                    Saya setuju dengan
                    <a href="https://kajiindonesia.com/" target="_blank" rel="noopener">Syarat dan Ketentuan</a>
                    serta
                    <a href="https://kajiindonesia.com/" target="_blank" rel="noopener">Kebijakan Privasi</a>
                    yang berlaku di <strong>KAJI Indonesia</strong>.
                </label>
            </div>

            
            <?php if($trainer?->status === 'pending'): ?>
                <button type="button" class="tf-submit tf-submit--disabled" disabled>
                    Menunggu Verifikasi Admin...
                </button>
            <?php else: ?>
                <button type="submit" class="tf-submit">
                    <?php echo e($trainer?->status === 'rejected' ? 'Kirim Ulang Persyaratan' : 'Kirim Seluruh Persyaratan'); ?>

                </button>
            <?php endif; ?>

            <p class="tf-footer-note">
                * Pendaftaran akan ditinjau oleh Admin sebelum ditampilkan di halaman Trainer.
            </p>

        </form>
    </div>
</div>


<style>
/* ---- Reset & Base ---- */
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

/* ---- Back Link ---- */
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

/* ---- Hero ---- */
.tf-hero {
    background: #0f6e56;
    border-radius: 14px;
    padding: 22px 20px;
    text-align: center;
    color: #fff;
    margin-bottom: 10px;
}
.tf-hero h1 {
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 5px;
}
.tf-hero p {
    font-size: 13px;
    color: #a9d9c6;
    line-height: 1.5;
}

/* ---- Banner ---- */
.tf-banner {
    display: flex;
    gap: 10px;
    align-items: flex-start;
    padding: 12px 14px;
    border-radius: 0 10px 10px 0;
    margin-bottom: 10px;
    border-left: 3px solid;
}
.tf-banner--pending {
    background: #fefce8;
    border-color: #f59e0b;
}
.tf-banner--rejected {
    background: #fef2f2;
    border-color: #ef4444;
}
.tf-banner__icon {
    flex-shrink: 0;
    margin-top: 1px;
}
.tf-banner--pending .tf-banner__icon { color: #d97706; }
.tf-banner--rejected .tf-banner__icon { color: #dc2626; }
.tf-banner__title {
    font-size: 13px;
    font-weight: 700;
    margin-bottom: 3px;
}
.tf-banner--pending .tf-banner__title { color: #92400e; }
.tf-banner--rejected .tf-banner__title { color: #991b1b; }
.tf-banner__body {
    font-size: 12px;
    line-height: 1.5;
    margin-bottom: 2px;
}
.tf-banner--pending .tf-banner__body { color: #92400e; }
.tf-banner--rejected .tf-banner__body { color: #991b1b; }

/* ---- Error List ---- */
.tf-error-list {
    list-style: disc;
    padding-left: 16px;
    font-size: 12px;
    color: #991b1b;
    margin-top: 4px;
    line-height: 1.7;
}

/* ---- Card ---- */
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

/* ---- Field ---- */
.tf-field {
    margin-bottom: 12px;
}
.tf-field:last-child {
    margin-bottom: 0;
}
.tf-label {
    display: block;
    font-size: 12px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 5px;
}
.tf-req { color: #dc2626; font-weight: 400; }
.tf-label--optional {
    font-weight: 400;
    color: #9ca3af;
    font-size: 11px;
}
.tf-hint {
    font-size: 10px;
    color: #9ca3af;
    margin-top: 4px;
}

/* ---- Inputs ---- */
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
}
.tf-input:focus,
.tf-select:focus,
.tf-textarea:focus {
    border-color: #0f6e56;
    box-shadow: 0 0 0 3px rgba(15,110,86,.1);
}
.tf-input[readonly],
.tf-select[disabled],
.tf-textarea[readonly] {
    background: #f9fafb;
    color: #6b7280;
    cursor: not-allowed;
}
.tf-select {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='none' viewBox='0 0 24 24'%3E%3Cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 10px center;
    padding-right: 36px;
}
.tf-textarea { resize: vertical; line-height: 1.55; min-height: 80px; }

/* ---- Grid ---- */
.tf-grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}
@media (max-width: 400px) {
    .tf-grid-2 {
        grid-template-columns: 1fr;
    }
}

/* ---- Upload ---- */
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
}
.tf-upload:hover {
    border-color: #0f6e56;
    background: #f0faf6;
}
.tf-upload svg { color: #0f6e56; flex-shrink: 0; }
.tf-upload__label {
    font-size: 12px;
    font-weight: 600;
    color: #0f6e56;
    line-height: 1.5;
}
.tf-upload__existing {
    font-size: 11px;
    color: #059669;
    display: block;
    font-style: italic;
    font-weight: 400;
}
.tf-upload__hint {
    font-size: 10px;
    color: #9ca3af;
}
.tf-upload--wide {
    flex-direction: row;
    text-align: left;
    gap: 12px;
    padding: 12px 16px;
    min-height: auto;
}
.tf-file-hidden {
    display: none;
}

/* ---- Rekening ---- */
.tf-biaya-desc {
    font-size: 13px;
    color: #4b5563;
    line-height: 1.6;
    margin-bottom: 12px;
}
.tf-biaya-desc strong { color: #111827; }
.tf-rekening {
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    overflow: hidden;
}
.tf-rek-row {
    display: flex;
    align-items: center;
    padding: 9px 14px;
    border-bottom: 1px solid #f3f4f6;
    font-size: 13px;
    gap: 8px;
}
.tf-rek-row:last-child { border-bottom: none; }
.tf-rek-label {
    color: #6b7280;
    font-size: 12px;
    width: 90px;
    flex-shrink: 0;
}
.tf-rek-val {
    font-weight: 600;
    color: #111827;
    flex: 1;
    letter-spacing: .02em;
}
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

/* ---- Agree ---- */
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
.tf-agree__label {
    font-size: 12px;
    color: #4b5563;
    line-height: 1.7;
    cursor: pointer;
}
.tf-agree__label a {
    color: #0f6e56;
    font-weight: 600;
    text-decoration: none;
}
.tf-agree__label a:hover { text-decoration: underline; }
.tf-agree__label strong { color: #111827; }

/* ---- Submit ---- */
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
.tf-submit--disabled {
    background: #9ca3af;
    cursor: not-allowed;
    box-shadow: none;
}
.tf-footer-note {
    text-align: center;
    font-size: 11px;
    color: #9ca3af;
    margin-top: 12px;
    font-style: italic;
}

/* ---- Responsive fine-tuning ---- */
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
    /* ---- File upload helper ---- */
    function triggerFile(id) {
        const el = document.getElementById(id);
        if (el && !el.disabled) el.click();
    }

    function updateUploadLabel(input, labelId) {
        const label = document.getElementById(labelId);
        if (!label) return;
        if (input.files && input.files[0]) {
            label.innerHTML = '<span style="color:#059669;font-style:italic;font-weight:400">✓ ' + input.files[0].name + '</span>';
        }
    }

    /* ---- Salin rekening ---- */
    function copyRekening() {
        const noRek = document.getElementById('nomor-rek').textContent.trim();
        const label = document.getElementById('copy-label');
        const done = () => {
            label.textContent = '✓ Tersalin!';
            setTimeout(() => { label.textContent = 'Salin'; }, 2000);
        };
        if (navigator.clipboard) {
            navigator.clipboard.writeText(noRek).then(done);
        } else {
            const el = document.createElement('textarea');
            el.value = noRek;
            document.body.appendChild(el);
            el.select();
            document.execCommand('copy');
            document.body.removeChild(el);
            done();
        }
    }

    /* ======================== WILAYAH API ======================== */
    const BASE_URL = 'https://www.emsifa.com/api-wilayah-indonesia/api';

    const provinsiSelect  = document.getElementById('provinsi');
    const kabupatenSelect = document.getElementById('kabupaten');
    const kecamatanSelect = document.getElementById('kecamatan');
    const kelurahanSelect = document.getElementById('kelurahan');

    const savedProvinsi  = provinsiSelect.dataset.selected  || '';
    const savedKabupaten = kabupatenSelect.dataset.selected || '';
    const savedKecamatan = kecamatanSelect.dataset.selected || '';
    const savedKelurahan = kelurahanSelect.dataset.selected || '';

    /* Load provinsi */
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
                if (savedKabId && savedKecamatan) loadKecamatan(savedKabId, savedKecamatan);
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
                if (savedKecId && savedKelurahan) loadKelurahan(savedKecId, savedKelurahan);
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

    /* Event listeners pilih manual */
    provinsiSelect.addEventListener('change', function () {
        resetSelect(kabupatenSelect, 'Pilih Kabupaten/Kota');
        resetSelect(kecamatanSelect, 'Pilih Kecamatan');
        resetSelect(kelurahanSelect, 'Pilih Desa/Kelurahan');
        if (!this.value) return;
        const id = this.options[this.selectedIndex].dataset.id;
        loadKabupaten(id);
    });

    kabupatenSelect.addEventListener('change', function () {
        resetSelect(kecamatanSelect, 'Pilih Kecamatan');
        resetSelect(kelurahanSelect, 'Pilih Desa/Kelurahan');
        if (!this.value) return;
        const id = this.options[this.selectedIndex].dataset.id;
        loadKecamatan(id);
    });

    kecamatanSelect.addEventListener('change', function () {
        resetSelect(kelurahanSelect, 'Pilih Desa/Kelurahan');
        if (!this.value) return;
        const id = this.options[this.selectedIndex].dataset.id;
        loadKelurahan(id);
    });

    function resetSelect(selectEl, placeholder) {
        selectEl.innerHTML = `<option value="">${placeholder}</option>`;
        selectEl.disabled = true;
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\webkajiindonesia\resources\views/profile/daftar-trainer.blade.php ENDPATH**/ ?>