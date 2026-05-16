@extends('layouts.admin')

@section('page-title', 'Approval Event')

@push('styles')
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
</style>
@endpush

@section('content')

{{-- ── Tab status ── --}}
<div class="tab-bar">
    <button class="tab-btn {{ $status === 'pending'  ? 'active' : '' }}"
        onclick="location.href='{{ route('admin.approval.event') }}?status=pending'">
        Pending
        @php $cntPending = \App\Models\Event::where('status','pending')->count() @endphp
        @if($cntPending > 0)
            <span class="count-pill">{{ $cntPending }}</span>
        @endif
    </button>
    <button class="tab-btn {{ $status === 'approved' ? 'active' : '' }}"
        onclick="location.href='{{ route('admin.approval.event') }}?status=approved'">
        Disetujui
        @php $cntApproved = \App\Models\Event::where('status','approved')->count() @endphp
        @if($cntApproved > 0)
            <span class="count-pill" style="background:var(--accent);">{{ $cntApproved }}</span>
        @endif
    </button>
    <button class="tab-btn {{ $status === 'rejected' ? 'active' : '' }}"
        onclick="location.href='{{ route('admin.approval.event') }}?status=rejected'">
        Ditolak
        @php $cntRejected = \App\Models\Event::where('status','rejected')->count() @endphp
        @if($cntRejected > 0)
            <span class="count-pill" style="background:#9ca3af;">{{ $cntRejected }}</span>
        @endif
    </button>
</div>

<div class="table-card">
    <div class="table-card-header">
        <div class="table-card-title">
            📅 Daftar Event
            <span class="table-card-subtitle">{{ $events->count() }} event</span>
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
            @forelse($events as $event)
            @php $st = $event->status ?? 'pending'; @endphp
            <tr>
                {{-- Event --}}
                <td>
                    <div class="preview-cell">
                        <div class="preview-thumb">
                            @if($event->gambar)
                                <img src="{{ asset('storage/' . $event->gambar) }}"
                                     alt="{{ $event->judul }}"
                                     style="width:100%;height:100%;object-fit:cover;border-radius:8px;">
                            @else
                                🎪
                            @endif
                        </div>
                        <div>
                            <div class="preview-name">{{ $event->judul }}</div>
                            {{-- Biaya badge --}}
                            @if(empty($event->biaya) || $event->biaya == '0' || strtolower($event->biaya) === 'gratis')
                                <span class="badge badge-gratis"
                                      style="display:inline-flex;align-items:center;gap:3px;padding:2px 8px;border-radius:20px;font-size:10px;font-weight:600;margin-top:3px;">
                                    ✅ Gratis
                                </span>
                            @else
                                <span class="badge badge-berbayar"
                                      style="display:inline-flex;align-items:center;gap:3px;padding:2px 8px;border-radius:20px;font-size:10px;font-weight:600;margin-top:3px;">
                                    💰 {{ $event->biaya }}
                                </span>
                            @endif
                        </div>
                    </div>
                </td>

                {{-- Trainer --}}
                <td>
                    @if($event->trainer)
                    <div class="submitter">
                        <div class="submitter-avatar" style="background:var(--accent);">
                            {{ strtoupper(substr($event->trainer->name ?? 'T', 0, 2)) }}
                        </div>
                        <div>
                            <div class="submitter-name">{{ $event->trainer->name }}</div>
                            <div class="submitter-sub">Trainer</div>
                        </div>
                    </div>
                    @else
                        <span style="color:var(--text-muted);font-size:12px;">-</span>
                    @endif
                </td>

                {{-- Lokasi --}}
                <td style="font-size:13px;color:var(--text-muted);">
                    {{ $event->lokasi ?? '-' }}
                </td>

                {{-- Tanggal + Waktu --}}
                <td style="font-size:13px;">
                    <div style="font-weight:600;color:var(--text);">
                        {{ \Carbon\Carbon::parse($event->tanggal)->translatedFormat('d M Y') }}
                    </div>
                    @if($event->waktu_mulai && $event->waktu_selesai)
                        <div style="font-size:11px;color:var(--text-muted);margin-top:2px;">
                            {{ $event->jam }}
                        </div>
                    @endif
                </td>

                {{-- Kapasitas --}}
                <td style="font-size:13px;color:var(--text-muted);">
                    {{ $event->kapasitas ? $event->kapasitas . ' orang' : '-' }}
                </td>

                {{-- Status --}}
                <td>
                    @if($st === 'approved')
                        <span class="badge badge-approved"><span class="badge-dot"></span>Disetujui</span>
                    @elseif($st === 'rejected')
                        <span class="badge badge-rejected"><span class="badge-dot"></span>Ditolak</span>
                        @if($event->catatan_admin)
                            <div style="font-size:10px;color:#ef4444;margin-top:3px;max-width:140px;line-height:1.4;">
                                {{ Str::limit($event->catatan_admin, 40) }}
                            </div>
                        @endif
                    @else
                        <span class="badge badge-pending"><span class="badge-dot"></span>Pending</span>
                    @endif
                </td>

                {{-- Aksi --}}
                <td>
                    <div class="action-group">

                        {{-- Tombol Detail --}}
                        <button class="btn btn-ghost btn-sm btn-icon" title="Detail"
                                onclick="openDetailModal({{ $event->id }})">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>

                        {{-- Tombol Setujui --}}
                        @if($st !== 'approved')
                        <form method="POST"
                              action="{{ route('admin.approval.event.approve', $event->id) }}"
                              id="form-approve-{{ $event->id }}"
                              style="display:inline;">
                            @csrf
                            <button type="button" class="btn btn-approve btn-sm"
                                    onclick="confirmApprove({{ $event->id }}, '{{ addslashes($event->judul) }}')">
                                ✓ Setujui
                            </button>
                        </form>
                        @endif

                        {{-- Tombol Tolak --}}
                        @if($st !== 'rejected')
                        <button class="btn btn-reject btn-sm"
                                onclick="confirmReject({{ $event->id }}, '{{ addslashes($event->judul) }}')">
                            ✕ Tolak
                        </button>
                        @endif

                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7">
                    <div class="empty-state">
                        <div class="empty-state-icon">🎉</div>
                        <div class="empty-state-text">Tidak ada event dengan status ini</div>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>


{{-- ======================== MODAL DETAIL ======================== --}}
<div class="modal-overlay" id="modal-detail">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">Detail Event</div>
            <button class="modal-close" onclick="closeModal('modal-detail')">✕</button>
        </div>

        {{-- Gambar banner --}}
        <div class="img-preview" id="detail-img">🎪</div>

        {{-- Grid info --}}
        <div class="detail-grid" id="detail-grid"></div>

        {{-- Catatan admin jika ditolak --}}
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


{{-- ======================== MODAL TOLAK ======================== --}}
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
            @csrf
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

@endsection

@push('scripts')
<script>
// Data event dari server untuk modal detail
const eventData = @json($events->values());

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
@endpush