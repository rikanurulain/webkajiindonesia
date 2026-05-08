{{-- resources/views/profile/activity.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-10">
<div class="mx-auto max-w-2xl px-4 sm:px-6">

    {{-- Tombol kembali ke beranda --}}
    <a href="{{ url('/') }}"
       class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-800 transition-colors mb-6">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali ke beranda
    </a>

    {{-- Stat cards -- horizontal sejajar --}}
    <div class="flex gap-3 mb-5">
        <div class="flex-1 bg-white rounded-2xl border border-gray-100 shadow-sm px-4 py-4 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                </svg>
            </div>
            <div>
                <p class="text-xl font-bold text-blue-600 leading-none">{{ $stats['total_login'] }}</p>
                <p class="text-xs text-gray-400 mt-1">Total Login</p>
            </div>
        </div>

        <div class="flex-1 bg-white rounded-2xl border border-gray-100 shadow-sm px-4 py-4 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <div>
                <p class="text-xl font-bold text-emerald-600 leading-none">{{ $stats['total_profile'] }}</p>
                <p class="text-xs text-gray-400 mt-1">Edit Profil</p>
            </div>
        </div>

        <div class="flex-1 bg-white rounded-2xl border border-gray-100 shadow-sm px-4 py-4 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-violet-50 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <p class="text-xl font-bold text-violet-600 leading-none">{{ $stats['days_joined'] }}</p>
                <p class="text-xs text-gray-400 mt-1">Hari Bergabung</p>
            </div>
        </div>
    </div>

    {{-- Daftar aktivitas --}}
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">

        <div class="px-6 pt-6 pb-4 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h2 class="text-sm font-bold text-gray-900">Riwayat Aktivitas</h2>
                <p class="text-xs text-gray-400 mt-0.5">Aktivitas yang tercatat pada akun Anda</p>
            </div>
            <span class="text-xs text-gray-400 bg-gray-100 rounded-full px-3 py-1 font-medium">30 hari</span>
        </div>

        {{-- Filter tabs --}}
        <div class="px-6 py-3 border-b border-gray-100 flex gap-2 flex-wrap">
            @php
                $filters = [
                    'semua'    => 'Semua',
                    'login'    => 'Login',
                    'logout'   => 'Logout',
                    'profile'  => 'Profil',
                    'password' => 'Password',
                    'photo'    => 'Foto',
                ];
                $activeFilter = request('filter', 'semua');
            @endphp
            @foreach($filters as $key => $label)
                <a href="{{ route('profile.activity', array_merge(request()->query(), ['filter' => $key])) }}"
                   class="text-xs px-3 py-1.5 rounded-full border transition-colors
                          {{ $activeFilter === $key
                              ? 'bg-gray-900 text-white border-gray-900'
                              : 'border-gray-200 text-gray-500 hover:border-gray-400 hover:text-gray-700' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        @php
            $typeConf = [
                'login'    => ['bg' => 'bg-blue-50',    'icon_color' => 'text-blue-500',    'icon' => 'M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1'],
                'logout'   => ['bg' => 'bg-gray-100',   'icon_color' => 'text-gray-500',    'icon' => 'M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1'],
                'profile'  => ['bg' => 'bg-emerald-50', 'icon_color' => 'text-emerald-500', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                'password' => ['bg' => 'bg-amber-50',   'icon_color' => 'text-amber-500',   'icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z'],
                'photo'    => ['bg' => 'bg-violet-50',  'icon_color' => 'text-violet-500',  'icon' => 'M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z M15 13a3 3 0 11-6 0 3 3 0 016 0z'],
            ];
        @endphp

        <div class="divide-y divide-gray-50">
            @forelse($activities as $act)
                @php $conf = $typeConf[$act->type] ?? $typeConf['login']; @endphp
                <div class="flex items-start gap-4 px-6 py-4 hover:bg-gray-50/60 transition-colors duration-150">

                    <div class="w-9 h-9 rounded-xl {{ $conf['bg'] }} flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-4 h-4 {{ $conf['icon_color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $conf['icon'] }}"/>
                        </svg>
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2">
                            <p class="text-sm font-medium text-gray-800">{{ $act->label }}</p>
                            @if(!$act->is_success)
                                <span class="inline-flex items-center rounded-full bg-red-50 px-2 py-0.5 text-xs font-medium text-red-600 ring-1 ring-red-200">Gagal</span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-medium text-emerald-600 ring-1 ring-emerald-200">Berhasil</span>
                            @endif
                        </div>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $act->description ?: $act->getDeviceLabel() }}</p>
                        <p class="text-xs text-gray-300 mt-0.5">IP: {{ $act->ip_address ?? '-' }}</p>
                    </div>

                    <div class="text-right shrink-0">
                        <p class="text-xs text-gray-400">{{ $act->created_at->locale('id')->diffForHumans() }}</p>
                        <p class="text-xs text-gray-300 mt-0.5">{{ $act->created_at->format('d M Y') }}</p>
                    </div>
                </div>
            @empty
                <div class="px-6 py-12 text-center">
                    <svg class="w-10 h-10 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <p class="text-sm text-gray-400">Tidak ada aktivitas ditemukan</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($activities->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $activities->links() }}
            </div>
        @endif
    </div>

    {{-- Warning --}}
    <div class="mt-4 flex items-start gap-3 rounded-2xl bg-amber-50 border border-amber-100 px-5 py-4">
        <svg class="w-5 h-5 text-amber-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
        </svg>
        <div>
            <p class="text-sm font-semibold text-amber-800">Ada aktivitas mencurigakan?</p>
            <p class="text-xs text-amber-700 mt-0.5">
                Segera <a href="{{ route('profile.password') }}" class="font-semibold underline">ubah password</a> dan hubungi tim kami.
            </p>
        </div>
    </div>

</div>
</div>
@endsection