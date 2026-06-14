<?php $__env->startSection('page-title', 'Approval Mentor'); ?>

<?php $__env->startPush('styles'); ?>
<style>
/* ===================== RESPONSIVE MOBILE - APPROVAL MENTOR ===================== */

@media (max-width: 768px) {

    /* Tab bar scroll horizontal */
    .tab-bar {
        width: 100% !important;
        overflow-x: auto !important;
        flex-wrap: nowrap !important;
        -webkit-overflow-scrolling: touch;
    }
    .tab-btn {
        white-space: nowrap !important;
        flex-shrink: 0 !important;
    }

    /* Table card header */
    .table-card-header {
        flex-direction: column !important;
        align-items: flex-start !important;
        gap: 6px !important;
        padding: 12px 14px !important;
    }

    /* Tabel: fixed layout */
    .table-card table {
        table-layout: fixed !important;
        width: 100% !important;
    }

    /* ── TAB PENDING (5 kolom): Pendaftar|Kontak|Lokasi|Dikirim|Aksi ── */
    /* Sembunyikan: Kontak(2), Lokasi(3), Dikirim(4) */
    #tab-pending thead tr th:nth-child(2),
    #tab-pending tbody tr td:nth-child(2),
    #tab-pending thead tr th:nth-child(3),
    #tab-pending tbody tr td:nth-child(3),
    #tab-pending thead tr th:nth-child(4),
    #tab-pending tbody tr td:nth-child(4) {
        display: none !important;
    }
    #tab-pending thead tr th:nth-child(1),
    #tab-pending tbody tr td:nth-child(1) { width: 55% !important; }
    #tab-pending thead tr th:nth-child(5),
    #tab-pending tbody tr td:nth-child(5) { width: 45% !important; }

    /* ── TAB APPROVED (6 kolom): Mentor|Kontak|Lokasi|Disetujui|Status|Aksi ── */
    /* Sembunyikan: Kontak(2), Lokasi(3), Disetujui(4), Status(5) */
    #tab-approved thead tr th:nth-child(2),
    #tab-approved tbody tr td:nth-child(2),
    #tab-approved thead tr th:nth-child(3),
    #tab-approved tbody tr td:nth-child(3),
    #tab-approved thead tr th:nth-child(4),
    #tab-approved tbody tr td:nth-child(4),
    #tab-approved thead tr th:nth-child(5),
    #tab-approved tbody tr td:nth-child(5) {
        display: none !important;
    }
    #tab-approved thead tr th:nth-child(1),
    #tab-approved tbody tr td:nth-child(1) { width: 55% !important; }
    #tab-approved thead tr th:nth-child(6),
    #tab-approved tbody tr td:nth-child(6) { width: 45% !important; }

    /* ── TAB REJECTED (5 kolom): Pendaftar|Kontak|Alasan|Ditolak|Aksi ── */
    /* Sembunyikan: Kontak(2), Alasan(3), Ditolak(4) */
    #tab-rejected thead tr th:nth-child(2),
    #tab-rejected tbody tr td:nth-child(2),
    #tab-rejected thead tr th:nth-child(3),
    #tab-rejected tbody tr td:nth-child(3),
    #tab-rejected thead tr th:nth-child(4),
    #tab-rejected tbody tr td:nth-child(4) {
        display: none !important;
    }
    #tab-rejected thead tr th:nth-child(1),
    #tab-rejected tbody tr td:nth-child(1) { width: 55% !important; }
    #tab-rejected thead tr th:nth-child(5),
    #tab-rejected tbody tr td:nth-child(5) { width: 45% !important; }

    /* Padding baris */
    thead th {
        padding: 10px 10px !important;
        font-size: 9px !important;
    }
    tbody td {
        padding: 10px 10px !important;
    }

    /* Submitter cell */
    .submitter { gap: 6px !important; }

    .submitter-avatar {
        width: 32px !important;
        height: 32px !important;
        font-size: 10px !important;
        flex-shrink: 0 !important;
    }

    .submitter-name {
        font-size: 11px !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        white-space: nowrap !important;
        max-width: 100px !important;
    }

    .submitter-sub {
        font-size: 10px !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        white-space: nowrap !important;
        max-width: 100px !important;
    }

    /* Tombol aksi: susun vertikal, semua sama lebar */
    .action-group {
        flex-direction: column !important;
        gap: 4px !important;
        align-items: stretch !important;
        width: 100% !important;
    }

    .action-group .btn-sm {
        font-size: 11px !important;
        padding: 6px 4px !important;
        white-space: nowrap !important;
        justify-content: center !important;
        width: 100% !important;
        display: flex !important;
        box-sizing: border-box !important;
        min-height: 30px !important;
    }

    .action-group .btn-sm svg {
        width: 13px !important;
        height: 13px !important;
        flex-shrink: 0 !important;
    }

    /* ── Modal: slide dari bawah ── */
    .modal-overlay {
        align-items: flex-end !important;
        padding: 0 !important;
    }

    .modal {
        width: 100% !important;
        max-width: 100% !important;
        border-radius: 20px 20px 0 0 !important;
        padding: 20px 16px 32px !important;
        max-height: 92vh !important;
    }

    #modal-reject .modal {
        width: 100% !important;
    }

    /* Foto preview di modal */
    .img-preview {
        height: 130px !important;
        margin-bottom: 14px !important;
    }

    /* Detail grid: 1 kolom */
    .detail-grid {
        grid-template-columns: 1fr !important;
        gap: 8px !important;
    }

    .detail-item.full {
        grid-column: 1 !important;
    }

    /* Tombol dokumen di modal: 2 kolom */
    #modal-detail .modal > div[style*="gap:10px"] {
        flex-wrap: wrap !important;
    }

    #modal-detail .modal > div[style*="gap:10px"] .btn {
        flex: 1 1 calc(50% - 5px) !important;
        min-width: 0 !important;
        font-size: 11px !important;
        padding: 7px 4px !important;
        justify-content: center !important;
    }

    /* Tombol bukti transfer: full width */
    #modal-detail .modal > div[style*="margin-top:8px"] .btn {
        width: 100% !important;
        justify-content: center !important;
        font-size: 12px !important;
    }

    /* Form reject */
    .form-textarea {
        font-size: 14px !important;
    }
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>


<div class="tab-bar">
    <button class="tab-btn active" data-tab="pending" onclick="switchTab('pending', this)">
        Menunggu
        <?php if($stats['pending'] > 0): ?>
            <span class="count-pill"><?php echo e($stats['pending']); ?></span>
        <?php endif; ?>
    </button>
    <button class="tab-btn" data-tab="approved" onclick="switchTab('approved', this)">
        Disetujui
        <?php if($stats['approved'] > 0): ?>
            <span class="count-pill" style="background:var(--accent);"><?php echo e($stats['approved']); ?></span>
        <?php endif; ?>
    </button>
    <button class="tab-btn" data-tab="rejected" onclick="switchTab('rejected', this)">
        Ditolak
        <?php if($stats['rejected'] > 0): ?>
            <span class="count-pill" style="background:#9ca3af;"><?php echo e($stats['rejected']); ?></span>
        <?php endif; ?>
    </button>
</div>


<div id="tab-pending">
    <div class="table-card">
        <div class="table-card-header">
            <div class="table-card-title">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Pendaftaran Menunggu Review
                <span class="table-card-subtitle"><?php echo e($stats['pending']); ?> pendaftar</span>
            </div>
        </div>

        <?php if($pending->isEmpty()): ?>
            <div class="empty-state">
                <div class="empty-state-icon">🎉</div>
                <div class="empty-state-text">Tidak ada pendaftaran yang menunggu review.</div>
            </div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Pendaftar</th>
                        <th>Kontak</th>
                        <th>Lokasi</th>
                        <th>Dikirim</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $pending; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <div class="submitter">
                                <div class="submitter-avatar" style="background:var(--accent);">
                                    <?php echo e(strtoupper(substr($item->full_name, 0, 2))); ?>

                                </div>
                                <div>
                                    <div class="submitter-name"><?php echo e($item->full_name); ?></div>
                                    <div class="submitter-sub"><?php echo e($item->user->email ?? '-'); ?></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="font-size:13px;"><?php echo e($item->phone); ?></div>
                            <div style="font-size:11px;color:var(--text-muted);"><?php echo e($item->email); ?></div>
                        </td>
                        <td style="max-width:180px;">
                            <div style="font-size:12px;color:var(--text-muted);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                <?php echo e($item->gmaps_location); ?>

                            </div>
                        </td>
                        <td>
                            <div style="font-size:12px;color:var(--text-muted);">
                                <?php echo e($item->created_at->diffForHumans()); ?>

                            </div>
                        </td>
                        <td>
                            <div class="action-group">
                                <button class="btn btn-ghost btn-sm" onclick="openDetailModal(<?php echo e($item->id); ?>)">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Detail
                                </button>
                                <form method="POST" action="<?php echo e(route('admin.approval.mentor.approve', $item)); ?>?tab=approved" style="display:inline;">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-approve btn-sm">
                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Setujui
                                    </button>
                                </form>
                                <button class="btn btn-reject btn-sm" onclick="openRejectModal(<?php echo e($item->id); ?>, '<?php echo e(addslashes($item->full_name)); ?>')">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Tolak
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>


<div id="tab-approved" style="display:none;">
    <div class="table-card">
        <div class="table-card-header">
            <div class="table-card-title">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Mentor Disetujui
                <span class="table-card-subtitle"><?php echo e($stats['approved']); ?> mentor aktif</span>
            </div>
        </div>

        <?php if($approved->isEmpty()): ?>
            <div class="empty-state">
                <div class="empty-state-icon">📭</div>
                <div class="empty-state-text">Belum ada pendaftaran yang disetujui.</div>
            </div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Mentor</th>
                        <th>Kontak</th>
                        <th>Lokasi</th>
                        <th>Disetujui</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $approved; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <div class="submitter">
                                <div class="submitter-avatar" style="background:var(--accent);">
                                    <?php echo e(strtoupper(substr($item->full_name, 0, 2))); ?>

                                </div>
                                <div>
                                    <div class="submitter-name"><?php echo e($item->full_name); ?></div>
                                    <div class="submitter-sub"><?php echo e($item->user->email ?? '-'); ?></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="font-size:13px;"><?php echo e($item->phone); ?></div>
                            <div style="font-size:11px;color:var(--text-muted);"><?php echo e($item->email); ?></div>
                        </td>
                        <td style="max-width:180px;">
                            <div style="font-size:12px;color:var(--text-muted);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                <?php echo e($item->gmaps_location); ?>

                            </div>
                        </td>
                        <td>
                            <div style="font-size:12px;color:var(--text-muted);">
                                <?php echo e($item->reviewed_at?->diffForHumans() ?? '-'); ?>

                            </div>
                        </td>
                        <td><span class="badge badge-approved"><span class="badge-dot"></span>Aktif</span></td>
                        <td>
                            <div class="action-group">
                                <button class="btn btn-ghost btn-sm" onclick="openDetailModal(<?php echo e($item->id); ?>)">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Detail
                                </button>
                                <form method="POST" action="<?php echo e(route('admin.approval.mentor.destroy', $item)); ?>" style="display:inline;"
                                      onsubmit="return confirm('Hapus data mentor ini?')">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-ghost btn-sm" style="color:var(--accent2);">
                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>


<div id="tab-rejected" style="display:none;">
    <div class="table-card">
        <div class="table-card-header">
            <div class="table-card-title">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Pendaftaran Ditolak
                <span class="table-card-subtitle"><?php echo e($stats['rejected']); ?> ditolak</span>
            </div>
        </div>

        <?php if($rejected->isEmpty()): ?>
            <div class="empty-state">
                <div class="empty-state-icon">📭</div>
                <div class="empty-state-text">Tidak ada pendaftaran yang ditolak.</div>
            </div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Pendaftar</th>
                        <th>Kontak</th>
                        <th>Alasan Penolakan</th>
                        <th>Ditolak</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $rejected; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <div class="submitter">
                                <div class="submitter-avatar" style="background:#9ca3af;">
                                    <?php echo e(strtoupper(substr($item->full_name, 0, 2))); ?>

                                </div>
                                <div>
                                    <div class="submitter-name"><?php echo e($item->full_name); ?></div>
                                    <div class="submitter-sub"><?php echo e($item->user->email ?? '-'); ?></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="font-size:13px;"><?php echo e($item->phone); ?></div>
                            <div style="font-size:11px;color:var(--text-muted);"><?php echo e($item->email); ?></div>
                        </td>
                        <td style="max-width:200px;">
                            <div style="font-size:12px;color:var(--accent2);">
                                <?php echo e(Str::limit($item->rejection_reason, 60)); ?>

                            </div>
                        </td>
                        <td>
                            <div style="font-size:12px;color:var(--text-muted);">
                                <?php echo e($item->reviewed_at?->diffForHumans() ?? '-'); ?>

                            </div>
                        </td>
                        <td>
                            <div class="action-group">
                                <button class="btn btn-ghost btn-sm" onclick="openDetailModal(<?php echo e($item->id); ?>)">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Detail
                                </button>
                                <form method="POST" action="<?php echo e(route('admin.approval.mentor.destroy', $item)); ?>" style="display:inline;"
                                      onsubmit="return confirm('Hapus data pendaftaran ini?')">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-ghost btn-sm" style="color:var(--accent2);">
                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>



<div class="modal-overlay" id="modal-detail">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">Detail Pendaftaran Mentor</div>
            <button class="modal-close" onclick="closeModal('modal-detail')">✕</button>
        </div>

        <div class="img-preview" id="detail-foto">
            <span>🧑</span>
        </div>

        <div class="detail-grid">
            <div class="detail-item">
                <div class="detail-label">Nama Lengkap</div>
                <div class="detail-value" id="d-nama">-</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Status</div>
                <div class="detail-value" id="d-status">-</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">No. WhatsApp</div>
                <div class="detail-value" id="d-phone">-</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Email</div>
                <div class="detail-value" id="d-email">-</div>
            </div>
            <div class="detail-item full">
                <div class="detail-label">Lokasi</div>
                <div class="detail-value" id="d-lokasi">-</div>
            </div>
            <div class="detail-item full">
                <div class="detail-label">Bio / Tentang Diri</div>
                <div class="detail-value" id="d-bio" style="font-weight:400;line-height:1.6;font-size:13px;">-</div>
            </div>
            <div class="detail-item full" id="d-reject-wrap" style="display:none;">
                <div class="detail-label" style="color:var(--accent2);">Alasan Penolakan</div>
                <div class="detail-value" id="d-reject" style="font-weight:400;font-size:13px;color:var(--accent2);">-</div>
            </div>
        </div>

        <div style="display:flex;gap:10px;margin-top:4px;">
            <a id="d-ktp-link" href="#" target="_blank" class="btn btn-ghost btn-sm" style="flex:1;justify-content:center;">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="14" height="14">
                    <path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
                Lihat Scan KTP
            </a>
            <a id="d-foto-link" href="#" target="_blank" class="btn btn-ghost btn-sm" style="flex:1;justify-content:center;">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="14" height="14">
                    <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Lihat Pas Foto
            </a>
        </div>
        <div style="display:flex;gap:10px;margin-top:8px;">
            <a id="d-transfer-link" href="#" target="_blank" class="btn btn-ghost btn-sm" style="flex:1;justify-content:center;">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="14" height="14">
                    <path d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
                Lihat Bukti Transfer
            </a>
        </div>
    </div>
</div>


<div class="modal-overlay" id="modal-reject">
    <div class="modal" style="width:460px;">
        <div class="modal-header">
            <div class="modal-title">Tolak Pendaftaran</div>
            <button class="modal-close" onclick="closeModal('modal-reject')">✕</button>
        </div>
        <p style="font-size:13.5px;color:var(--text-muted);margin-bottom:18px;line-height:1.6;">
            Berikan alasan penolakan untuk <strong id="reject-name"></strong>. Alasan ini akan tersimpan sebagai catatan.
        </p>
        <form id="reject-form" method="POST">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label class="form-label">Alasan Penolakan *</label>
                <textarea name="rejection_reason" class="form-textarea" rows="4"
                    placeholder="Contoh: Dokumen KTP tidak jelas, mohon upload ulang dengan kualitas yang lebih baik."
                    required></textarea>
            </div>
            <div style="display:flex;gap:10px;margin-top:6px;">
                <button type="button" class="btn btn-ghost" style="flex:1;" onclick="closeModal('modal-reject')">Batal</button>
                <button type="submit" class="btn btn-reject" style="flex:1;">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Konfirmasi Tolak
                </button>
            </div>
        </form>
    </div>
</div>


<script>
const mentorData = <?php echo json_encode($pending->merge($approved)->merge($rejected)->keyBy('id'), 15, 512) ?>;

// Pertahankan tab aktif setelah page reload
function switchTab(tab, btn) {
    ['pending','approved','rejected'].forEach(t => {
        document.getElementById('tab-' + t).style.display = t === tab ? 'block' : 'none';
    });
    btn.closest('.tab-bar').querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    // Simpan ke URL agar persist setelah reload
    const url = new URL(window.location);
    url.searchParams.set('tab', tab);
    window.history.replaceState({}, '', url);
}

// Auto-buka tab dari URL ?tab= (atau dari flash session)
document.addEventListener('DOMContentLoaded', function () {
    const params = new URLSearchParams(window.location.search);
    const activeTab = params.get('tab') || 'pending';
    const tabBtn = document.querySelector(`.tab-btn[data-tab="${activeTab}"]`);
    if (tabBtn) {
        switchTab(activeTab, tabBtn);
    }
});

function openDetailModal(id) {
    const d = mentorData[id];
    if (!d) return;

    document.getElementById('d-nama').textContent    = d.full_name;
    document.getElementById('d-phone').textContent   = d.phone;
    document.getElementById('d-email').textContent   = d.email;
    document.getElementById('d-lokasi').textContent  = d.gmaps_location;
    document.getElementById('d-bio').textContent     = d.bio;

    const statusMap = {
        pending:  '<span class="badge badge-pending"><span class="badge-dot"></span>Menunggu</span>',
        approved: '<span class="badge badge-approved"><span class="badge-dot"></span>Disetujui</span>',
        rejected: '<span class="badge badge-rejected"><span class="badge-dot"></span>Ditolak</span>',
    };
    document.getElementById('d-status').innerHTML = statusMap[d.status] ?? d.status;

    const rejectWrap = document.getElementById('d-reject-wrap');
    if (d.status === 'rejected' && d.rejection_reason) {
        rejectWrap.style.display = 'block';
        document.getElementById('d-reject').textContent = d.rejection_reason;
    } else {
        rejectWrap.style.display = 'none';
    }

    const fotoEl = document.getElementById('detail-foto');
    if (d.white_bg_photo) {
        fotoEl.innerHTML = `<img src="/storage/${d.white_bg_photo}" alt="Pas Foto">`;
    } else {
        fotoEl.innerHTML = '<span>🧑</span>';
    }

    document.getElementById('d-ktp-link').href      = d.ktp_scan       ? `/storage/${d.ktp_scan}`       : '#';
    document.getElementById('d-foto-link').href     = d.white_bg_photo ? `/storage/${d.white_bg_photo}` : '#';
    const transferLink = document.getElementById('d-transfer-link');
    if (d.bukti_transfer) {
        transferLink.href = `/storage/${d.bukti_transfer}`;
        transferLink.style.opacity = '1';
        transferLink.style.pointerEvents = 'auto';
    } else {
        transferLink.href = '#';
        transferLink.style.opacity = '0.4';
        transferLink.style.pointerEvents = 'none';
    }

    openModal('modal-detail');
}

function openRejectModal(id, name) {
    document.getElementById('reject-name').textContent = name;
    document.getElementById('reject-form').action = `/admin/approval/mentor/${id}/reject?tab=rejected`;
    openModal('modal-reject');
}
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Kaji-indo-main\resources\views/admin/approval-mentor.blade.php ENDPATH**/ ?>