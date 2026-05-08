{{-- resources/views/pages/pelatihanevent.blade.php --}}
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

        {{-- ==================== --}}
        {{-- GRID WORKSHOP        --}}
        {{-- ==================== --}}
        <h2 class="font-serif text-center text-3xl font-bold text-gray-900 sm:text-4xl mb-10">
            Workshop Pelatihan UMKM
        </h2>

        <div class="max-w-6xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-16">
            @forelse ($workshopDefault as $item)
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-200 flex flex-col duration-300 hover:shadow-lg hover:-translate-y-1">

                    {{-- Ikon / Placeholder --}}
                    <div class="w-full h-44 flex items-center justify-center text-5xl"
                         style="background: {{ $item['warna'] }};">
                        {{ $item['ikon'] }}
                    </div>

                    {{-- Badge judul --}}
                    <div class="bg-green-100 px-4 py-2">
                        <h3 class="font-serif font-bold text-gray-900 text-lg text-center">{{ $item['judul'] }}</h3>
                    </div>

                    {{-- Tanggal --}}
                    <div class="flex items-center gap-2 bg-green-50 border-b border-green-100 px-4 py-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                        </svg>
                        <span class="text-sm font-semibold text-green-700">{{ $item['tanggal'] }}</span>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="px-4 py-3 flex-1">
                        <p class="text-sm text-gray-600 text-center leading-relaxed">{{ $item['deskripsi_singkat'] }}</p>
                    </div>

                    {{-- Tombol --}}
                    <div class="grid grid-cols-2">
                        <a href="https://wa.me/6281234567890?text=Halo,%20saya%20ingin%20daftar%20{{ urlencode($item['judul']) }}%20pada%20{{ urlencode($item['tanggal']) }}"
                           target="_blank"
                           class="bg-green-500 hover:bg-green-600 text-white text-sm font-semibold text-center py-3 transition-colors duration-200">
                            WhatsApp
                        </a>
                        <a href="{{ route('pelatihan.event.detail', $loop->index + 1) }}"
                           class="bg-orange-400 hover:bg-orange-500 text-gray-900 text-sm font-semibold text-center py-3 transition-colors duration-200">
                            Detail
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-4 text-center text-gray-400 py-20">Belum ada workshop tersedia.</div>
            @endforelse
        </div>

        <hr class="max-w-6xl mx-auto border-gray-200 mb-16">

        {{-- ==================== --}}
        {{-- GRID SEMINAR         --}}
        {{-- ==================== --}}
        <h2 class="font-serif text-center text-3xl font-bold text-gray-900 sm:text-4xl mb-10">
            Seminar Pelatihan UMKM
        </h2>

        <div class="max-w-6xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse ($seminarDefault as $item)
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-200 flex flex-col duration-300 hover:shadow-lg hover:-translate-y-1">

                    {{-- Ikon / Placeholder --}}
                    <div class="w-full h-44 flex items-center justify-center text-5xl"
                         style="background: {{ $item['warna'] }};">
                        {{ $item['ikon'] }}
                    </div>

                    {{-- Badge judul --}}
                    <div class="bg-green-100 px-4 py-2">
                        <h3 class="font-serif font-bold text-gray-900 text-lg text-center">{{ $item['judul'] }}</h3>
                    </div>

                    {{-- Tanggal --}}
                    <div class="flex items-center gap-2 bg-green-50 border-b border-green-100 px-4 py-2">
                        <span>📅</span>
                        <span class="text-sm font-semibold text-green-700">{{ $item['tanggal'] }}</span>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="px-4 py-3 flex-1">
                        <p class="text-sm text-gray-600 text-center leading-relaxed">{{ $item['deskripsi_singkat'] }}</p>
                    </div>

                    {{-- Tombol --}}
                    <div class="grid grid-cols-2">
                        <a href="https://wa.me/6281234567890?text=Halo,%20saya%20ingin%20daftar%20{{ urlencode($item['judul']) }}%20pada%20{{ urlencode($item['tanggal']) }}"
                           target="_blank"
                           class="bg-green-500 hover:bg-green-600 text-white text-sm font-semibold text-center py-3 transition-colors duration-200">
                            WhatsApp
                        </a>
                        <a href="{{ route('pelatihan.event.detail', $loop->index + 1) }}"
                           class="bg-orange-400 hover:bg-orange-500 text-gray-900 text-sm font-semibold text-center py-3 transition-colors duration-200">
                            Detail
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-4 text-center text-gray-400 py-20">Belum ada seminar tersedia.</div>
            @endforelse
        </div>

    </section>

@endsection