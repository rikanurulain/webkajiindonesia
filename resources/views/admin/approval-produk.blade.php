@extends('layouts.admin')

@section('page-title', 'Approval Produk')

@section('content')

<div class="tab-bar">
    <button class="tab-btn {{ $status === 'pending' ? 'active' : '' }}"
        onclick="location.href='{{ route('admin.approval.produk') }}?status=pending'">
        Pending
        @if($counts['pending'] > 0)<span class="count-pill">{{ $counts['pending'] }}</span>@endif
    </button>
    <button class="tab-btn {{ $status === 'approved' ? 'active' : '' }}"
        onclick="location.href='{{ route('admin.approval.produk') }}?status=approved'">
        Disetujui
    </button>
    <button class="tab-btn {{ $status === 'rejected' ? 'active' : '' }}"
        onclick="location.href='{{ route('admin.approval.produk') }}?status=rejected'">
        Ditolak
    </button>
</div>

<div class="table-card">
    <div class="table-card-header">
        <div class="table-card-title">
            🛍️ Daftar Produk
            <span class="table-card-subtitle">{{ $produks->total() }} produk</span>
        </div>
        {{-- Bisa tambah search/filter di sini --}}
    </div>

    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Lokasi</th>
                <th>Didaftarkan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($produks as $produk)
            <tr>
                <td>
                    <div class="preview-cell">
                        <div class="preview-thumb">
                            @if($produk->foto)
                                <img src="{{ asset('storage/' . $produk->foto) }}" alt="{{ $produk->nama }}">
                            @else
                                🛍️
                            @endif
                        </div>
                        <div>
                            <div class="preview-name">{{ $produk->nama }}</div>
                            <div class="preview-meta">{{ Str::limit($produk->deskripsi ?? '', 40) }}</div>
                        </div>
                    </div>
                </td>
                <td>{{ $produk->kategori ?? '-' }}</td>
                <td>Rp {{ number_format($produk->harga ?? 0, 0, ',', '.') }}</td>
                <td style="font-size:12px;color:var(--text-muted);">{{ Str::limit($produk->alamat ?? '-', 22) }}</td>
                <td style="font-size:12px;color:var(--text-muted);">
                    {{ $produk->created_at->format('d M Y') }}
                </td>
                <td>
                    @if(($produk->status ?? 'pending') === 'approved')
                        <span class="badge badge-approved"><span class="badge-dot"></span>Disetujui</span>
                    @elseif(($produk->status ?? 'pending') === 'rejected')
                        <span class="badge badge-rejected"><span class="badge-dot"></span>Ditolak</span>
                    @else
                        <span class="badge badge-pending"><span class="badge-dot"></span>Pending</span>
                    @endif
                </td>
                <td>
                    <div class="action-group">
                        <button class="btn btn-ghost btn-sm btn-icon" title="Detail"
                            onclick="openDetailModal({{ $produk->id }})">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                        @if(($produk->status ?? 'pending') !== 'approved')
                        <button class="btn btn-approve btn-sm"
                            onclick="openApprove({{ $produk->id }})">
                            ✓
                        </button>
                        @endif
                        @if(($produk->status ?? 'pending') !== 'rejected')
                        <button class="btn btn-reject btn-sm"
                            onclick="openReject({{ $produk->id }})">
                            ✕
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
                        <div class="empty-state-text">Tidak ada produk dengan status ini</div>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($produks->hasPages())
    <div style="padding:14px 18px;border-top:1px solid var(--border);display:flex;justify-content:flex-end;">
        {{ $produks->withQueryString()->links() }}
    </div>
    @endif
</div>

{{-- MODAL DETAIL --}}
<div class="modal-overlay" id="modal-detail">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">Detail Produk</div>
            <button class="modal-close" onclick="closeModal('modal-detail')">×</button>
        </div>
        <div class="img-preview" id="detail-img">🛍️</div>
        <div class="detail-grid" id="detail-grid">
            {{-- Diisi via JS --}}
        </div>
        <div class="form-group">
            <label class="form-label">Catatan Admin (opsional)</label>
            <textarea class="form-textarea" id="detail-catatan" placeholder="Berikan catatan atau alasan keputusan Anda..."></textarea>
        </div>
        <div style="display:flex;gap:10px;justify-content:flex-end;">
            <button class="btn btn-ghost" onclick="closeModal('modal-detail')">Tutup</button>
            <button class="btn btn-reject" id="btn-detail-reject">✕ Tolak</button>
            <button class="btn btn-approve" id="btn-detail-approve">✓ Setujui</button>
        </div>
    </div>
</div>

{{-- MODAL APPROVE --}}
<div class="modal-overlay" id="modal-approve">
    <div class="modal confirm-modal">
        <div class="confirm-icon">✅</div>
        <div class="confirm-title">Konfirmasi Persetujuan</div>
        <div class="confirm-desc">Produk ini akan langsung aktif dan bisa dilihat oleh pengunjung platform Kaji Indonesia.</div>
        <form id="form-approve" method="POST">
            @csrf
            @method('PATCH')
            <div class="confirm-btns">
                <button type="button" class="btn btn-ghost" onclick="closeModal('modal-approve')">Batal</button>
                <button type="submit" class="btn btn-approve">✓ Ya, Setujui</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL REJECT --}}
<div class="modal-overlay" id="modal-reject">
    <div class="modal confirm-modal">
        <div class="confirm-icon">❌</div>
        <div class="confirm-title">Konfirmasi Penolakan</div>
        <div class="confirm-desc">Berikan alasan agar pengaju dapat memperbaiki produknya.</div>
        <form id="form-reject" method="POST">
            @csrf
            @method('PATCH')
            <div class="form-group" style="text-align:left;margin-bottom:18px;">
                <label class="form-label">Alasan Penolakan</label>
                <textarea class="form-textarea" name="catatan" placeholder="Contoh: Foto produk kurang jelas, deskripsi tidak lengkap..."></textarea>
            </div>
            <div class="confirm-btns">
                <button type="button" class="btn btn-ghost" onclick="closeModal('modal-reject')">Batal</button>
                <button type="submit" class="btn btn-reject">✕ Ya, Tolak</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    const produkData = @json($produks->items());

    function openDetailModal(id) {
        const p = produkData.find(x => x.id === id);
        if (!p) return;

        // Image
        const imgEl = document.getElementById('detail-img');
        if (p.foto) {
            imgEl.innerHTML = `<img src="/storage/${p.foto}" alt="${p.nama}" style="width:100%;height:100%;object-fit:cover;">`;
        } else {
            imgEl.textContent = '🛍️';
        }

        // Grid info
        document.getElementById('detail-grid').innerHTML = `
            <div class="detail-item"><div class="detail-label">Nama Produk</div><div class="detail-value">${p.nama}</div></div>
            <div class="detail-item"><div class="detail-label">Kategori</div><div class="detail-value">${p.kategori ?? '-'}</div></div>
            <div class="detail-item"><div class="detail-label">Harga</div><div class="detail-value">Rp ${(p.harga ?? 0).toLocaleString('id')}</div></div>
            <div class="detail-item"><div class="detail-label">WhatsApp</div><div class="detail-value">${p.whatsapp ?? '-'}</div></div>
            <div class="detail-item full"><div class="detail-label">Deskripsi</div><div class="detail-value" style="font-weight:400;font-size:13px;line-height:1.7;color:var(--text-muted)">${p.deskripsi ?? '-'}</div></div>
            <div class="detail-item full"><div class="detail-label">Alamat</div><div class="detail-value" style="font-weight:400;font-size:13px;">${p.alamat ?? '-'}</div></div>
        `;

        // Buttons
        document.getElementById('btn-detail-approve').onclick = () => { closeModal('modal-detail'); openApprove(id); };
        document.getElementById('btn-detail-reject').onclick  = () => { closeModal('modal-detail'); openReject(id); };

        openModal('modal-detail');
    }

    function openApprove(id) {
        document.getElementById('form-approve').action = `/admin/approval/produk/${id}/approve`;
        openModal('modal-approve');
    }

    function openReject(id) {
        document.getElementById('form-reject').action = `/admin/approval/produk/${id}/reject`;
        openModal('modal-reject');
    }
</script>
@endpush