{{-- resources/views/admin/approval/mentor.blade.php --}}
@extends('layouts.admin')

@section('page-title', 'Approval Mentor')

@push('styles')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.8/sweetalert2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.8/sweetalert2.all.min.js"></script> 
<style>
    .btn-csv-export {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 7px 16px; border-radius: 8px; font-size: 12px; font-weight: 600;
    background: #f0fdf4; color: #15803d; border: 1.5px solid #86efac;
    text-decoration: none; cursor: pointer; transition: all .15s; white-space: nowrap;
}
.btn-csv-export:hover { background: #dcfce7; border-color: #4ade80; color: #166534; }
@media (max-width: 768px) { .btn-csv-export { font-size: 11px; padding: 5px 10px; } }
    .swal-btn-confirm-delete {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 10px 22px; border-radius: 8px; font-size: 14px; font-weight: 600;
        background: #ef4444; color: #fff; border: none; cursor: pointer; transition: background 0.15s;
    }
    .swal-btn-confirm-delete:hover { background: #dc2626; }
    .swal-btn-cancel {
        display: inline-flex; align-items: center;
        padding: 10px 22px; border-radius: 8px; font-size: 14px; font-weight: 500;
        background: #f3f4f6; color: #374151; border: 1px solid #e5e7eb; cursor: pointer;
    }
    .swal-btn-cancel:hover { background: #e5e7eb; }
    .swal2-popup  { border-radius: 16px !important; padding: 32px 28px !important; }
    .swal2-title  { font-size: 18px !important; font-weight: 700 !important; color: #111827 !important; }
    .swal2-actions{ gap: 10px !important; margin-top: 24px !important; }

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
@endpush

@section('content')

{{-- Tab Bar --}}
<div class="tab-bar">
    <button class="tab-btn active" data-tab="pending" onclick="switchTab('pending', this)">
        Menunggu
        @if($stats['pending'] > 0)
            <span class="count-pill">{{ $stats['pending'] }}</span>
        @endif
    </button>
    <button class="tab-btn" data-tab="approved" onclick="switchTab('approved', this)">
        Disetujui
        @if($stats['approved'] > 0)
            <span class="count-pill" style="background:var(--accent);">{{ $stats['approved'] }}</span>
        @endif
    </button>
    <button class="tab-btn" data-tab="rejected" onclick="switchTab('rejected', this)">
        Ditolak
        @if($stats['rejected'] > 0)
            <span class="count-pill" style="background:#9ca3af;">{{ $stats['rejected'] }}</span>
        @endif
    </button>
</div>

{{-- ======================== TAB PENDING ======================== --}}
<div id="tab-pending">
    <div class="table-card">
        <div class="table-card-header">
            <div class="table-card-title">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Pendaftaran Menunggu Review
                <span class="table-card-subtitle">{{ $stats['pending'] }} pendaftar</span>
                </div>
                <a href="{{ route('admin.approval.mentor') }}?export=csv&status=pending" class="btn-csv-export">
               
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Export CSV
            </a>
        </div>

        @if($pending->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">🎉</div>
                <div class="empty-state-text">Tidak ada pendaftaran yang menunggu review.</div>
            </div>
        @else
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
                    @foreach($pending as $item)
                    <tr>
                        <td>
                            <div class="submitter">
                                <div class="submitter-avatar" style="background:var(--accent);">
                                    {{ strtoupper(substr($item->full_name, 0, 2)) }}
                                </div>
                                <div>
                                    <div class="submitter-name">{{ $item->full_name }}</div>
                                    <div class="submitter-sub">{{ $item->user->email ?? '-' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="font-size:13px;">{{ $item->phone }}</div>
                            <div style="font-size:11px;color:var(--text-muted);">{{ $item->email }}</div>
                        </td>
                        <td style="max-width:180px;">
                            <div style="font-size:12px;color:var(--text-muted);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                {{ $item->gmaps_location }}
                            </div>
                        </td>
                        <td>
                            <div style="font-size:12px;color:var(--text-muted);">
                                {{ $item->created_at->diffForHumans() }}
                            </div>
                        </td>
                        <td>
                            <div class="action-group">
                                <button class="btn btn-ghost btn-sm" onclick="openDetailModal({{ $item->id }})">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Detail
                                </button>
                                <form method="POST" action="{{ route('admin.approval.mentor.approve', $item) }}?tab=approved" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-approve btn-sm">
                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Setujui
                                    </button>
                                </form>
                                <button class="btn btn-reject btn-sm" onclick="openRejectModal({{ $item->id }}, '{{ addslashes($item->full_name) }}')">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Tolak
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>

{{-- ======================== TAB APPROVED ======================== --}}
<div id="tab-approved" style="display:none;">
    <div class="table-card">
        <div class="table-card-header">
            <div class="table-card-title">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Mentor Disetujui
                <span class="table-card-subtitle">{{ $stats['approved'] }} mentor aktif</span>
                </div>
                <a href="{{ route('admin.approval.mentor') }}?export=csv&status=approved" class="btn-csv-export">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Export CSV
            </a>
        </div>

        @if($approved->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">📭</div>
                <div class="empty-state-text">Belum ada pendaftaran yang disetujui.</div>
            </div>
        @else
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
                    @foreach($approved as $item)
                    <tr>
                        <td>
                            <div class="submitter">
                                <div class="submitter-avatar" style="background:var(--accent);">
                                    {{ strtoupper(substr($item->full_name, 0, 2)) }}
                                </div>
                                <div>
                                    <div class="submitter-name">{{ $item->full_name }}</div>
                                    <div class="submitter-sub">{{ $item->user->email ?? '-' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="font-size:13px;">{{ $item->phone }}</div>
                            <div style="font-size:11px;color:var(--text-muted);">{{ $item->email }}</div>
                        </td>
                        <td style="max-width:180px;">
                            <div style="font-size:12px;color:var(--text-muted);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                {{ $item->gmaps_location }}
                            </div>
                        </td>
                        <td>
                            <div style="font-size:12px;color:var(--text-muted);">
                                {{ $item->reviewed_at?->diffForHumans() ?? '-' }}
                            </div>
                        </td>
                        <td><span class="badge badge-approved"><span class="badge-dot"></span>Aktif</span></td>
                        <td>
                            <div class="action-group">
                                <button class="btn btn-ghost btn-sm" onclick="openDetailModal({{ $item->id }})">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Detail
                                </button>
                                <form method="POST" action="{{ route('admin.approval.mentor.destroy', $item) }}" style="display:none;"
      id="form-destroy-mentor-{{ $item->id }}">
    @csrf @method('DELETE')
</form>
<button type="button" class="btn btn-ghost btn-sm" style="color:var(--accent2);"
        onclick="confirmDestroyMentor({{ $item->id }}, '{{ addslashes($item->full_name) }}', 'approved')">
    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
    </svg>
    Hapus
</button>
                                
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>

{{-- ======================== TAB REJECTED ======================== --}}
<div id="tab-rejected" style="display:none;">
    <div class="table-card">
        <div class="table-card-header">
            <div class="table-card-title">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Pendaftaran Ditolak
                <span class="table-card-subtitle">{{ $stats['rejected'] }} ditolak</span>
                </div>
                <a href="{{ route('admin.approval.mentor') }}?export=csv&status=rejected" class="btn-csv-export">
               
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Export CSV
            </a>
        </div>

        @if($rejected->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">📭</div>
                <div class="empty-state-text">Tidak ada pendaftaran yang ditolak.</div>
            </div>
        @else
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
                    @foreach($rejected as $item)
                    <tr>
                        <td>
                            <div class="submitter">
                                <div class="submitter-avatar" style="background:#9ca3af;">
                                    {{ strtoupper(substr($item->full_name, 0, 2)) }}
                                </div>
                                <div>
                                    <div class="submitter-name">{{ $item->full_name }}</div>
                                    <div class="submitter-sub">{{ $item->user->email ?? '-' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="font-size:13px;">{{ $item->phone }}</div>
                            <div style="font-size:11px;color:var(--text-muted);">{{ $item->email }}</div>
                        </td>
                        <td style="max-width:200px;">
                            <div style="font-size:12px;color:var(--accent2);">
                                {{ Str::limit($item->rejection_reason, 60) }}
                            </div>
                        </td>
                        <td>
                            <div style="font-size:12px;color:var(--text-muted);">
                                {{ $item->reviewed_at?->diffForHumans() ?? '-' }}
                            </div>
                        </td>
                        <td>
                            <div class="action-group">
                                <button class="btn btn-ghost btn-sm" onclick="openDetailModal({{ $item->id }})">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Detail
                                </button>
                                <form method="POST" action="{{ route('admin.approval.mentor.destroy', $item) }}" style="display:none;"
      id="form-destroy-mentor-{{ $item->id }}">
    @csrf @method('DELETE')
</form>
<button type="button" class="btn btn-ghost btn-sm" style="color:var(--accent2);"
        onclick="confirmDestroyMentor({{ $item->id }}, '{{ addslashes($item->full_name) }}', 'rejected')">
    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
    </svg>
    Hapus
</button>
                                
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>


{{-- ======================== MODAL DETAIL ======================== --}}
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

{{-- ======================== MODAL TOLAK ======================== --}}
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
            @csrf
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

{{-- Data JSON untuk JS --}}
<script>

const mentorData = @json($pending->merge($approved)->merge($rejected)->keyBy('id'));

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

function openModal(id)  { document.getElementById(id).classList.add('open'); }
function closeModal(id) { document.getElementById(id).classList.remove('open'); }

document.querySelectorAll('.modal-overlay').forEach(function(el) {
    el.addEventListener('click', function(e) {
        if (e.target === el) closeModal(el.id);
    });
});
function openRejectModal(id, name) {
    document.getElementById('reject-name').textContent = name;
    document.getElementById('reject-form').action = `/admin/approval/mentor/${id}/reject?tab=rejected`;
    openModal('modal-reject');
}

const swalDelete = Swal.mixin({
    customClass: { confirmButton: 'swal-btn-confirm-delete', cancelButton: 'swal-btn-cancel' },
    buttonsStyling: false,
});

function confirmDestroyMentor(id, name, type) {
    const isApproved = type === 'approved';
    swalDelete.fire({
        title: isApproved ? 'Hapus Data Mentor?' : 'Hapus Pendaftaran?',
        html: isApproved
            ? `<span style="font-size:14px;color:#6b7280;line-height:1.6;">
                Data mentor <strong>${name}</strong> akan dihapus.<br>
                <span style="color:#ef4444;font-size:13px;margin-top:6px;display:block;">
                    ⚠️ Status mentor akan direset dan akses mentor dicabut.
                </span>
               </span>`
            : `<span style="font-size:14px;color:#6b7280;line-height:1.6;">
                Data pendaftaran <strong>${name}</strong> akan dihapus permanen.<br>
                <span style="color:#ef4444;font-size:13px;margin-top:6px;display:block;">
                    ⚠️ Tindakan ini tidak dapat dibatalkan.
                </span>
               </span>`,
        icon: 'warning', iconColor: '#ef4444',
        showCancelButton: true,
        confirmButtonText: '🗑️ Ya, Hapus',
        cancelButtonText: 'Batal',
        reverseButtons: true, focusCancel: true,
    }).then(function(result) {
        if (result.isConfirmed) document.getElementById('form-destroy-mentor-' + id).submit();
    });
}
</script>

@endsection