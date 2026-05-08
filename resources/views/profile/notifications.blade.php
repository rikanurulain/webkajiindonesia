{{-- resources/views/profile/notifications.blade.php --}}
@extends('layouts.app')

@section('content')
<style>
.notif-toggle { position: relative; width: 44px; height: 24px; flex-shrink: 0; cursor: pointer; display: inline-block; }
.notif-toggle input { opacity: 0; width: 0; height: 0; position: absolute; }
.notif-track { position: absolute; inset: 0; border-radius: 999px; background: #D1D5DB; transition: background 0.25s cubic-bezier(.4,0,.2,1); }
.notif-thumb { position: absolute; top: 3px; left: 3px; width: 18px; height: 18px; border-radius: 50%; background: #fff; box-shadow: 0 1px 3px rgba(0,0,0,.18); transition: transform 0.25s cubic-bezier(.4,0,.2,1); }
.notif-toggle input:checked ~ .notif-track { background: #16a34a; }
.notif-toggle input:checked ~ .notif-thumb { transform: translateX(20px); }
.notif-toggle.blue  input:checked ~ .notif-track { background: #16a34a; }
.notif-toggle.amber input:checked ~ .notif-track { background: #16a34a; }
.notif-toggle.violet input:checked ~ .notif-track { background: #16a34a; }
.notif-toggle.rose  input:checked ~ .notif-track { background: #16a34a; }
</style>

<div class="min-h-screen bg-gray-50 py-10">
<div class="mx-auto max-w-2xl px-4 sm:px-6">

    <a href="{{ url('/') }}"
       class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-800 transition-colors mb-6">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali ke beranda
    </a>

    @if(session('success'))
        <div class="mb-5 flex items-center gap-3 rounded-2xl bg-emerald-50 border border-emerald-200 px-4 py-3 text-sm text-emerald-700">
            <svg class="w-5 h-5 shrink-0 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('profile.notifications.update') }}">
        @csrf
        @method('PATCH')

        {{-- Header --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm px-5 py-4 mb-4 flex items-center gap-4">
            <div class="w-11 h-11 rounded-2xl bg-emerald-50 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-900">Pengaturan Notifikasi</p>
                <p class="text-xs text-gray-400 mt-0.5">Kelola notifikasi yang ingin Anda terima</p>
            </div>
        </div>

        {{-- Notifikasi Email --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden mb-4">
            <div class="px-5 pt-5 pb-4 border-b border-gray-100 flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-blue-50 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-900">Notifikasi Email</p>
                    <p class="text-xs text-gray-400 mt-0.5">Dikirim ke {{ Auth::user()->email }}</p>
                </div>
            </div>

            @php
                $user = Auth::user();
                $emailItems = [
                    ['key' => 'notif_email_pelatihan',  'label' => 'Info Pelatihan',  'desc' => 'Jadwal, program baru, dan pengumuman pelatihan',     'icon_bg' => 'bg-blue-50',    'icon_color' => 'text-blue-500',    'toggle_class' => 'blue',   'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'val' => $user->notif_email_pelatihan ?? 1],
                    ['key' => 'notif_email_umkm',       'label' => 'Info UMKM',       'desc' => 'Update produk, pendampingan, dan info UMKM',           'icon_bg' => 'bg-emerald-50', 'icon_color' => 'text-emerald-500', 'toggle_class' => '',        'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4', 'val' => $user->notif_email_umkm ?? 1],
                    ['key' => 'notif_email_halal',      'label' => 'Halal Center',    'desc' => 'Status sertifikasi dan info layanan halal',             'icon_bg' => 'bg-amber-50',   'icon_color' => 'text-amber-500',   'toggle_class' => 'amber',  'icon' => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z', 'val' => $user->notif_email_halal ?? 1],
                    ['key' => 'notif_email_newsletter', 'label' => 'Newsletter',      'desc' => 'Berita dan artikel terbaru dari Kaji Indonesia',        'icon_bg' => 'bg-violet-50',  'icon_color' => 'text-violet-500',  'toggle_class' => 'violet', 'icon' => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z', 'val' => $user->notif_email_newsletter ?? 0],
                ];
            @endphp

            <div class="divide-y divide-gray-50">
                @foreach($emailItems as $item)
                    <div class="flex items-center justify-between px-5 py-4 hover:bg-gray-50/60 transition-colors duration-150">
                        <div class="flex items-center gap-3 flex-1 min-w-0 pr-4">
                            <div class="w-8 h-8 rounded-xl {{ $item['icon_bg'] }} flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 {{ $item['icon_color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-800">{{ $item['label'] }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $item['desc'] }}</p>
                            </div>
                        </div>
                        <label class="notif-toggle {{ $item['toggle_class'] }}">
                            <input type="checkbox" name="{{ $item['key'] }}" value="1" {{ $item['val'] ? 'checked' : '' }}>
                            <div class="notif-track"></div>
                            <div class="notif-thumb"></div>
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Notifikasi Browser --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden mb-4">
            <div class="px-5 pt-5 pb-4 border-b border-gray-100 flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-rose-50 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-900">Notifikasi Browser</p>
                    <p class="text-xs text-gray-400 mt-0.5">Push notification langsung di browser Anda</p>
                </div>
            </div>
            <div class="flex items-center justify-between px-5 py-4 hover:bg-gray-50/60 transition-colors duration-150">
                <div class="flex items-center gap-3 flex-1 min-w-0 pr-4">
                    <div class="w-8 h-8 rounded-xl bg-rose-50 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-800">Aktifkan notifikasi browser</p>
                        <p class="text-xs text-gray-400 mt-0.5">Terima pemberitahuan real-time saat ada info baru</p>
                    </div>
                </div>
                <label class="notif-toggle rose">
                    <input type="checkbox" name="notif_browser" value="1" {{ ($user->notif_browser ?? 0) ? 'checked' : '' }}>
                    <div class="notif-track"></div>
                    <div class="notif-thumb"></div>
                </label>
            </div>
        </div>

        {{-- Info --}}
        <div class="flex items-start gap-3 rounded-2xl bg-blue-50 border border-blue-100 px-5 py-4 mb-5">
            <svg class="w-5 h-5 text-blue-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-xs text-blue-700">
                Notifikasi terkait keamanan akun (login, ubah password) akan selalu dikirim dan tidak dapat dinonaktifkan.
            </p>
        </div>

        {{-- Tombol simpan --}}
        <div class="flex justify-end">
            <button type="submit"
                    class="inline-flex items-center gap-2 rounded-xl bg-primary px-6 py-2.5 text-sm font-semibold text-white hover:bg-primary/90 transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Simpan Pengaturan
            </button>
        </div>

    </form>
</div>
</div>
@endsection