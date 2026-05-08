@extends('layouts.admin')

@section('page-title', 'Approval Event')

@section('content')

<div class="tab-bar">
    <button class="tab-btn {{ $status === 'pending' ? 'active' : '' }}"
        onclick="location.href='{{ route('admin.approval.event') }}?status=pending'">
        Pending
        @if($counts['pending'] > 0)<span class="count-pill">{{ $counts['pending'] }}</span>@endif
    </button>
    <button class="tab-btn {{ $status === 'approved' ? 'active' : '' }}"
        onclick="location.href='{{ route('admin.approval.event') }}?status=approved'">
        Disetujui
    </button>
    <button class="tab-btn {{ $status === 'rejected' ? 'active' : '' }}"
        onclick="location.href='{{ route('admin.approval.event') }}?status=rejected'">
        Ditolak
    </button>
</div>

<div class="table-card">
    <div class="table-card-header">
        <div class="table-card-title">
            🗓️ Daftar Event
            <span class="table-card-subtitle">{{ $events->total() }} event</span>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Event</th>
                <th>Pembimbing</th>
                <th>Lokasi</th>
                <th>Tanggal Pelaksanaan</th>
                <th>Kapasitas</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($events as $event)
            <tr>
                <td>
                    <div class="preview-cell">
                        <div class="preview-thumb">🏪</div>
                        <div>
                            <div class="preview-name">{{ $event->judul ?? $event->nama }}</div>
                            <div class="preview-meta">{{ Str::limit($event->deskripsi ?? '', 36) }}</div>
                        </div>
                    </div>
                </td>
                <td>
                    @if($event->trainer)
                    <div class="submitter">
                        <div class="submitter-avatar" style="background:var(--accent)">
                            {{ strtoupper(substr($event->trainer->nama ?? 'T', 0, 2)) }}
                        </div>
                        <div class="submitter-name">{{ $event->trainer->nama ?? '-' }}</div>
                    </div>
                    @else
                        <span style="color:var(--text-muted);font-size:12px;">-</span>
                    @endif
                </td>
                <td style="font-size:12px;">{{ $event->lokasi ?? '-' }}</td>
                <td style="font-size:12px;color:var(--text-muted);">
                    @if($event->tanggal)
                        {{ \Carbon\Carbon::parse($event->tanggal)->format('d M Y') }}
                    @else
                        -
                    @endif
                </td>
                <td style="font-size:12px;">{{ $event->kapasitas ? $event->kapasitas . ' orang' : '-' }}</td>
                <td>
                    @php $st = $event->status ?? 'pending'; @endphp
                    @if($st === 'approved')
                        <span class="badge badge-approved"><span class="badge-dot"></span>Disetujui</span>
                    @elseif($st === 'rejected')
                        <span class="badge badge-rejected"><span class="badge-dot"></span>Ditolak</span>
                    @else
                        <span class="badge badge-pending"><span class="badge-dot"></span>Pending</span>
                    @endif
                </td>
                <td>
                    <div class="action-group">
                        @if($st !== 'approved')
                        <form method="POST" action="{{ route('admin.approval.event.approve', $event->id) }}" style="display:inline;">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-approve btn-sm">✓ Setujui</button>
                        </form>
                        @endif
                        @if($st !== 'rejected')
                        <button class="btn btn-reject btn-sm" onclick="openRejectModal({{ $event->id }})">✕ Tolak</button>
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

    @if($events->hasPages())
    <div style="padding:14px 18px;border-top:1px solid var(--border);display:flex;justify-content:flex-end;">
        {{ $events->withQueryString()->links() }}
    </div>
    @endif
</div>

{{-- MODAL REJECT --}}
<div class="modal-overlay" id="modal-reject">
    <div class="modal confirm-modal">
        <div class="confirm-icon">❌</div>
        <div class="confirm-title">Tolak Event</div>
        <div class="confirm-desc">Berikan alasan penolakan agar pembimbing dapat merevisi pengajuannya.</div>
        <form id="form-reject" method="POST">
            @csrf
            @method('PATCH')
            <div class="form-group" style="text-align:left;margin-bottom:18px;">
                <label class="form-label">Alasan Penolakan</label>
                <textarea class="form-textarea" name="catatan" placeholder="Contoh: Lokasi tidak tersedia, kapasitas berlebihan..."></textarea>
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
    function openRejectModal(id) {
        document.getElementById('form-reject').action = `/admin/approval/event/${id}/reject`;
        openModal('modal-reject');
    }
</script>
@endpush