@extends('layouts.app')

@section('content')

{{-- Header --}}
<section class="bg-gradient-to-br from-primary-dark via-primary to-primary- py-10 text-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-3">
            <a href="{{ route('umkm.pembimbing') }}" class="text-white/80 hover:text-white transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h1 class="font-serif text-2xl font-bold">Profil Mentor</h1>
        </div>
    </div>
</section>

<section class="bg-gray-50 py-12 px-4 min-h-screen">
    <h2 class="font-serif text-center text-2xl font-bold text-gray-900 mb-10">Profil Mentor</h2>

    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- KIRI: Foto & Info Singkat --}}
        <div class="bg-white p-6 rounded-xl shadow-sm">
            <h3 class="text-center font-semibold mb-4">Pembimbing</h3>

            @if($mentor->white_bg_photo)
                <img src="{{ asset('storage/' . $mentor->white_bg_photo) }}"
                     alt="{{ $mentor->full_name ?? $mentor->nama }}"
                     class="rounded-lg w-full object-cover">
            @elseif($mentor->foto)
                <img src="{{ asset('storage/pembimbing/' . $mentor->foto) }}"
                     alt="{{ $mentor->full_name ?? $mentor->nama }}"
                     class="rounded-lg w-full object-cover">
            @else
                <div class="h-64 bg-emerald-50 rounded-lg flex items-center justify-center text-5xl font-bold text-emerald-700">
                    {{ strtoupper(substr($mentor->full_name ?? $mentor->nama ?? 'M', 0, 2)) }}
                </div>
            @endif

            {{-- Bintang Ulasan --}}
            <div class="flex items-center gap-1 mt-4 text-amber-400">
                @for ($i = 1; $i <= 5; $i++)
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                    </svg>
                @endfor
                <span class="text-gray-400 text-xs ml-1">({{ $mentor->ulasan ?? 0 }} Ulasan)</span>
            </div>

            {{-- Lokasi --}}
            @if($mentor->alamat_tampil)
            <div class="flex items-start gap-1.5 mt-3 text-sm text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 110-5 2.5 2.5 0 010 5z"/>
                </svg>
                <span>{{ $mentor->alamat_tampil }}</span>
            </div>
            @endif

            {{-- Telepon --}}
            @if($mentor->phone)
            <div class="flex items-center gap-1.5 mt-2 text-sm text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                <span>{{ $mentor->phone }}</span>
            </div>
            @endif

            {{-- Email --}}
            @if($mentor->email)
            <div class="flex items-center gap-1.5 mt-2 text-sm text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <span class="break-all">{{ $mentor->email }}</span>
            </div>
            @endif

            {{-- Tombol WhatsApp --}}
            @if($mentor->phone)
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $mentor->phone) }}"
               target="_blank"
               class="mt-5 flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold px-4 py-2.5 rounded-lg transition w-full">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
                Hubungi via WhatsApp
            </a>
            @endif
        </div>

        {{-- TENGAH: Profil & Deskripsi --}}
        <div class="bg-white p-6 rounded-xl shadow-sm">
            <p class="text-sm font-semibold text-gray-500">Hai, Saya</p>
            <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $mentor->full_name ?? $mentor->nama }}</h3>

            <div class="inline-block bg-emerald-100 text-emerald-700 text-xs font-bold px-3 py-1 rounded-full uppercase mb-4">
                {{ $mentor->role ?? 'Mentor' }}
            </div>

            <p class="text-sm text-gray-600 leading-relaxed">
                {{ $mentor->bio ?? $mentor->deskripsi ?? 'Belum ada deskripsi.' }}
            </p>
        </div>

        {{-- KANAN: Training --}}
        <div class="bg-white p-6 rounded-xl shadow-sm">
            <h3 class="text-center font-semibold mb-4">Training</h3>

            <div class="space-y-4">
                <div class="bg-gray-100 h-20 rounded-lg flex items-center justify-center text-gray-400 text-xs text-center px-3">
                    Panduan Praktis Membuat Akun UMKM
                </div>

                <div class="bg-gray-100 h-20 rounded-lg flex items-center justify-center text-gray-400 text-xs text-center px-3">
                    Panduan Praktis Membuat IUMK Online
                </div>

                <div class="bg-gray-100 h-20 rounded-lg flex items-center justify-center text-gray-400 text-xs text-center px-3">
                    Panduan Praktis Membuat Akun UMKM
                </div>
            </div>
        </div>

    </div>
</section>

@endsection