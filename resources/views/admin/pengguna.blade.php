@extends('layouts.admin')

@section('page-title', 'Manajemen Pengguna')

@section('content')

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;">
    <div class="section-title">
        Semua Pengguna
        <small>{{ $users->total() }} terdaftar</small>
    </div>

    {{-- Filter Role --}}
    <div style="display:flex;gap:8px;align-items:center;">
        <form method="GET" style="display:flex;gap:8px;">
            <select name="role" class="form-select" style="width:auto;padding:7px 12px;"
                onchange="this.form.submit()">
                <option value="admin"      {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
<option value="trainer"    {{ request('role') === 'trainer' ? 'selected' : '' }}>Trainer</option>
<option value="pembimbing" {{ request('role') === 'pembimbing' ? 'selected' : '' }}>Pembimbing</option>
<option value="mentor"     {{ request('role') === 'mentor' ? 'selected' : '' }}>Mentor</option>
<option value="umkm"       {{ request('role') === 'umkm' ? 'selected' : '' }}>UMKM</option>
<option value="umum"       {{ request('role') === 'umum' ? 'selected' : '' }}>Umum</option>
            </select>
        </form>
    </div>
</div>

<div class="table-card">
    <table>
        <thead>
            <tr>
                <th>Pengguna</th>
                <th>Role</th>
                <th>Email</th>
                <th>Kota</th>
                <th>Bergabung</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td>
                    <div class="submitter">
                        <div class="submitter-avatar"
                            style="background:{{ ['var(--accent)','var(--accent3)','var(--warning)','#8b5cf6','#ec4899'][$loop->index % 5] }}">
                            @if($user->profile_photo_path)
                                <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="avatar"
                                    style="width:100%;height:100%;object-fit:cover;border-radius:7px;">
                            @else
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            @endif
                        </div>
                        <div>
                            <div class="submitter-name">{{ $user->name }}</div>
                            <div class="submitter-sub">{{ $user->phone ?? 'Belum ada nomor' }}</div>
                        </div>
                    </div>
                </td>
                <td>
                @if($user->role === 'admin')
    <span class="role-tag role-admin">Admin</span>
@elseif($user->role === 'trainer' || $user->role === 'pembimbing' || $user->is_pembimbing)
    <span class="role-tag role-pembimbing">Trainer / Pembimbing</span>
@elseif($user->role === 'mentor')
    <span class="role-tag" style="background:#f3e8ff;color:#7e22ce;border:1px solid #e9d5ff;">Mentor</span>
@elseif($user->role === 'umkm' || $user->is_umkm)
    <span class="role-tag role-umkm">UMKM</span>
@else
    <span class="role-tag role-user">Umum</span>
@endif
                </td>
                <td style="font-size:12px;color:var(--text-muted);">{{ $user->email }}</td>
                <td style="font-size:12px;">{{ Str::limit($user->address ?? '-', 18) }}</td>
                <td style="font-size:12px;color:var(--text-muted);">
                    {{ $user->created_at->format('M Y') }}
                </td>
                <td>
                    @if(!$user->suspended_at)
                        <span class="badge badge-active"><span class="badge-dot"></span>Aktif</span>
                    @else
                        <span class="badge badge-inactive"><span class="badge-dot"></span>Suspend</span>
                    @endif
                </td>
                <td>
                    <div class="action-group">
                        <button class="btn btn-ghost btn-sm" onclick="openUserDetail({{ $user->id }})">
                            Kelola
                        </button>
                        @if(!$user->suspended_at && $user->role !== 'admin')
                        <form method="POST" action="{{ route('admin.pengguna.suspend', $user->id) }}" style="display:inline;"
                            onsubmit="return confirm('Yakin ingin suspend pengguna ini?')">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-reject btn-sm">Suspend</button>
                        </form>
                        @elseif($user->suspended_at)
                        <form method="POST" action="{{ route('admin.pengguna.unsuspend', $user->id) }}" style="display:inline;">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-approve btn-sm">Aktifkan</button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7">
                    <div class="empty-state">
                        <div class="empty-state-icon">👥</div>
                        <div class="empty-state-text">Tidak ada pengguna ditemukan</div>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- ── Custom Pagination ── --}}
    @if($users->hasPages())
    <div style="padding:14px 18px;border-top:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;gap:12px;">

        {{-- Info --}}
        <div style="font-size:12px;color:var(--text-muted);white-space:nowrap;">
            Menampilkan
            <span style="font-weight:700;color:var(--text);">{{ $users->firstItem() }}–{{ $users->lastItem() }}</span>
            dari
            <span style="font-weight:700;color:var(--text);">{{ $users->total() }}</span>
            data
        </div>

        {{-- Navigasi --}}
        <div style="display:flex;align-items:center;gap:6px;">

            {{-- Prev --}}
            @if($users->onFirstPage())
                <span style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:8px;font-size:12px;font-weight:600;background:var(--surface2);color:var(--text-muted);border:1px solid var(--border);cursor:not-allowed;opacity:0.45;user-select:none;">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                    Prev
                </span>
            @else
                <a href="{{ $users->previousPageUrl() }}&{{ http_build_query(request()->except('page')) }}"
                   style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:8px;font-size:12px;font-weight:600;background:var(--surface);color:var(--text);border:1px solid var(--border);text-decoration:none;transition:all 0.15s;"
                   onmouseover="this.style.background='var(--accent)';this.style.color='#fff';this.style.borderColor='var(--accent)';"
                   onmouseout="this.style.background='var(--surface)';this.style.color='var(--text)';this.style.borderColor='var(--border)';">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                    Prev
                </a>
            @endif

            {{-- Nomor Halaman --}}
            @foreach($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                @if($page == $users->currentPage())
                    <span style="display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;border-radius:8px;font-size:12px;font-weight:700;background:var(--accent);color:#fff;border:1px solid var(--accent);box-shadow:0 2px 8px rgba(0,0,0,0.15);user-select:none;">
                        {{ $page }}
                    </span>
                @elseif($page == 1 || $page == $users->lastPage() || abs($page - $users->currentPage()) <= 1)
                    <a href="{{ $url }}&{{ http_build_query(request()->except('page')) }}"
                       style="display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;border-radius:8px;font-size:12px;font-weight:600;background:var(--surface);color:var(--text);border:1px solid var(--border);text-decoration:none;transition:all 0.15s;"
                       onmouseover="this.style.background='var(--surface2)';this.style.borderColor='var(--accent)';"
                       onmouseout="this.style.background='var(--surface)';this.style.borderColor='var(--border)';">
                        {{ $page }}
                    </a>
                @elseif(abs($page - $users->currentPage()) == 2)
                    <span style="display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;font-size:12px;color:var(--text-muted);user-select:none;">···</span>
                @endif
            @endforeach

            {{-- Next --}}
            @if($users->hasMorePages())
                <a href="{{ $users->nextPageUrl() }}&{{ http_build_query(request()->except('page')) }}"
                   style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:8px;font-size:12px;font-weight:600;background:var(--surface);color:var(--text);border:1px solid var(--border);text-decoration:none;transition:all 0.15s;"
                   onmouseover="this.style.background='var(--accent)';this.style.color='#fff';this.style.borderColor='var(--accent)';"
                   onmouseout="this.style.background='var(--surface)';this.style.color='var(--text)';this.style.borderColor='var(--border)';">
                    Next
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            @else
                <span style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:8px;font-size:12px;font-weight:600;background:var(--surface2);color:var(--text-muted);border:1px solid var(--border);cursor:not-allowed;opacity:0.45;user-select:none;">
                    Next
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </span>
            @endif

        </div>
    </div>
    @endif
    {{-- ── End Pagination ── --}}

</div>

{{-- MODAL DETAIL USER --}}
<div class="modal-overlay" id="modal-user-detail">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">Detail Pengguna</div>
            <button class="modal-close" onclick="closeModal('modal-user-detail')">×</button>
        </div>
        <div id="user-detail-body">
            {{-- Diisi via JS --}}
        </div>
        <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:16px;">
            <button class="btn btn-ghost" onclick="closeModal('modal-user-detail')">Tutup</button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    const usersData = @json($users->items());

    function openUserDetail(id) {
        const u = usersData.find(x => x.id === id);
        if (!u) return;

        const roleName = u.role === 'admin' ? 'Admin'
    : (u.role === 'trainer' || u.role === 'pembimbing' || u.is_pembimbing) ? 'Trainer / Pembimbing'
    : u.role === 'mentor' ? 'Mentor'
    : (u.role === 'umkm' || u.is_umkm) ? 'UMKM'
    : 'Umum';
        const initials = u.name.substring(0, 2).toUpperCase();
        const avatarColors = ['var(--accent)','var(--accent3)','var(--warning)','#8b5cf6','#ec4899'];
        const color = avatarColors[id % 5];

        document.getElementById('user-detail-body').innerHTML = `
            <div style="display:flex;align-items:center;gap:14px;background:var(--surface2);border-radius:14px;padding:16px;margin-bottom:18px;border:1px solid var(--border);">
                <div style="width:56px;height:56px;border-radius:13px;background:${color};display:flex;align-items:center;justify-content:center;font-size:20px;font-weight:700;color:#fff;flex-shrink:0;">
                    ${initials}
                </div>
                <div>
                    <div style="font-size:17px;font-weight:700;">${u.name}</div>
                    <div style="font-size:12px;color:var(--text-muted);margin-top:2px;">${u.email}</div>
                </div>
            </div>
            <div class="detail-grid">
                <div class="detail-item"><div class="detail-label">Role</div><div class="detail-value">${roleName}</div></div>
                <div class="detail-item"><div class="detail-label">No. Telepon</div><div class="detail-value">${u.phone ?? '-'}</div></div>
                <div class="detail-item full"><div class="detail-label">Alamat</div><div class="detail-value" style="font-weight:400;font-size:13px;">${u.address ?? '-'}</div></div>
                <div class="detail-item full"><div class="detail-label">Bio</div><div class="detail-value" style="font-weight:400;font-size:13px;color:var(--text-muted);line-height:1.6;">${u.bio ?? 'Belum ada bio'}</div></div>
                <div class="detail-item"><div class="detail-label">Member UMKM</div><div class="detail-value">${u.is_umkm ? '✅ Aktif' : '—'}</div></div>
                <div class="detail-item"><div class="detail-label">Member Pembimbing</div><div class="detail-value">${u.is_pembimbing ? '✅ Aktif' : '—'}</div></div>
            </div>
        `;

        openModal('modal-user-detail');
    }
</script>
@endpush