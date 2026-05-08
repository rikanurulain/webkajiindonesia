@extends('layouts.admin')

@section('page-title', 'Pembimbing & Trainer')

@section('content')

<div class="section-header">
    <div class="section-title">
        Daftar Pembimbing / Trainer
        <small>{{ $trainers->total() }} terdaftar</small>
    </div>
</div>

<div class="table-card">
    <table>
        <thead>
            <tr>
                <th>Trainer</th>
                <th>Role / Spesialisasi</th>
                <th>Lokasi</th>
                <th>Ulasan</th>
                <th>Terdaftar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($trainers as $trainer)
            <tr>
                <td>
                    <div class="submitter">
                        <div class="submitter-avatar" style="background:var(--warning);overflow:hidden;">
                            @if($trainer->foto)
                                <img src="{{ asset('storage/' . $trainer->foto) }}" alt="{{ $trainer->nama }}"
                                    style="width:100%;height:100%;object-fit:cover;border-radius:7px;">
                            @else
                                {{ strtoupper(substr($trainer->nama, 0, 2)) }}
                            @endif
                        </div>
                        <div>
                            <div class="submitter-name">{{ $trainer->nama }}</div>
                            <div class="submitter-sub">{{ $trainer->role ?? 'Pembimbing' }}</div>
                        </div>
                    </div>
                </td>
                <td style="font-size:12px;">{{ $trainer->role ?? '-' }}</td>
                <td style="font-size:12px;color:var(--text-muted);">{{ $trainer->lokasi ?? '-' }}</td>
                <td>
                    <span style="font-size:13px;font-weight:600;">
                        ⭐ {{ $trainer->ulasan ?? 0 }}
                    </span>
                </td>
                <td style="font-size:12px;color:var(--text-muted);">
                    {{ $trainer->created_at->format('d M Y') }}
                </td>
                <td>
                    <div class="action-group">
                        <a href="{{ route('pelatihan.pembimbing.detail', $trainer->id) }}"
                           target="_blank" class="btn btn-ghost btn-sm">
                            Lihat Profil
                        </a>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6">
                    <div class="empty-state">
                        <div class="empty-state-icon">🎓</div>
                        <div class="empty-state-text">Belum ada trainer terdaftar</div>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($trainers->hasPages())
    <div style="padding:14px 18px;border-top:1px solid var(--border);display:flex;justify-content:flex-end;">
        {{ $trainers->links() }}
    </div>
    @endif
</div>

@endsection