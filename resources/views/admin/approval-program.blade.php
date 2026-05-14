@extends('layouts.admin')

@section('page-title', 'Approval Program')

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
        background: #f3f4f6; color: #374151; border: 1px solid #e5e7eb; cursor: pointer; transition: background 0.15s;
    }
    .swal-btn-cancel:hover { background: #e5e7eb; }
    .swal2-popup { border-radius: 16px !important; padding: 32px 28px !important; }
    .swal2-title { font-size: 18px !important; font-weight: 700 !important; color: #111827 !important; }
    .swal2-actions { gap: 10px !important; margin-top: 24px !important; }

    /* ── Filter tipe chips ── */
    .tipe-filter { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 16px; }
    .tipe-chip {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 5px 14px; border-radius: 20px; font-size: 12px; font-weight: 600;
        border: 1.5px solid var(--border, #e5e7eb); background: #f9fafb;
        color: #6b7280; cursor: pointer; text-decoration: none; transition: all .15s;
    }
    .tipe-chip:hover { border-color: #6b7280; color: #374151; }
    .tipe-chip.active-all       { background: #1f2937; color: #fff; border-color: #1f2937; }
    .tipe-chip.active-kurikulum { background: #dbeafe; color: #1d4ed8; border-color: #93c5fd; }
    .tipe-chip.active-modul     { background: #dcfce7; color: #15803d; border-color: #86efac; }
    .tipe-chip .chip-count {
        background: rgba(0,0,0,.12); border-radius: 20px;
        padding: 1px 6px; font-size: 10px; font-weight: 700;
    }

    /* ── Badge tipe di tabel ── */
    .badge-tipe-kurikulum { background:#dbeafe;color:#1d4ed8;border:1px solid #93c5fd; }
    .badge-tipe-modul     { background:#dcfce7;color:#15803d;border:1px solid #86efac; }

    /* ── Info box di modal detail ── */
    .info-grid {
        display: grid; grid-template-columns: repeat(3,1fr); gap: 10px;
        background: #f9fafb; border: 1px solid #e5e7eb;
        border-radius: 12px; padding: 14px; margin-bottom: 14px;
    }
    .info-grid-item { text-align: center; }
    .info-grid-item .ig-val  { font-size: 18px; font-weight: 800; color: #111827; }
    .info-grid-item .ig-label{ font-size: 10px; color: #9ca3af; text-transform: uppercase; letter-spacing: .06em; margin-top: 2px; }
    .sertifikat-badge {
        display: inline-flex; align-items: center; gap: 5px;
        background: #fef9c3; color: #854d0e; border: 1px solid #fde68a;
        border-radius: 20px; padding: 4px 12px; font-size: 12px; font-weight: 600;
    }
    .kurikulum-ref {
        display: flex; align-items: center; gap: 8px;
        background: #dbeafe; border: 1px solid #93c5fd; border-radius: 10px;
        padding: 10px 14px; margin-bottom: 14px; font-size: 13px;
    }
    .kurikulum-ref .kr-icon { font-size: 18px; }
    .kurikulum-ref .kr-label { font-size: 10px; color: #3b82f6; text-transform: uppercase; letter-spacing: .06em; }
    .kurikulum-ref .kr-title { font-weight: 700; color: #1d4ed8; }
</style>
@endpush

@section('content')

{{-- ── Tab status ── --}}
<div class="tab-bar">
    <button class="tab-btn {{ $status === 'pending' ? 'active' : '' }}"
        onclick="location.href='{{ route('admin.approval.program') }}?status=pending&tipe={{ $tipe }}'">
        Pending
        @if($counts['pending'] > 0)
            <span class="count-pill">{{ $counts['pending'] }}</span>
        @endif
    </button>
    <button class="tab-btn {{ $status === 'approved' ? 'active' : '' }}"
        onclick="location.href='{{ route('admin.approval.program') }}?status=approved&tipe={{ $tipe }}'">
        Disetujui
        @if($counts['approved'] > 0)
            <span class="count-pill" style="background:var(--accent);">{{ $counts['approved'] }}</span>
        @endif
    </button>
    <button class="tab-btn {{ $status === 'rejected' ? 'active' : '' }}"
        onclick="location.href='{{ route('admin.approval.program') }}?status=rejected&tipe={{ $tipe }}'">
        Ditolak
        @if($counts['rejected'] > 0)
            <span class="count-pill" style="background:#9ca3af;">{{ $counts['rejected'] }}</span>
        @endif
    </button>
</div>

{{-- ── Filter tipe chips ── --}}
<div class="tipe-filter">
    <a href="{{ route('admin.approval.program') }}?status={{ $status }}&tipe=all"
       class="tipe-chip {{ $tipe === 'all' ? 'active-all' : '' }}">
        📋 Semua <span class="chip-count">{{ $countTipe['all'] }}</span>
    </a>
    <a href="{{ route('admin.approval.program') }}?status={{ $status }}&tipe=kurikulum"
       class="tipe-chip {{ $tipe === 'kurikulum' ? 'active-kurikulum' : '' }}">
        📚 Kurikulum <span class="chip-count">{{ $countTipe['kurikulum'] }}</span>
    </a>
    <a href="{{ route('admin.approval.program') }}?status={{ $status }}&tipe=modul"
       class="tipe-chip {{ $tipe === 'modul' ? 'active-modul' : '' }}">
        📝 Modul <span class="chip-count">{{ $countTipe['modul'] }}</span>
    </a>
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
                <th>Tipe</th>
                <th>Trainer</th>
                <th>Metode / Induk</th>
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
                                <img src="{{ asset('storage/' . $program->gambar) }}" alt="{{ $program->judul }}"
                                    style="width:100%;height:100%;object-fit:cover;border-radius:8px;">
                            @else
                                {{ $program->tipe === 'modul' ? '📝' : '📚' }}
                            @endif
                        </div>
                        <div>
                            <div class="preview-name">{{ $program->judul ?? $program->nama }}</div>
                            <div class="preview-meta">{{ Str::limit($program->deskripsi ?? '', 40) }}</div>
                        </div>
                    </div>
                </td>

                {{-- Tipe --}}
                <td>
                    @if($program->tipe === 'kurikulum')
                        <span class="badge badge-tipe-kurikulum" style="display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;">
                            📚 Kurikulum
                        </span>
                    @elseif($program->tipe === 'modul')
                        <span class="badge badge-tipe-modul" style="display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;">
                            📝 Modul
                        </span>
                        @if($program->urutan)
                        <div style="font-size:10px;color:#9ca3af;margin-top:2px;">Urutan #{{ $program->urutan }}</div>
                        @endif
                    @else
                        <span style="font-size:12px;color:#9ca3af;">{{ ucfirst($program->tipe ?? '-') }}</span>
                    @endif
                </td>

                {{-- Trainer --}}
                <td>
                    @if($program->trainer)
                    <div class="submitter">
                        <div class="submitter-avatar" style="background:var(--accent);">
                            {{ strtoupper(substr($program->trainer->name ?? 'T', 0, 2)) }}
                        </div>
                        <div>
                            <div class="submitter-name">{{ $program->trainer->name ?? '-' }}</div>
                            <div class="submitter-sub">Trainer</div>
                        </div>
                    </div>
                    @else
                    <span style="color:var(--text-muted);font-size:12px;">-</span>
                    @endif
                </td>

                {{-- Metode / Kurikulum Induk --}}
                <td style="font-size:12px;">
                    @if($program->tipe === 'modul')
                        @php
                            $induk = $program->kurikulum_id
                                ? \App\Models\Program::find($program->kurikulum_id)
                                : null;
                        @endphp
                        @if($induk)
                            <span style="color:#1d4ed8;font-weight:600;">📚 {{ Str::limit($induk->judul, 25) }}</span>
                        @else
                            <span style="color:#9ca3af;">—</span>
                        @endif
                    @else
                        {{ ucfirst($program->metode ?? '-') }}
                    @endif
                </td>

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
                        <button class="btn btn-ghost btn-sm btn-icon" title="Detail"
                            onclick="openDetailModal({{ $program->id }})">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>

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
                <td colspan="7">
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
            <div class="modal-title" id="detail-modal-title">Detail Program</div>
            <button class="modal-close" onclick="closeModal('modal-detail')">✕</button>
        </div>

        <div class="img-preview" id="detail-img">📚</div>

        {{-- Info box khusus kurikulum (jumlah sesi, total jam, sertifikat) --}}
        <div id="detail-kurikulum-info" style="display:none;margin-bottom:14px;">
            <div class="info-grid">
                <div class="info-grid-item">
                    <div class="ig-val" id="d-jumlah-materi">-</div>
                    <div class="ig-label">Jumlah Materi</div>
                </div>
                <div class="info-grid-item">
                    <div class="ig-val" id="d-total-jam">-</div>
                    <div class="ig-label">Total Jam</div>
                </div>
                <div class="info-grid-item">
                    <div class="ig-val" id="d-jumlah-sesi">-</div>
                    <div class="ig-label">Jumlah Sesi</div>
                </div>
            </div>
            <div id="d-sertifikat-wrap" style="margin-bottom:8px;"></div>
        </div>

        {{-- Ref kurikulum induk (untuk modul) --}}
        <div id="detail-modul-induk" class="kurikulum-ref" style="display:none;">
            <div class="kr-icon">📚</div>
            <div>
                <div class="kr-label">Bagian dari Kurikulum</div>
                <div class="kr-title" id="d-induk-judul">—</div>
            </div>
            <div style="margin-left:auto;font-size:12px;color:#3b82f6;font-weight:700;" id="d-induk-urutan"></div>
        </div>

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
            Berikan alasan penolakan untuk <strong id="reject-name"></strong>. Alasan ini akan tersimpan sebagai catatan untuk trainer.
        </p>
        <form id="form-reject" method="POST">
            @csrf @method('PATCH')
            <div class="form-group">
                <label class="form-label">Alasan Penolakan *</label>
                <textarea name="catatan" class="form-textarea" rows="4"
                    placeholder="Contoh: Deskripsi kurang lengkap, judul tidak sesuai kategori..."
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
// Sertakan data program + kurikulum induk (di-load dari server)
const programData    = @json($programs->items());

// ─── SweetAlert2 ──────────────────────────────────────────────────────────────
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
        html:  '<span style="font-size:14px;color:#6b7280;">Program <strong>' + name + '</strong> akan dipublikasikan.</span>',
        icon:  'question', iconColor: '#10b981',
        showCancelButton: true,
        confirmButtonText: '✓ Ya, Setujui',
        cancelButtonText:  'Batal',
        reverseButtons: true, focusCancel: true,
    }).then(function(result) {
        if (result.isConfirmed) document.getElementById('form-approve-' + id).submit();
    });
}

function confirmReject(id, name) {
    swalReject.fire({
        title: 'Tolak Program?',
        html:  '<span style="font-size:14px;color:#6b7280;">Kamu akan menolak <strong>' + name + '</strong>.</span>',
        icon:  'warning', iconColor: '#ef4444',
        showCancelButton: true,
        confirmButtonText: '→ Lanjut Isi Alasan',
        cancelButtonText:  'Batal',
        reverseButtons: true, focusCancel: true,
    }).then(function(result) {
        if (result.isConfirmed) openRejectModal(id, name);
    });
}

// ─── Modal Detail ──────────────────────────────────────────────────────────────
function openDetailModal(id) {
    const p = programData.find(x => x.id === id);
    if (!p) return;

    // Judul modal
    document.getElementById('detail-modal-title').textContent =
        p.tipe === 'modul' ? 'Detail Modul' : 'Detail Kurikulum';

    // Gambar / icon
    const imgEl = document.getElementById('detail-img');
    if (p.gambar) {
        imgEl.innerHTML = `<img src="/storage/${p.gambar}" alt="${p.judul}" style="width:100%;height:100%;object-fit:cover;">`;
    } else {
        imgEl.textContent = p.tipe === 'modul' ? '📝' : '📚';
    }

    // ── Kurikulum: info box (sesi, jam, sertifikat) ──
    const kurikulumInfo = document.getElementById('detail-kurikulum-info');
    const modulInduk    = document.getElementById('detail-modul-induk');

    if (p.tipe === 'kurikulum') {
        kurikulumInfo.style.display = 'block';
        modulInduk.style.display    = 'none';
        document.getElementById('d-jumlah-materi').textContent = p.jumlah_materi ?? '-';
        document.getElementById('d-total-jam').textContent     = p.total_jam ? p.total_jam + ' jam' : '-';
        document.getElementById('d-jumlah-sesi').textContent   = p.jumlah_sesi ?? '-';

        const sertWrap = document.getElementById('d-sertifikat-wrap');
        if (p.sertifikat) {
            sertWrap.innerHTML = '<span class="sertifikat-badge">🏆 Ada sertifikat kelulusan</span>';
        } else {
            sertWrap.innerHTML = '';
        }
    } else if (p.tipe === 'modul') {
        kurikulumInfo.style.display = 'none';
        modulInduk.style.display    = 'flex';
        // Cari kurikulum induk dari programData atau tampilkan ID
        const induk = programData.find(x => x.id === p.kurikulum_id);
        document.getElementById('d-induk-judul').textContent  = induk ? induk.judul : 'Kurikulum #' + (p.kurikulum_id ?? '?');
        document.getElementById('d-induk-urutan').textContent = p.urutan ? 'Urutan #' + p.urutan : '';
    } else {
        kurikulumInfo.style.display = 'none';
        modulInduk.style.display    = 'none';
    }

    // ── Grid info umum ──
    const isModul = p.tipe === 'modul';
    document.getElementById('detail-grid').innerHTML = `
        <div class="detail-item">
            <div class="detail-label">Judul</div>
            <div class="detail-value">${p.judul ?? '-'}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">Tipe</div>
            <div class="detail-value">${p.tipe ? p.tipe.charAt(0).toUpperCase() + p.tipe.slice(1) : '-'}</div>
        </div>
        ${!isModul ? `
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
            <div class="detail-label">Target Peserta</div>
            <div class="detail-value" style="font-weight:400;font-size:13px;">${p.target ?? '-'}</div>
        </div>
        ` : `
        <div class="detail-item">
            <div class="detail-label">Nomor Urutan</div>
            <div class="detail-value">#${p.urutan ?? '-'}</div>
        </div>
        `}
        <div class="detail-item full">
            <div class="detail-label">Deskripsi</div>
            <div class="detail-value" style="font-weight:400;font-size:13px;line-height:1.7;color:var(--text-muted)">${p.deskripsi ?? '-'}</div>
        </div>
    `;

    // Alasan penolakan
    const rejectWrap = document.getElementById('d-reject-wrap');
    if (p.status === 'rejected' && p.catatan_admin) {
        rejectWrap.style.display = 'block';
        document.getElementById('d-reject').textContent = p.catatan_admin;
    } else {
        rejectWrap.style.display = 'none';
    }

    // Tombol aksi
    const btnApprove = document.getElementById('btn-detail-approve');
    const btnReject  = document.getElementById('btn-detail-reject');
    btnApprove.style.display = p.status !== 'approved' ? 'inline-flex' : 'none';
    btnReject.style.display  = p.status !== 'rejected' ? 'inline-flex' : 'none';
    btnApprove.onclick = () => { closeModal('modal-detail'); confirmApprove(id, p.judul); };
    btnReject.onclick  = () => { closeModal('modal-detail'); confirmReject(id, p.judul); };

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
    el.addEventListener('click', function(e) { if (e.target === el) closeModal(el.id); });
});
</script>
@endpush