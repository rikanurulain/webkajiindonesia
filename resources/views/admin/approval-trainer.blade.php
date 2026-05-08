@extends('layouts.admin')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Approval Trainer</h2>
            <p class="text-sm text-gray-500">Kelola dan verifikasi pendaftaran trainer baru.</p>
        </div>
        <div class="flex gap-2">
            <span class="bg-amber-100 text-amber-700 px-3 py-1 rounded-full text-xs font-bold">Pending: {{ $counts['pending'] }}</span>
        </div>
    </div>
    //tab
    <div class="tab-bar mb-6">
    <button class="tab-btn {{ $status === 'pending' ? 'active' : '' }}"
        onclick="location.href='{{ route('admin.approval.trainer') }}?status=pending'">
        Pending
        @if($counts['pending'] > 0)
            <span class="count-pill">{{ $counts['pending'] }}</span>
        @endif
    </button>
    
    <button class="tab-btn {{ $status === 'approved' ? 'active' : '' }}"
        onclick="location.href='{{ route('admin.approval.trainer') }}?status=approved'">
        Disetujui
    </button>
    
    <button class="tab-btn {{ $status === 'rejected' ? 'active' : '' }}"
        onclick="location.href='{{ route('admin.approval.trainer') }}?status=rejected'">
        Ditolak
    </button>
</div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50/50 border-b">
                <tr class="text-gray-500 text-xs uppercase tracking-wider">
                    <th class="p-6">Calon Trainer</th>
                    <th class="p-6">Detail & Dokumen</th>
                    <th class="p-6">Pengalaman</th>
                    <th class="p-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($applicants as $user)
                <tr class="hover:bg-gray-50/50 transition-all duration-200">
                    <td class="p-6">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-emerald-100 text-emerald-700 rounded-2xl flex items-center justify-center font-bold shadow-sm">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </div>
                            <div>
                                <p class="font-bold text-gray-800">{{ $user->academic_degree ?? $user->name }}</p>
                                <p class="text-xs text-gray-500">NIK: {{ $user->nik }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="p-6">
                        <div class="space-y-2">
                            <div class="flex gap-2">
                                @if($user->ktp_scan)
                                    @php $ktpPath = str_replace('public/', '', $user->ktp_scan); @endphp
                                    <a href="{{ asset('storage/' . $ktpPath) }}" target="_blank" class="text-[10px] bg-blue-50 text-blue-600 px-2 py-1 rounded-lg border border-blue-100 hover:bg-blue-100 transition-all">Lihat KTP</a>
                                @endif
                                @if($user->bnsp_certificate)
                                    @php $bnspPath = str_replace('public/', '', $user->bnsp_certificate); @endphp
                                    <a href="{{ asset('storage/' . $bnspPath) }}" target="_blank" class="text-[10px] bg-purple-50 text-purple-600 px-2 py-1 rounded-lg border border-purple-100 hover:bg-purple-100 transition-all">Sertifikat BNSP</a>
                                @endif
                            </div>
                            <a href="{{ $user->drive_link_documentation }}" target="_blank" class="text-[10px] text-emerald-600 underline font-medium hover:text-emerald-700 block">Link Drive Dokumentasi</a>
                        </div>
                    </td>
                    <td class="p-6 text-sm text-gray-600 leading-relaxed italic">
                        "{{ Str::limit($user->experience, 100) }}"
                    </td>
                    <td class="p-6">
                        @if($user->trainer_status == 'pending')
                        <div class="flex flex-row gap-2 justify-center">
                            <form action="{{ route('admin.trainer.approve', $user->id) }}" method="POST" onsubmit="return confirm('Setujui pendaftar ini sebagai Trainer?')">
                                @csrf
                                <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-emerald-700 transition shadow-sm active:scale-95">Setujui</button>
                            </form>
                            <form action="{{ route('admin.trainer.reject', $user->id) }}" method="POST" onsubmit="return confirm('Tolak pendaftaran ini?')">
                                @csrf
                                <button type="submit" class="bg-white text-red-600 border border-red-100 px-4 py-2 rounded-xl text-xs font-bold hover:bg-red-50 transition active:scale-95">Tolak</button>
                            </form>
                        </div>
                        @else
                            <div class="flex justify-center">
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $user->trainer_status == 'approved' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $user->trainer_status }}
                                </span>
                            </div>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-20 text-center">
                        <p class="text-gray-400 italic">Tidak ada data pengajuan trainer.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $applicants->links() }}
    </div>
</div>
@endsection