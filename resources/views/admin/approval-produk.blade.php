{{-- resources/views/admin/approval-produk.blade.php --}}
@extends('layouts.admin')

@section('page-title', 'Approval Produk')

@section('content')

{{-- Tab Bar --}}
<div class="tab-bar">
    <button class="tab-btn active" data-tab="pending" onclick="switchTab('pending', this)">
        Menunggu
        @if($counts['pending'] > 0)
            <span class="count-pill">{{ $counts['pending'] }}</span>
        @endif
    </button>
    <button class="tab-btn" data-tab="approved" onclick="switchTab('approved', this)">
        Disetujui
        @if($counts['approved'] > 0)
            <span class="count-pill" style="background:var(--accent);">{{ $counts['approved'] }}</span>
        @endif
    </button>
    <button class="tab-btn" data-tab="rejected" onclick="switchTab('rejected', this)">
        Ditolak
        @if($counts['rejected'] > 0)
            <span class="count-pill" style="background:#9ca3af;">{{ $counts['rejected'] }}</span>
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
                Produk Menunggu Review
                <span class="table-card-subtitle">{{ $counts['pending'] }} produk</span>
            </div>
        </div>

        @if($pending->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">🎉</div>
                <div class="empty-state-text">Tidak ada produk yang menunggu review.</div>
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Lokasi</th>
                        <th>Dikirim</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pending as $produk)
                    <tr>
                        <td>
                            <div class="submitter">
                                <div class="submitter-avatar" style="background:var(--accent3);border-radius:8px;overflow:hidden;">
                                    @if($produk->foto)
                                        <img src="{{ asset('storage/' . $produk->foto) }}" alt="{{ $produk->nama }}" style="width:100%;height:100%;object-fit:cover;">
                                    @else
                                        🛍️
                                    @endif
                                </div>
                                <div>
                                    <div class="submitter-name">{{ $produk->nama }}</div>
                                    <div class="submitter-sub">{{ Str::limit($produk->deskripsi ?? '', 35) }}</div>
                                </div>
                            </div>
                        </td>
                        <td><div style="font-size:13px;">{{ $produk->kategori ?? '-' }}</div></td>
                        <td><div style="font-size:13px;">Rp {{ number_format($produk->harga ?? 0, 0, ',', '.') }}</div></td>
                        <td>
                            <div style="font-size:12px;color:var(--text-muted);max-width:160px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                {{ $produk->alamat ?? '-' }}
                            </div>
                        </td>
                        <td>
                            <div style="font-size:12px;color:var(--text-muted);">
                                {{ $produk->created_at->diffForHumans() }}
                            </div>
                        </td>
                        <td>
                            <div class="action-group">
                                <button class="btn btn-ghost btn-sm" onclick="openDetailModal({{ $produk->id }})">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Detail
                                </button>
                                {{-- FIX: hapus @method('PATCH') — route sudah POST --}}
                                <form method="POST" action="{{ route('admin.approval.produk.approve', $produk) }}" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-approve btn-sm">
                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Setujui
                                    </button>
                                </form>
                                <button class="btn btn-reject btn-sm" onclick="openRejectModal({{ $produk->id }}, '{{ addslashes($produk->nama) }}')">
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
                Produk Disetujui
                <span class="table-card-subtitle">{{ $counts['approved'] }} produk aktif</span>
            </div>
        </div>

        @if($approved->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">📭</div>
                <div class="empty-state-text">Belum ada produk yang disetujui.</div>
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Lokasi</th>
                        <th>Disetujui</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($approved as $produk)
                    <tr>
                        <td>
                            <div class="submitter">
                                <div class="submitter-avatar" style="background:var(--accent3);border-radius:8px;overflow:hidden;">
                                    @if($produk->foto)
                                        <img src="{{ asset('storage/' . $produk->foto) }}" alt="{{ $produk->nama }}" style="width:100%;height:100%;object-fit:cover;">
                                    @else
                                        🛍️
                                    @endif
                                </div>
                                <div>
                                    <div class="submitter-name">{{ $produk->nama }}</div>
                                    <div class="submitter-sub">{{ Str::limit($produk->deskripsi ?? '', 35) }}</div>
                                </div>
                            </div>
                        </td>
                        <td><div style="font-size:13px;">{{ $produk->kategori ?? '-' }}</div></td>
                        <td><div style="font-size:13px;">Rp {{ number_format($produk->harga ?? 0, 0, ',', '.') }}</div></td>
                        <td>
                            <div style="font-size:12px;color:var(--text-muted);max-width:160px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                {{ $produk->alamat ?? '-' }}
                            </div>
                        </td>
                        <td>
                            <div style="font-size:12px;color:var(--text-muted);">
                                {{ $produk->approved_at?->diffForHumans() ?? '-' }}
                            </div>
                        </td>
                        <td><span class="badge badge-approved"><span class="badge-dot"></span>Aktif</span></td>
                        <td>
                            <div class="action-group">
                                <button class="btn btn-ghost btn-sm" onclick="openDetailModal({{ $produk->id }})">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Detail
                                </button>
                                <form method="POST"
                                      action="{{ route('admin.approval.produk.destroy', $produk) }}"
                                      style="display:inline;"
                                      onsubmit="return confirmHapus('{{ addslashes($produk->nama) }}')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm" style="background:#fee2e2;color:#dc2626;border:1px solid #fca5a5;">
                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
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
                Produk Ditolak
                <span class="table-card-subtitle">{{ $counts['rejected'] }} ditolak</span>
            </div>
        </div>

        @if($rejected->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">📭</div>
                <div class="empty-state-text">Tidak ada produk yang ditolak.</div>
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th>Alasan Penolakan</th>
                        <th>Ditolak</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rejected as $produk)
                    <tr>
                        <td>
                            <div class="submitter">
                                <div class="submitter-avatar" style="background:#9ca3af;border-radius:8px;overflow:hidden;">
                                    @if($produk->foto)
                                        <img src="{{ asset('storage/' . $produk->foto) }}" alt="{{ $produk->nama }}" style="width:100%;height:100%;object-fit:cover;">
                                    @else
                                        🛍️
                                    @endif
                                </div>
                                <div>
                                    <div class="submitter-name">{{ $produk->nama }}</div>
                                    <div class="submitter-sub">{{ Str::limit($produk->deskripsi ?? '', 35) }}</div>
                                </div>
                            </div>
                        </td>
                        <td><div style="font-size:13px;">{{ $produk->kategori ?? '-' }}</div></td>
                        <td>
                            <div style="font-size:12px;color:var(--accent2);max-width:200px;">
                                {{ Str::limit($produk->catatan_admin ?? '-', 60) }}
                            </div>
                        </td>
                        <td>
                            <div style="font-size:12px;color:var(--text-muted);">
                                {{ $produk->rejected_at?->diffForHumans() ?? '-' }}
                            </div>
                        </td>
                        <td>
                            <div class="action-group">
                                <button class="btn btn-ghost btn-sm" onclick="openDetailModal({{ $produk->id }})">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Detail
                                </button>
                                <form method="POST"
                                      action="{{ route('admin.approval.produk.destroy', $produk) }}"
                                      style="display:inline;"
                                      onsubmit="return confirmHapus('{{ addslashes($produk->nama) }}')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm" style="background:#fee2e2;color:#dc2626;border:1px solid #fca5a5;">
                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
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
            <div class="modal-title">Detail Produk</div>
            <button class="modal-close" onclick="closeModal('modal-detail')">✕</button>
        </div>

        <div class="img-preview" id="detail-img">
            <span>🛍️</span>
        </div>

        <div class="detail-grid">
            <div class="detail-item">
                <div class="detail-label">Nama Produk</div>
                <div class="detail-value" id="d-nama">-</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Status</div>
                <div class="detail-value" id="d-status">-</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Kategori</div>
                <div class="detail-value" id="d-kategori">-</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Harga</div>
                <div class="detail-value" id="d-harga">-</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">No. WhatsApp</div>
                <div class="detail-value" id="d-whatsapp">-</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Didaftarkan</div>
                <div class="detail-value" id="d-tanggal">-</div>
            </div>
            <div class="detail-item full">
                <div class="detail-label">Deskripsi</div>
                <div class="detail-value" id="d-deskripsi" style="font-weight:400;line-height:1.6;font-size:13px;color:var(--text-muted);">-</div>
            </div>
            <div class="detail-item full">
                <div class="detail-label">Alamat</div>
                <div class="detail-value" id="d-alamat" style="font-weight:400;font-size:13px;">-</div>
            </div>
            <div class="detail-item full" id="d-reject-wrap" style="display:none;">
                <div class="detail-label" style="color:var(--accent2);">Alasan Penolakan</div>
                <div class="detail-value" id="d-reject" style="font-weight:400;font-size:13px;color:var(--accent2);">-</div>
            </div>
        </div>

        <div id="d-action-btns" style="display:flex;gap:10px;margin-top:4px;">
            <button class="btn btn-ghost" style="flex:1;" onclick="closeModal('modal-detail')">Tutup</button>
            <button class="btn btn-reject" id="btn-detail-reject" style="flex:1;">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Tolak
            </button>
            <button class="btn btn-approve" id="btn-detail-approve" style="flex:1;">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M5 13l4 4L19 7"/>
                </svg>
                Setujui
            </button>
        </div>
        <div id="d-close-only" style="display:none;margin-top:4px;">
            <button class="btn btn-ghost" style="width:100%;" onclick="closeModal('modal-detail')">Tutup</button>
        </div>
    </div>
</div>

{{-- ======================== MODAL TOLAK ======================== --}}
<div class="modal-overlay" id="modal-reject">
    <div class="modal" style="width:460px;">
        <div class="modal-header">
            <div class="modal-title">Tolak Produk</div>
            <button class="modal-close" onclick="closeModal('modal-reject')">✕</button>
        </div>
        <p style="font-size:13.5px;color:var(--text-muted);margin-bottom:18px;line-height:1.6;">
            Berikan alasan penolakan untuk <strong id="reject-name"></strong>. Alasan ini akan tersimpan sebagai catatan.
        </p>
        {{-- FIX: hapus @method('PATCH') — route sudah POST --}}
        <form id="reject-form" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">Alasan Penolakan *</label>
                <textarea name="alasan" class="form-textarea" rows="4"
                    placeholder="Contoh: Foto produk kurang jelas, deskripsi tidak lengkap..."
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
const produkData = @json($pending->merge($approved)->merge($rejected)->keyBy('id'));
const csrfToken  = '{{ csrf_token() }}';

function switchTab(tab, btn) {
    ['pending', 'approved', 'rejected'].forEach(t => {
        document.getElementById('tab-' + t).style.display = t === tab ? 'block' : 'none';
    });
    btn.closest('.tab-bar').querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    const url = new URL(window.location);
    url.searchParams.set('tab', tab);
    window.history.replaceState({}, '', url);
}

document.addEventListener('DOMContentLoaded', function () {
    const params    = new URLSearchParams(window.location.search);
    const activeTab = params.get('tab') || 'pending';
    const tabBtn    = document.querySelector(`.tab-btn[data-tab="${activeTab}"]`);
    if (tabBtn) switchTab(activeTab, tabBtn);
});

function openDetailModal(id) {
    const p = produkData[id];
    if (!p) return;

    const imgEl = document.getElementById('detail-img');
    if (p.foto) {
        imgEl.innerHTML = `<img src="/storage/${p.foto}" alt="${p.nama}" style="width:100%;height:100%;object-fit:cover;">`;
    } else {
        imgEl.innerHTML = '<span>🛍️</span>';
    }

    document.getElementById('d-nama').textContent      = p.nama;
    document.getElementById('d-kategori').textContent  = p.kategori ?? '-';
    document.getElementById('d-harga').textContent     = 'Rp ' + (p.harga ?? 0).toLocaleString('id');
    document.getElementById('d-whatsapp').textContent  = p.whatsapp ?? '-';
    document.getElementById('d-deskripsi').textContent = p.deskripsi ?? '-';
    document.getElementById('d-alamat').textContent    = p.alamat ?? '-';
    document.getElementById('d-tanggal').textContent   = p.created_at
        ? new Date(p.created_at).toLocaleDateString('id-ID', {day:'2-digit',month:'long',year:'numeric'})
        : '-';

    const statusMap = {
        pending:  '<span class="badge badge-pending"><span class="badge-dot"></span>Menunggu</span>',
        approved: '<span class="badge badge-approved"><span class="badge-dot"></span>Disetujui</span>',
        rejected: '<span class="badge badge-rejected"><span class="badge-dot"></span>Ditolak</span>',
    };
    document.getElementById('d-status').innerHTML = statusMap[p.status] ?? p.status;

    const rejectWrap = document.getElementById('d-reject-wrap');
    if (p.status === 'rejected' && p.catatan_admin) {
        rejectWrap.style.display = 'block';
        document.getElementById('d-reject').textContent = p.catatan_admin;
    } else {
        rejectWrap.style.display = 'none';
    }

    const actionBtns = document.getElementById('d-action-btns');
    const closeOnly  = document.getElementById('d-close-only');
    if (p.status === 'pending') {
        actionBtns.style.display = 'flex';
        closeOnly.style.display  = 'none';
        document.getElementById('btn-detail-approve').onclick = () => {
            closeModal('modal-detail');
            submitApprove(id);
        };
        document.getElementById('btn-detail-reject').onclick = () => {
            closeModal('modal-detail');
            openRejectModal(id, p.nama);
        };
    } else {
        actionBtns.style.display = 'none';
        closeOnly.style.display  = 'block';
    }

    openModal('modal-detail');
}


function submitApprove(id) {
    const form  = document.createElement('form');
    form.method = 'POST';
    form.action = `/admin/approval/produk/${id}/approve`;

    const token   = document.createElement('input');
    token.type    = 'hidden';
    token.name    = '_token';
    token.value   = csrfToken;

    form.appendChild(token);
    document.body.appendChild(form);
    form.submit();
}

function openRejectModal(id, nama) {
    document.getElementById('reject-name').textContent = nama;
    document.getElementById('reject-form').action = `/admin/approval/produk/${id}/reject?tab=rejected`;
    openModal('modal-reject');
}

function confirmHapus(nama) {
    return confirm(`Hapus produk "${nama}"?\n\nTindakan ini tidak dapat dibatalkan.`);
}
</script>

@endsection