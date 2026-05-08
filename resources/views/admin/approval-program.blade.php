@extends('layouts.admin')

@section('page-title', 'Approval Program')

@section('content')

<div class="tab-bar">
    <button class="tab-btn {{ $status === 'pending' ? 'active' : '' }}"
        onclick="location.href='{{ route('admin.approval.program') }}?status=pending'">
        Pending
        @if($counts['pending'] > 0)<span class="count-pill">{{ $counts['pending'] }}</span>@endif
    </button>
    <button class="tab-btn {{ $status === 'approved' ? 'active' : '' }}"
        onclick="location.href='{{ route('admin.approval.program') }}?status=approved'">
        Disetujui
    </button>
    <button class="tab-btn {{ $status === 'rejected' ? 'active' : '' }}"
        onclick="location.href='{{ route('admin.approval.program') }}?status=rejected'">
        Ditolak
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
                <th>Trainer / Pembimbing</th>
                <th>Metode</th>
                <th>Diajukan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($programs as $program)
            <tr>
                <td>
                    <div class="preview-cell">
                        <div class="preview-thumb">🎓</div>
                        <div>
                            <div class="preview-name">{{ $program->judul ?? $program->nama }}</div>
                            <div class="preview-meta">{{ Str::limit($program->deskripsi ?? '', 40) }}</div>
                        </div>
                    </div>
                </td>
                <td>
                    @if($program->trainer)
                    <div class="submitter">
                        <div class="submitter-avatar" style="background:var(--warning)">
                            {{ strtoupper(substr($program->trainer->nama ?? 'T', 0, 2)) }}
                        </div>
                        <div>
                            <div class="submitter-name">{{ $program->trainer->nama ?? '-' }}</div>
                            <div class="submitter-sub">Pembimbing</div>
                        </div>
                    </div>
                    @else
                    <span style="color:var(--text-muted);font-size:12px;">-</span>
                    @endif
                </td>
                <td style="font-size:12px;">{{ $program->metode ?? '-' }}</td>
                <td style="font-size:12px;color:var(--text-muted);">
                    {{ $program->created_at->format('d M Y') }}
                </td>
                <td>
                    @php $st = $program->status ?? 'pending'; @endphp
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
                        <form method="POST" action="{{ route('admin.approval.program.approve', $program->id) }}" style="display:inline;">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-approve btn-sm">✓ Setujui</button>
                        </form>
                        @endif
                        @if($st !== 'rejected')
                        <button class="btn btn-reject btn-sm" onclick="openRejectModal({{ $program->id }})">✕ Tolak</button>
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

{{-- MODAL REJECT --}}
<div class="modal-overlay" id="modal-reject">
    <div class="modal confirm-modal">
        <div class="confirm-icon">❌</div>
        <div class="confirm-title">Tolak Program</div>
        <div class="confirm-desc">Berikan alasan penolakan agar pembimbing dapat merevisi pengajuannya.</div>
        <form id="form-reject" method="POST">
            @csrf
            @method('PATCH')
            <div class="form-group" style="text-align:left;margin-bottom:18px;">
                <label class="form-label">Alasan Penolakan</label>
                <textarea class="form-textarea" name="catatan" placeholder="Contoh: Materi belum lengkap, jadwal konflik..."></textarea>
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
        document.getElementById('form-reject').action = `/admin/approval/program/${id}/reject`;
        openModal('modal-reject');
    }
</script>
@endpush