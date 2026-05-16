{{-- resources/views/pages/pelatihan-event.blade.php --}}
@extends('layouts.app')

@section('title', 'Event Pelatihan - KAJI INDONESIA')

@section('content')

    {{-- Hero --}}
    <section class="bg-gradient-to-br from-primary-dark via-primary to-primary- py-16 text-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="max-w-2xl">
                <h1 class="font-serif text-4xl font-bold sm:text-5xl">
                    EVENT KAMI LATIH
                </h1>
                <p class="mt-4 text-lg text-white/90">
                    Workshop dan seminar untuk pengembangan kapasitas UMKM.
                </p>
            </div>
            <div>
                <img src="{{ asset('storage/logo/KAMILATIH.png') }}"
                     alt="Logo Karya Kami"
                     class="w-64 md:w-80 object-contain">
            </div>
        </div>
    </section>

    <section class="bg-gray-50 py-16 px-6 min-h-screen">

        @if($events->isEmpty())
            {{-- Kosong --}}
            <div class="max-w-lg mx-auto text-center py-24">
                <div class="text-6xl mb-4">🎉</div>
                <h2 class="text-xl font-bold text-gray-700 mb-2">Belum Ada Event</h2>
                <p class="text-gray-500 text-sm">Event akan segera hadir. Pantau terus halaman ini!</p>
            </div>
        @else
            <h2 class="font-serif text-center text-3xl font-bold text-gray-900 sm:text-4xl mb-10">
                Event Pelatihan UMKM
            </h2>

            <div class="max-w-6xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($events as $item)
                    <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-200 flex flex-col duration-300 hover:shadow-lg hover:-translate-y-1">

                        {{-- Gambar / Placeholder --}}
                        @if($item->gambar)
                            <img src="{{ asset('storage/' . $item->gambar) }}"
                                 alt="{{ $item->judul }}"
                                 class="w-full h-44 object-cover">
                        @else
                            <div class="w-full h-44 flex items-center justify-center text-5xl bg-gradient-to-br from-green-100 to-green-300">
                                🎪
                            </div>
                        @endif

                        {{-- Judul --}}
                        <div class="bg-green-100 px-4 py-2">
                            <h3 class="font-serif font-bold text-gray-900 text-base text-center leading-snug">
                                {{ $item->judul }}
                            </h3>
                        </div>

                        {{-- Tanggal --}}
                        <div class="flex items-center gap-2 bg-green-50 border-b border-green-100 px-4 py-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5"/>
                            </svg>
                            <span class="text-sm font-semibold text-green-700">
                                {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d F Y') }}
                            </span>
                        </div>

                        {{-- Biaya badge --}}
                        <div class="px-4 pt-3 flex justify-center">
                            @if(empty($item->biaya) || $item->biaya == '0' || strtolower($item->biaya) === 'gratis')
                                <span class="inline-block bg-green-100 text-green-700 text-xs font-bold px-3 py-1 rounded-full border border-green-300">
                                    ✅ Gratis
                                </span>
                            @else
                                <span class="inline-block bg-orange-100 text-orange-700 text-xs font-bold px-3 py-1 rounded-full border border-orange-300">
                                    💰 {{ $item->biaya }}
                                </span>
                            @endif
                        </div>

                        {{-- Deskripsi --}}
                        <div class="px-4 py-3 flex-1">
                            <p class="text-sm text-gray-600 text-center leading-relaxed line-clamp-3">
                                {{ Str::limit($item->deskripsi, 100) }}
                            </p>
                        </div>

                        {{-- Tombol --}}
                        <div class="grid grid-cols-2">
                            @php
                                $waPhone = $item->trainer?->phone ?? '6281234567890';
                                $waText  = urlencode('Halo, saya ingin mendaftar event: ' . $item->judul . ' pada ' . \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y'));
                            @endphp
                            <a href="https://wa.me/{{ $waPhone }}?text={{ $waText }}"
                               target="_blank"
                               class="bg-green-500 hover:bg-green-600 text-white text-sm font-semibold text-center py-3 transition-colors duration-200">
                                WhatsApp
                            </a>
                            <a href="{{ route('pelatihan.event.detail', $item->id) }}"
                               class="bg-orange-400 hover:bg-orange-500 text-gray-900 text-sm font-semibold text-center py-3 transition-colors duration-200">
                                Detail
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </section>

@endsection