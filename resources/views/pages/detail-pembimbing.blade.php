@extends('layouts.app')

@section('content')
    <section class="bg-gradient-to-br from-primary-dark via-primary to-primary- py-16 text-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-8">
            <!-- TEXT -->
            <div class="max-w-2xl">
                <h1 class="font-serif text-4xl font-bold sm:text-5xl">
                    UMKM KARYA KAMI
                </h1>
                <p class="mt-4 text-lg text-white/90">
                    Pendampingan dan penguatan kapasitas usaha mikro, kecil, dan menengah.
                </p>
            </div>

            <!-- IMAGE -->
            <div>
                <img src="{{ asset('images/KARYAKAMI.png') }}"
                     alt="Logo Karya Kami"
                     class="w-64 md:w-80 object-contain">
            </div>
        </div>
    </section>

<section class="bg-gray-100 py-16">
    <h2 class="text-center text-2xl font-bold mb-10">Profil Pendamping</h2>

    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- KIRI (FOTO) -->
        <div class="bg-white p-6 rounded-xl ">
            <h3 class="text-center font-semibold mb-4">Pebimbing</h3>

            @if($p->foto)
                <img src="{{ asset('storage/pendamping/' . $p->foto) }}" class="rounded-lg w-full object-cover">
            @else
                <div class="h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5.121 17.804A9 9 0 1112 21a9 9 0 01-6.879-3.196z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
            @endif

            {{-- Ulasan --}}
            <div class="flex items-center gap-1 mt-4 text-grey-100">
                @for ($i = 1; $i <= 5; $i++)
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                    </svg>
                @endfor
                <span class="text-gray-400 text-xs ml-1">({{ $p->ulasan }} Ulasan)</span>
            </div>

            {{-- Lokasi --}}
            <div class="flex items-center gap-1 mt-2 text-sm text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 110-5 2.5 2.5 0 010 5z"/>
                </svg>
                {{ $p->lokasi ?? 'Lokasi belum diisi' }}
            </div>
        </div>

        <!-- TENGAH (PROFIL) -->
        <div class="bg-white p-6 rounded-xl ">
            <p class="text-sm font-semibold">Hai, Saya</p>
            <h3 class="text-xl font-bold mb-4">{{ $p->nama }}</h3>

            <p class="text-sm text-gray-600">
                {{ $p->deskripsi ?? 'Belum ada deskripsi.' }}
            </p>
        </div>

        <!-- KANAN (TRAINING) -->
        <div class="bg-white p-6 rounded-xl ">
            <h3 class="text-center font-semibold mb-4">Training</h3>

            <div class="space-y-4">

                <div class="bg-gray-300 h-20"></div>
                <p class="text-sm text-center">Panduan Praktis Membuat Akun UMKM</p>

                <div class="bg-gray-300 h-20"></div>
                <p class="text-sm text-center">Panduan Praktis Membuat IUMK Online</p>

                <div class="bg-gray-300 h-20"></div>
                <p class="text-sm text-center">Panduan Praktis Membuat Akun UMKM</p>

            </div>
        </div>

    </div>
</section>

@endsection