<?php $__env->startSection('page-title', 'Approval Event'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.8/sweetalert2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.8/sweetalert2.all.min.js"></script>
<style>
    .swal-btn-confirm-approve {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 10px 22px; border-radius: 8px; font-size: 14px; font-weight: 600;
        background: #10b981; color: #fff; border: none; cursor: pointer; transition: background 0.15s;
    }
    .swal-btn-confirm-approve:hover { background: #059669; }
    .swal-btn-confirm-reject {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 10px 22px; border-radius: 8px; font-size: 14px; font-weight: 600;
        background: #ef4444; color: #fff; border: none; cursor: pointer; transition: background 0.15s;
    }
    .swal-btn-confirm-reject:hover { background: #dc2626; }
    .swal-btn-cancel {
        display: inline-flex; align-items: center;
        padding: 10px 22px; border-radius: 8px; font-size: 14px; font-weight: 500;
        background: #f3f4f6; color: #374151; border: 1px solid #e5e7eb; cursor: pointer;
    }
    .swal-btn-cancel:hover { background: #e5e7eb; }
    .swal2-popup  { border-radius: 16px !important; padding: 32px 28px !important; }
    .swal2-title  { font-size: 18px !important; font-weight: 700 !important; color: #111827 !important; }
    .swal2-actions{ gap: 10px !important; margin-top: 24px !important; }

    /* ── Biaya badge ── */
    .badge-gratis  { background:#dcfce7; color:#15803d; border:1px solid #86efac; }
    .badge-berbayar{ background:#fef3c7; color:#92400e; border:1px solid #fde68a; }

    /* ===================== RESPONSIVE MOBILE - APPROVAL EVENT ===================== */

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

        /* Sembunyikan: Pembimbing(2), Lokasi(3), Tanggal(4), Kapasitas(5), Status(6) */
        .table-card table thead tr th:nth-child(2),
        .table-card table tbody tr td:nth-child(2),
        .table-card table thead tr th:nth-child(3),
        .table-card table tbody tr td:nth-child(3),
        .table-card table thead tr th:nth-child(4),
        .table-card table tbody tr td:nth-child(4),
        .table-card table thead tr th:nth-child(5),
        .table-card table tbody tr td:nth-child(5),
        .table-card table thead tr th:nth-child(6),
        .table-card table tbody tr td:nth-child(6) {
            display: none !important;
        }

        /* Lebar kolom Event(1) dan Aksi(7) */
        .table-card table thead tr th:nth-child(1),
        .table-card table tbody tr td:nth-child(1) {
            width: 60% !important;
        }
        .table-card table thead tr th:nth-child(7),
        .table-card table tbody tr td:nth-child(7) {
            width: 40% !important;
        }

        /* Padding baris */
        thead th {
            padding: 10px 10px !important;
            font-size: 9px !important;
        }
        tbody td {
            padding: 10px 10px !important;
        }

        /* Preview cell (kolom Event) */
        .preview-cell { gap: 6px !important; }

        .preview-thumb {
            width: 36px !important;
            height: 36px !important;
            font-size: 16px !important;
            flex-shrink: 0 !important;
        }

        .preview-name {
            font-size: 11px !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            white-space: nowrap !important;
            max-width: 110px !important;
        }

        /* Sembunyikan badge biaya di tabel, tetap tampil di modal */
        .preview-cell .badge-gratis,
        .preview-cell .badge-berbayar {
            display: none !important;
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

        /* Tombol Detail tetap tampil */
        .action-group .btn-ghost.btn-sm {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        .action-group .btn-ghost.btn-sm svg {
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
            max-height: 90vh !important;
        }

        #modal-reject .modal {
            width: 100% !important;
        }

        /* Gambar preview di modal */
        .img-preview {
            height: 130px !important;
            margin-bottom: 14px !important;
        }

        /* Detail grid: 1 kolom */
        .detail-grid {
            grid-template-columns: 1fr !important;
            gap: 8px !important;
        }

        /* Tombol footer modal */
        #modal-detail .modal > div:last-child {
            flex-direction: column-reverse !important;
            gap: 8px !important;
        }

        #modal-detail .modal > div:last-child .btn {
            width: 100% !important;
            justify-content: center !important;
        }

        /* Form reject */
        .form-textarea {
            font-size: 14px !important;
        }

        /* SweetAlert2 */
        .swal2-popup {
            width: 92% !important;
            padding: 24px 18px !important;
        }
    }

</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>


<div class="tab-bar">
    <button class="tab-btn <?php echo e($status === 'pending'  ? 'active' : ''); ?>"
        onclick="location.href='<?php echo e(route('admin.approval.event')); ?>?status=pending'">
        Pending
        <?php $cntPending = \App\Models\Event::where('status','pending')->count() ?>
        <?php if($cntPending > 0): ?>
            <span class="count-pill"><?php echo e($cntPending); ?></span>
        <?php endif; ?>
    </button>
    <button class="tab-btn <?php echo e($status === 'approved' ? 'active' : ''); ?>"
        onclick="location.href='<?php echo e(route('admin.approval.event')); ?>?status=approved'">
        Disetujui
        <?php $cntApproved = \App\Models\Event::where('status','approved')->count() ?>
        <?php if($cntApproved > 0): ?>
            <span class="count-pill" style="background:var(--accent);"><?php echo e($cntApproved); ?></span>
        <?php endif; ?>
    </button>
    <button class="tab-btn <?php echo e($status === 'rejected' ? 'active' : ''); ?>"
        onclick="location.href='<?php echo e(route('admin.approval.event')); ?>?status=rejected'">
        Ditolak
        <?php $cntRejected = \App\Models\Event::where('status','rejected')->count() ?>
        <?php if($cntRejected > 0): ?>
            <span class="count-pill" style="background:#9ca3af;"><?php echo e($cntRejected); ?></span>
        <?php endif; ?>
    </button>
</div>

<div class="table-card">
    <div class="table-card-header">
        <div class="table-card-title">
            📅 Daftar Event
            <span class="table-card-subtitle"><?php echo e($events->count()); ?> event</span>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Event</th>
                <th>Pembimbing</th>
                <th>Lokasi</th>
                <th>Tanggal</th>
                <th>Kapasitas</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php $st = $event->status ?? 'pending'; ?>
            <tr>
                
                <td>
                    <div class="preview-cell">
                        <div class="preview-thumb">
                            <?php if($event->gambar): ?>
                                <img src="<?php echo e(asset('storage/' . $event->gambar)); ?>"
                                     alt="<?php echo e($event->judul); ?>"
                                     style="width:100%;height:100%;object-fit:cover;border-radius:8px;">
                            <?php else: ?>
                                🎪
                            <?php endif; ?>
                        </div>
                        <div>
                            <div class="preview-name"><?php echo e($event->judul); ?></div>
                            
                            <?php if(empty($event->biaya) || $event->biaya == '0' || strtolower($event->biaya) === 'gratis'): ?>
                                <span class="badge badge-gratis"
                                      style="display:inline-flex;align-items:center;gap:3px;padding:2px 8px;border-radius:20px;font-size:10px;font-weight:600;margin-top:3px;">
                                    ✅ Gratis
                                </span>
                            <?php else: ?>
                                <span class="badge badge-berbayar"
                                      style="display:inline-flex;align-items:center;gap:3px;padding:2px 8px;border-radius:20px;font-size:10px;font-weight:600;margin-top:3px;">
                                    💰 <?php echo e($event->biaya); ?>

                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </td>

                
                <td>
                    <?php if($event->trainer): ?>
                    <div class="submitter">
                        <div class="submitter-avatar" style="background:var(--accent);">
                            <?php echo e(strtoupper(substr($event->trainer->name ?? 'T', 0, 2))); ?>

                        </div>
                        <div>
                            <div class="submitter-name"><?php echo e($event->trainer->name); ?></div>
                            <div class="submitter-sub">Trainer</div>
                        </div>
                    </div>
                    <?php else: ?>
                        <span style="color:var(--text-muted);font-size:12px;">-</span>
                    <?php endif; ?>
                </td>

                
                <td style="font-size:13px;color:var(--text-muted);">
                    <?php echo e($event->lokasi ?? '-'); ?>

                </td>

                
                <td style="font-size:13px;">
                    <div style="font-weight:600;color:var(--text);">
                        <?php echo e(\Carbon\Carbon::parse($event->tanggal)->translatedFormat('d M Y')); ?>

                    </div>
                    <?php if($event->waktu_mulai && $event->waktu_selesai): ?>
                        <div style="font-size:11px;color:var(--text-muted);margin-top:2px;">
                            <?php echo e($event->jam); ?>

                        </div>
                    <?php endif; ?>
                </td>

                
                <td style="font-size:13px;color:var(--text-muted);">
                    <?php echo e($event->kapasitas ? $event->kapasitas . ' orang' : '-'); ?>

                </td>

                
                <td>
                    <?php if($st === 'approved'): ?>
                        <span class="badge badge-approved"><span class="badge-dot"></span>Disetujui</span>
                    <?php elseif($st === 'rejected'): ?>
                        <span class="badge badge-rejected"><span class="badge-dot"></span>Ditolak</span>
                        <?php if($event->catatan_admin): ?>
                            <div style="font-size:10px;color:#ef4444;margin-top:3px;max-width:140px;line-height:1.4;">
                                <?php echo e(Str::limit($event->catatan_admin, 40)); ?>

                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <span class="badge badge-pending"><span class="badge-dot"></span>Pending</span>
                    <?php endif; ?>
                </td>

                
                <td>
                    <div class="action-group">

                        
                        <button class="btn btn-ghost btn-sm btn-icon" title="Detail"
                                onclick="openDetailModal(<?php echo e($event->id); ?>)">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>

                        
                        <?php if($st !== 'approved'): ?>
                        <form method="POST"
                              action="<?php echo e(route('admin.approval.event.approve', $event->id)); ?>"
                              id="form-approve-<?php echo e($event->id); ?>"
                              style="display:inline;">
                            <?php echo csrf_field(); ?>
                            <button type="button" class="btn btn-approve btn-sm"
                                    onclick="confirmApprove(<?php echo e($event->id); ?>, '<?php echo e(addslashes($event->judul)); ?>')">
                                ✓ Setujui
                            </button>
                        </form>
                        <?php endif; ?>

                        
                        <?php if($st !== 'rejected'): ?>
                        <button class="btn btn-reject btn-sm"
                                onclick="confirmReject(<?php echo e($event->id); ?>, '<?php echo e(addslashes($event->judul)); ?>')">
                            ✕ Tolak
                        </button>
                        <?php endif; ?>

                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="7">
                    <div class="empty-state">
                        <div class="empty-state-icon">🎉</div>
                        <div class="empty-state-text">Tidak ada event dengan status ini</div>
                    </div>
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>



<div class="modal-overlay" id="modal-detail">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">Detail Event</div>
            <button class="modal-close" onclick="closeModal('modal-detail')">✕</button>
        </div>

        
        <div class="img-preview" id="detail-img">🎪</div>

        
        <div class="detail-grid" id="detail-grid"></div>

        
        <div class="detail-item full" id="d-reject-wrap" style="display:none;margin-bottom:12px;">
            <div class="detail-label" style="color:#ef4444;font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px;">
                Alasan Penolakan
            </div>
            <div class="detail-value" id="d-reject"
                 style="font-weight:400;font-size:13px;color:#ef4444;"></div>
        </div>

        <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:4px;">
            <button class="btn btn-ghost btn-sm" onclick="closeModal('modal-detail')">Tutup</button>
            <button class="btn btn-reject btn-sm"  id="btn-detail-reject"  style="display:none;">✕ Tolak</button>
            <button class="btn btn-approve btn-sm" id="btn-detail-approve" style="display:none;">✓ Setujui</button>
        </div>
    </div>
</div>



<div class="modal-overlay" id="modal-reject">
    <div class="modal" style="max-width:460px;">
        <div class="modal-header">
            <div class="modal-title">Tolak Event</div>
            <button class="modal-close" onclick="closeModal('modal-reject')">✕</button>
        </div>
        <p style="font-size:13.5px;color:var(--text-muted);margin-bottom:18px;line-height:1.6;">
            Berikan alasan penolakan untuk <strong id="reject-name"></strong>.
            Alasan ini akan tersimpan sebagai catatan untuk trainer.
        </p>
        <form id="form-reject" method="POST">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label class="form-label">Catatan / Alasan Penolakan *</label>
                <textarea name="catatan_admin" class="form-textarea" rows="4"
                          placeholder="Jelaskan alasan penolakan event ini..."
                          required></textarea>
            </div>
            <div style="display:flex;gap:10px;margin-top:6px;">
                <button type="button" class="btn btn-ghost" style="flex:1;"
                        onclick="closeModal('modal-reject')">Batal</button>
                <button type="submit" class="btn btn-reject" style="flex:1;">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" width="14" height="14">
                        <path d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Konfirmasi Tolak
                </button>
            </div>
        </form>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Data event dari server untuk modal detail
const eventData = <?php echo json_encode($events->values(), 15, 512) ?>;

// ── SweetAlert2 config ────────────────────────────────────────────────────────
const swalApprove = Swal.mixin({
    customClass: { confirmButton: 'swal-btn-confirm-approve', cancelButton: 'swal-btn-cancel' },
    buttonsStyling: false,
});
const swalReject = Swal.mixin({
    customClass: { confirmButton: 'swal-btn-confirm-reject', cancelButton: 'swal-btn-cancel' },
    buttonsStyling: false,
});

// ── Confirm Approve ───────────────────────────────────────────────────────────
function confirmApprove(id, name) {
    swalApprove.fire({
        title: 'Setujui Event?',
        html:  '<span style="font-size:14px;color:#6b7280;">Event <strong>' + name + '</strong> akan dipublikasikan ke website.</span>',
        icon:  'question', iconColor: '#10b981',
        showCancelButton: true,
        confirmButtonText: '✓ Ya, Setujui',
        cancelButtonText:  'Batal',
        reverseButtons: true, focusCancel: true,
    }).then(function(result) {
        if (result.isConfirmed) {
            document.getElementById('form-approve-' + id).submit();
        }
    });
}

// ── Confirm Reject ────────────────────────────────────────────────────────────
function confirmReject(id, name) {
    swalReject.fire({
        title: 'Tolak Event?',
        html:  '<span style="font-size:14px;color:#6b7280;">Kamu akan menolak event <strong>' + name + '</strong>.</span>',
        icon:  'warning', iconColor: '#ef4444',
        showCancelButton: true,
        confirmButtonText: '→ Lanjut Isi Alasan',
        cancelButtonText:  'Batal',
        reverseButtons: true, focusCancel: true,
    }).then(function(result) {
        if (result.isConfirmed) openRejectModal(id, name);
    });
}

// ── Modal Detail ──────────────────────────────────────────────────────────────
function openDetailModal(id) {
    const e = eventData.find(function(x) { return x.id === id; });
    if (!e) return;

    // Gambar
    const imgEl = document.getElementById('detail-img');
    if (e.gambar) {
        imgEl.innerHTML = '<img src="/storage/' + e.gambar + '" alt="' + e.judul + '" style="width:100%;height:100%;object-fit:cover;">';
    } else {
        imgEl.textContent = '🎪';
    }

    // Biaya label
    const biayaLabel = (!e.biaya || e.biaya === '0' || e.biaya.toLowerCase() === 'gratis')
        ? '✅ Gratis'
        : '💰 ' + e.biaya;

    // Waktu
    let jamStr = '-';
    if (e.waktu_mulai && e.waktu_selesai) {
        const fmt = function(t) { return t.substring(0,5).replace(':', '.'); };
        jamStr = fmt(e.waktu_mulai) + ' – ' + fmt(e.waktu_selesai) + ' WIB';
    }

    // Grid info
    document.getElementById('detail-grid').innerHTML =
        '<div class="detail-item">' +
            '<div class="detail-label">Nama Event</div>' +
            '<div class="detail-value">' + (e.judul ?? '-') + '</div>' +
        '</div>' +
        '<div class="detail-item">' +
            '<div class="detail-label">Tanggal</div>' +
            '<div class="detail-value">' + (e.tanggal ? e.tanggal.substring(0,10) : '-') + '</div>' +
        '</div>' +
        '<div class="detail-item">' +
            '<div class="detail-label">Waktu</div>' +
            '<div class="detail-value">' + jamStr + '</div>' +
        '</div>' +
        '<div class="detail-item">' +
            '<div class="detail-label">Lokasi</div>' +
            '<div class="detail-value">' + (e.lokasi ?? '-') + '</div>' +
        '</div>' +
        '<div class="detail-item">' +
            '<div class="detail-label">Kapasitas</div>' +
            '<div class="detail-value">' + (e.kapasitas ? e.kapasitas + ' orang' : '-') + '</div>' +
        '</div>' +
        '<div class="detail-item">' +
            '<div class="detail-label">Biaya</div>' +
            '<div class="detail-value">' + biayaLabel + '</div>' +
        '</div>' +
        '<div class="detail-item full">' +
            '<div class="detail-label">Deskripsi</div>' +
            '<div class="detail-value" style="font-weight:400;font-size:13px;line-height:1.7;color:var(--text-muted)">' +
                (e.deskripsi ?? '-') +
            '</div>' +
        '</div>';

    // Catatan penolakan
    const rejectWrap = document.getElementById('d-reject-wrap');
    if (e.status === 'rejected' && e.catatan_admin) {
        rejectWrap.style.display = 'block';
        document.getElementById('d-reject').textContent = e.catatan_admin;
    } else {
        rejectWrap.style.display = 'none';
    }

    // Tombol aksi dalam modal
    const btnApprove = document.getElementById('btn-detail-approve');
    const btnReject  = document.getElementById('btn-detail-reject');
    btnApprove.style.display = e.status !== 'approved' ? 'inline-flex' : 'none';
    btnReject.style.display  = e.status !== 'rejected' ? 'inline-flex' : 'none';
    btnApprove.onclick = function() { closeModal('modal-detail'); confirmApprove(id, e.judul); };
    btnReject.onclick  = function() { closeModal('modal-detail'); confirmReject(id, e.judul); };

    openModal('modal-detail');
}

// ── Modal Reject ──────────────────────────────────────────────────────────────
function openRejectModal(id, name) {
    document.getElementById('reject-name').textContent  = name;
    document.getElementById('form-reject').action       =
        '/admin/approval/event/' + id + '/reject';
    openModal('modal-reject');
}

// ── Helper modal ──────────────────────────────────────────────────────────────
function openModal(id)  { document.getElementById(id).classList.add('open'); }
function closeModal(id) { document.getElementById(id).classList.remove('open'); }

document.querySelectorAll('.modal-overlay').forEach(function(el) {
    el.addEventListener('click', function(e) {
        if (e.target === el) closeModal(el.id);
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\webkajiindonesia\resources\views/admin/approval-event.blade.php ENDPATH**/ ?>