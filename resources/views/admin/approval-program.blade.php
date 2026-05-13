@extends('layouts.admin')

@section('page-title', 'Approval Program')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.8/sweetalert2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.10.8/sweetalert2.all.min.js"></script>
<style>
    /* SweetAlert2 custom buttons */
    .swal-btn-confirm-approve {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 10px 22px; border-radius: 8px; font-size: 14px; font-weight: 600;
        background: #10b981; color: #fff; border: none; cursor: pointer;
        transition: background 0.15s;
    }
    .swal-btn-confirm-approve:hover { background: #059669; }
    .swal-btn-confirm-reject {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 10px 22px; border-radius: 8px; font-size: 14px; font-weight: 600;
        background: #ef4444; color: #fff; border: none; cursor: pointer;
        transition: background 0.15s;
    }
    .swal-btn-confirm-reject:hover { background: #dc2626; }
    .swal-btn-cancel {
        display: inline-flex; align-items: center;
        padding: 10px 22px; border-radius: 8px; font-size: 14px; font-weight: 500;
        background: #f3f4f6; color: #374151; border: 1px solid #e5e7eb; cursor: pointer;
        transition: background 0.15s;
    }
    .swal-btn-cancel:hover { background: #e5e7eb; }
    .swal2-popup { border-radius: 16px !important; padding: 32px 28px !important; }
    .swal2-title { font-size: 18px !important; font-weight: 700 !important; color: #111827 !important; }
    .swal2-actions { gap: 10px !important; margin-top: 24px !important; }
</style>
@endpush

@section('content')

<div class="tab-bar">
    <button class="tab-btn {{ $status === 'pending' ? 'active' : '' }}"
        onclick="location.href='{{ route('admin.approval.program') }}?status=pending'">
        Pending
        @if($counts['pending'] > 0)
            <span class="count-pill">{{ $counts['pending'] }}</span>
        @endif
    </button>
    <button class="tab-btn {{ $status === 'approved' ? 'active' : '' }}"
        onclick="location.href='{{ route('admin.approval.program') }}?status=approved'">
        Disetujui
        @if($counts['approved'] > 0)
            <span class="count-pill" style="background:var(--accent);">{{ $counts['approved'] }}</span>
        @endif
    </button>
    <button class="tab-btn {{ $status === 'rejected' ? 'active' : '' }}"
        onclick="location.href='{{ route('admin.approval.program') }}?status=rejected'">
        Ditolak
        @if($counts['rejected'] > 0)
            <span class="count-pill" style="background:#9ca3af;">{{ $counts['rejected'] }}</span>
        @endif
    </button>
</div>

<div class="table-card">
    <div class="table-card-header">
        <div class="table-card-title">
            🎓 Daftar Program Pelatihan
            <span class="table-card-subtitle">{{ $programs->total() }} program</span>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Program</th>
                <th>Trainer</th>
                <th>Metode</th>
                <th>Diajukan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($programs as $program)
            @php $st = $program->status ?? 'pending'; @endphp
            <tr>
                {{-- Program --}}
                <td>
                    <div class="preview-cell">
                        <div class="preview-thumb">
                            @if($program->gambar)
                                <img src="{{ asset('storage/' . $program->gambar) }}" alt="{{ $program->judul }}" style="width:100%;height:100%;object-fit:cover;border-radius:8px;">
                            @else
                                🎓
                            @endif
                        </div>
                        <div>
                            <div class="preview-name">{{ $program->judul ?? $program->nama }}</div>
                            <div class="preview-meta">{{ Str::limit($program->deskripsi ?? '', 40) }}</div>
                        </div>
                    </div>
                </td>

                {{-- Trainer --}}
                <td>
                    @if($program->trainer)
                    <div class="submitter">
                        <div class="submitter-avatar" style="background:var(--accent);">
                            {{ strtoupper(substr($program->trainer->name ?? 'T', 0, 2)) }}
                        </div>
                        <div>
                            <div class="submitter-name">{{ $program->trainer->academic_degree ?? $program->trainer->name ?? '-' }}</div>
                            <div class="submitter-sub">Trainer</div>
                        </div>
                    </div>
                    @else
                    <span style="color:var(--text-muted);font-size:12px;">-</span>
                    @endif
                </td>

                {{-- Metode --}}
                <td style="font-size:12px;">{{ $program->metode ?? '-' }}</td>

                {{-- Diajukan --}}
                <td style="font-size:12px;color:var(--text-muted);">
                    {{ $program->created_at->format('d M Y') }}
                </td>

                {{-- Status --}}
                <td>
                    @if($st === 'approved')
                        <span class="badge badge-approved"><span class="badge-dot"></span>Disetujui</span>
                    @elseif($st === 'rejected')
                        <span class="badge badge-rejected"><span class="badge-dot"></span>Ditolak</span>
                    @else
                        <span class="badge badge-pending"><span class="badge-dot"></span>Pending</span>
                    @endif
                </td>

                {{-- Aksi --}}
                <td>
                    <div class="action-group">
                        {{-- Tombol Detail --}}
                        <button class="btn btn-ghost btn-sm btn-icon" title="Detail"
                            onclick="openDetailModal({{ $program->id }})">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>

                        {{-- Form approve (disubmit via JS) --}}
                        @if($st !== 'approved')
                        <form method="POST" action="{{ route('admin.approval.program.approve', $program->id) }}"
                              id="form-approve-{{ $program->id }}" style="display:inline;">
                            @csrf @method('PATCH')
                            <button type="button" class="btn btn-approve btn-sm"
                                onclick="confirmApprove({{ $program->id }}, '{{ addslashes($program->judul ?? $program->nama) }}')">
                                ✓ Setujui
                            </button>
                        </form>
                        @endif

                        @if($st !== 'rejected')
                        <button class="btn btn-reject btn-sm"
                            onclick="confirmReject({{ $program->id }}, '{{ addslashes($program->judul ?? $program->nama) }}')">
                            ✕ Tolak
                        </button>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6">
                    <div class="empty-state">
                        <div class="empty-state-icon">🎉</div>
                        <div class="empty-state-text">Tidak ada program dengan status ini</div>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($programs->hasPages())
    <div style="padding:14px 18px;border-top:1px solid var(--border);display:flex;justify-content:flex-end;">
        {{ $programs->withQueryString()->links() }}
    </div>
    @endif
</div>


{{-- ======================== MODAL DETAIL ======================== --}}
<div class="modal-overlay" id="modal-detail">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">Detail Program</div>
            <button class="modal-close" onclick="closeModal('modal-detail')">✕</button>
        </div>

        <div class="img-preview" id="detail-img">🎓</div>

        <div class="detail-grid" id="detail-grid"></div>

        <div class="detail-item full" id="d-reject-wrap" style="display:none;margin-bottom:12px;">
            <div class="detail-label" style="color:var(--accent2);font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:.06em;margin-bottom:4px;">Alasan Penolakan</div>
            <div class="detail-value" id="d-reject" style="font-weight:400;font-size:13px;color:var(--accent2);"></div>
        </div>

        <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:4px;">
            <button class="btn btn-ghost btn-sm" onclick="closeModal('modal-detail')">Tutup</button>
            <button class="btn btn-reject btn-sm" id="btn-detail-reject" style="display:none;">✕ Tolak</button>
            <button class="btn btn-approve btn-sm" id="btn-detail-approve" style="display:none;">✓ Setujui</button>
        </div>
    </div>
</div>


{{-- ======================== MODAL TOLAK ======================== --}}
<div class="modal-overlay" id="modal-reject">
    <div class="modal" style="max-width:460px;">
        <div class="modal-header">
            <div class="modal-title">Tolak Program</div>
            <button class="modal-close" onclick="closeModal('modal-reject')">✕</button>
        </div>
        <p style="font-size:13.5px;color:var(--text-muted);margin-bottom:18px;line-height:1.6;">
            Berikan alasan penolakan untuk program <strong id="reject-name"></strong>. Alasan ini akan tersimpan sebagai catatan untuk trainer.
        </p>
        <form id="form-reject" method="POST">
            @csrf @method('PATCH')
            <div class="form-group">
                <label class="form-label">Alasan Penolakan *</label>
                <textarea name="catatan" class="form-textarea" rows="4"
                    placeholder="Contoh: Materi belum lengkap, deskripsi kurang jelas, jadwal konflik..."
                    required></textarea>
            </div>
            <div style="display:flex;gap:10px;margin-top:6px;">
                <button type="button" class="btn btn-ghost" style="flex:1;" onclick="closeModal('modal-reject')">Batal</button>
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
const programData = @json($programs->items());

// ─── SweetAlert2 mixins ────────────────────────────────────────────────────────
const swalApprove = Swal.mixin({
    customClass: { confirmButton: 'swal-btn-confirm-approve', cancelButton: 'swal-btn-cancel' },
    buttonsStyling: false,
});
const swalReject = Swal.mixin({
    customClass: { confirmButton: 'swal-btn-confirm-reject', cancelButton: 'swal-btn-cancel' },
    buttonsStyling: false,
});

function confirmApprove(id, name) {
    swalApprove.fire({
        title: 'Setujui Program?',
        html:  '<span style="font-size:14px;color:#6b7280;">Program <strong>' + name + '</strong> akan dipublikasikan dan bisa dilihat oleh pengguna.</span>',
        icon:  'question',
        iconColor: '#10b981',
        showCancelButton: true,
        confirmButtonText: '✓ Ya, Setujui',
        cancelButtonText:  'Batal',
        reverseButtons: true,
        focusCancel: true,
    }).then(function(result) {
        if (result.isConfirmed) {
            document.getElementById('form-approve-' + id).submit();
        }
    });
}

function confirmReject(id, name) {
    swalReject.fire({
        title: 'Tolak Program?',
        html:  '<span style="font-size:14px;color:#6b7280;">Anda akan menolak program <strong>' + name + '</strong>. Lanjutkan untuk mengisi alasan penolakan.</span>',
        icon:  'warning',
        iconColor: '#ef4444',
        showCancelButton: true,
        confirmButtonText: '→ Lanjut Isi Alasan',
        cancelButtonText:  'Batal',
        reverseButtons: true,
        focusCancel: true,
    }).then(function(result) {
        if (result.isConfirmed) {
            openRejectModal(id, name);
        }
    });
}

// ─── Modal Detail ──────────────────────────────────────────────────────────────
function openDetailModal(id) {
    const p = programData.find(x => x.id === id);
    if (!p) return;

    // Gambar
    const imgEl = document.getElementById('detail-img');
    if (p.gambar) {
        imgEl.innerHTML = `<img src="/storage/${p.gambar}" alt="${p.judul}" style="width:100%;height:100%;object-fit:cover;">`;
    } else {
        imgEl.textContent = '🎓';
    }

    // Grid info
    document.getElementById('detail-grid').innerHTML = `
        <div class="detail-item">
            <div class="detail-label">Judul Program</div>
            <div class="detail-value">${p.judul ?? p.nama ?? '-'}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Tipe</div>
            <div class="detail-value">${p.tipe ? p.tipe.charAt(0).toUpperCase() + p.tipe.slice(1) : '-'}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Metode</div>
            <div class="detail-value">${p.metode ?? '-'}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Tingkat</div>
            <div class="detail-value">${p.tingkat ?? '-'}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Bahasa</div>
            <div class="detail-value">${p.bahasa ?? '-'}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Tanggal</div>
            <div class="detail-value">${p.tanggal ?? '-'}</div>
        </div>
        <div class="detail-item full">
            <div class="detail-label">Target Peserta</div>
            <div class="detail-value" style="font-weight:400;font-size:13px;">${p.target ?? '-'}</div>
        </div>
        <div class="detail-item full">
            <div class="detail-label">Deskripsi</div>
            <div class="detail-value" style="font-weight:400;font-size:13px;line-height:1.7;color:var(--text-muted)">${p.deskripsi ?? '-'}</div>
        </div>
    `;

    // Alasan penolakan (jika ada)
    const rejectWrap = document.getElementById('d-reject-wrap');
    if (p.status === 'rejected' && p.catatan_admin) {
        rejectWrap.style.display = 'block';
        document.getElementById('d-reject').textContent = p.catatan_admin;
    } else {
        rejectWrap.style.display = 'none';
    }

    // Tombol aksi di dalam modal
    const btnApprove = document.getElementById('btn-detail-approve');
    const btnReject  = document.getElementById('btn-detail-reject');
    btnApprove.style.display = p.status !== 'approved' ? 'inline-flex' : 'none';
    btnReject.style.display  = p.status !== 'rejected' ? 'inline-flex' : 'none';

    btnApprove.onclick = () => { closeModal('modal-detail'); confirmApprove(id, p.judul ?? p.nama); };
    btnReject.onclick  = () => { closeModal('modal-detail'); confirmReject(id, p.judul ?? p.nama); };

    openModal('modal-detail');
}

// ─── Modal Reject ──────────────────────────────────────────────────────────────
function openRejectModal(id, name) {
    document.getElementById('reject-name').textContent = name;
    document.getElementById('form-reject').action = `/admin/approval/program/${id}/reject`;
    openModal('modal-reject');
}

function openModal(id)  { document.getElementById(id).classList.add('open'); }
function closeModal(id) { document.getElementById(id).classList.remove('open'); }

document.querySelectorAll('.modal-overlay').forEach(function(el) {
    el.addEventListener('click', function(e) {
        if (e.target === el) closeModal(el.id);
    });
});
</script>
@endpush