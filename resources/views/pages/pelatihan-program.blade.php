{{-- resources/views/pages/pelatihan-program.blade.php --}}
@extends('layouts.app')

@section('title', 'Program Pelatihan - KAJI Indonesia')

@section('content')

    {{-- Hero --}}
    <section class="bg-gradient-to-br from-primary-dark via-primary to-primary- py-16 text-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="max-w-2xl">
                <h1 class="font-serif text-4xl font-bold sm:text-5xl">
                    PROGRAM KAMI LATIH
                </h1>
                <p class="mt-4 text-lg text-white/90">
                    Kurikulum dan materi pelatihan untuk penguatan kapasitas Usaha.
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

        {{-- ========================= --}}
        {{-- KURIKULUM PELATIHAN       --}}
        {{-- ========================= --}}
        <h2 class="font-serif text-center text-3xl font-bold text-gray-900 sm:text-4xl mb-10">
            Kurikulum Pelatihan UMKM
        </h2>

        {{-- Kurikulum dari Trainer (database) --}}
        @if($programsDB->isNotEmpty())
        <div class="max-w-6xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-8">
            @foreach($programsDB as $program)
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-200 flex flex-col duration-300 hover:shadow-lg hover:-translate-y-1">

                {{-- Gambar / Placeholder --}}
                <div class="w-full h-44 flex items-center justify-center overflow-hidden bg-green-50">
                    @if($program->gambar)
                        <img src="{{ asset('storage/' . $program->gambar) }}"
                             alt="{{ $program->judul }}"
                             class="w-full h-full object-cover">
                    @else
                        <span class="text-5xl">🎓</span>
                    @endif
                </div>

                {{-- Badge judul --}}
                <div class="bg-green-100 px-4 py-2">
                    <h3 class="font-serif font-bold text-gray-900 text-lg text-center">{{ $program->judul }}</h3>
                </div>

                {{-- Deskripsi --}}
                <div class="px-4 py-3 flex-1">
                    <p class="text-sm text-gray-600 text-center leading-relaxed">
                        {{ Str::limit($program->deskripsi, 80) }}
                    </p>
                    @if($program->trainer)
                    <p class="text-xs text-gray-400 text-center mt-2">
                        oleh {{ $program->trainer->academic_degree ?? $program->trainer->name }}
                    </p>
                    @endif
                </div>

                {{-- Tombol --}}
                <div class="grid grid-cols-2">
                    <a href="https://wa.me/6281234567890?text=Halo,%20saya%20ingin%20tahu%20lebih%20lanjut%20tentang%20{{ urlencode($program->judul) }}"
                       target="_blank"
                       class="bg-green-500 hover:bg-green-600 text-white text-sm font-semibold text-center py-3 transition-colors duration-200">
                        WhatsApp
                    </a>
                    <a href="{{ route('pelatihan.detail', $program->id) }}"
                       class="bg-orange-400 hover:bg-orange-500 text-gray-900 text-sm font-semibold text-center py-3 transition-colors duration-200">
                        Detail
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        {{-- Kurikulum default (statis) --}}
        <div class="max-w-6xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-16">
            @forelse ($kurikulumDefault as $item)
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-200 flex flex-col duration-300 hover:shadow-lg hover:-translate-y-1">

                {{-- Ikon --}}
                <div class="w-full h-44 flex items-center justify-center text-5xl"
                     style="background: {{ $item['warna'] }};">
                    {{ $item['ikon'] }}
                </div>

                {{-- Badge judul --}}
                <div class="bg-green-100 px-4 py-2">
                    <h3 class="font-serif font-bold text-gray-900 text-lg text-center">{{ $item['judul'] }}</h3>
                </div>

                {{-- Deskripsi --}}
                <div class="px-4 py-3 flex-1">
                    <p class="text-sm text-gray-600 text-center leading-relaxed">{{ $item['deskripsi'] }}</p>
                </div>

                {{-- Tombol --}}
                <div class="grid grid-cols-2">
                    <a href="https://wa.me/6281234567890?text=Halo,%20saya%20ingin%20tahu%20lebih%20lanjut%20tentang%20{{ urlencode($item['judul']) }}"
                       target="_blank"
                       class="bg-green-500 hover:bg-green-600 text-white text-sm font-semibold text-center py-3 transition-colors duration-200">
                        WhatsApp
                    </a>
                    <a href="{{ route('pelatihan.detail', $loop->index + 1) }}"
                       class="bg-orange-400 hover:bg-orange-500 text-gray-900 text-sm font-semibold text-center py-3 transition-colors duration-200">
                        Detail
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-4 text-center text-gray-400 py-20">Belum ada kurikulum tersedia.</div>
            @endforelse
        </div>

        <hr class="max-w-6xl mx-auto border-gray-200 mb-16">

        {{-- ========================= --}}
        {{-- MATERI PELATIHAN          --}}
        {{-- ========================= --}}
        <h2 class="font-serif text-center text-3xl font-bold text-gray-900 sm:text-4xl mb-10">
            Materi Pelatihan UMKM
        </h2>

        {{-- Materi dari Trainer (database) --}}
        @if($materiDB->isNotEmpty())
        <div class="max-w-6xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-8">
            @foreach($materiDB as $program)
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-200 flex flex-col duration-300 hover:shadow-lg hover:-translate-y-1">

                {{-- Gambar / Placeholder --}}
                <div class="w-full h-44 flex items-center justify-center overflow-hidden bg-blue-50">
                    @if($program->gambar)
                        <img src="{{ asset('storage/' . $program->gambar) }}"
                             alt="{{ $program->judul }}"
                             class="w-full h-full object-cover">
                    @else
                        <span class="text-5xl">📚</span>
                    @endif
                </div>

                {{-- Badge judul --}}
                <div class="bg-green-100 px-4 py-2">
                    <h3 class="font-serif font-bold text-gray-900 text-lg text-center">{{ $program->judul }}</h3>
                </div>

                {{-- Deskripsi --}}
                <div class="px-4 py-3 flex-1">
                    <p class="text-sm text-gray-600 text-center leading-relaxed">
                        {{ Str::limit($program->deskripsi, 80) }}
                    </p>
                    @if($program->trainer)
                    <p class="text-xs text-gray-400 text-center mt-2">
                        oleh {{ $program->trainer->academic_degree ?? $program->trainer->name }}
                    </p>
                    @endif
                </div>

                {{-- Tombol --}}
                <div class="grid grid-cols-2">
                    <a href="https://wa.me/6281234567890?text=Halo,%20saya%20ingin%20tahu%20lebih%20lanjut%20tentang%20{{ urlencode($program->judul) }}"
                       target="_blank"
                       class="bg-green-500 hover:bg-green-600 text-white text-sm font-semibold text-center py-3 transition-colors duration-200">
                        WhatsApp
                    </a>
                    <a href="{{ route('pelatihan.detail', $program->id) }}"
                       class="bg-orange-400 hover:bg-orange-500 text-gray-900 text-sm font-semibold text-center py-3 transition-colors duration-200">
                        Detail
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        {{-- Materi default (statis) --}}
        <div class="max-w-6xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse ($materiDefault as $item)
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-200 flex flex-col duration-300 hover:shadow-lg hover:-translate-y-1">

                {{-- Ikon --}}
                <div class="w-full h-44 flex items-center justify-center text-5xl"
                     style="background: {{ $item['warna'] }};">
                    {{ $item['ikon'] }}
                </div>

                {{-- Badge judul --}}
                <div class="bg-green-100 px-4 py-2">
                    <h3 class="font-serif font-bold text-gray-900 text-lg text-center">{{ $item['judul'] }}</h3>
                </div>

                {{-- Deskripsi --}}
                <div class="px-4 py-3 flex-1">
                    <p class="text-sm text-gray-600 text-center leading-relaxed">{{ $item['deskripsi'] }}</p>
                </div>

                {{-- Tombol --}}
                <div class="grid grid-cols-2">
                    <a href="https://wa.me/6281234567890?text=Halo,%20saya%20ingin%20tahu%20lebih%20lanjut%20tentang%20{{ urlencode($item['judul']) }}"
                       target="_blank"
                       class="bg-green-500 hover:bg-green-600 text-white text-sm font-semibold text-center py-3 transition-colors duration-200">
                        WhatsApp
                    </a>
                    <a href="{{ route('pelatihan.detail', $loop->index + 1) }}"
                       class="bg-orange-400 hover:bg-orange-500 text-gray-900 text-sm font-semibold text-center py-3 transition-colors duration-200">
                        Detail
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-4 text-center text-gray-400 py-20">Belum ada materi tersedia.</div>
            @endforelse
        </div>

    </section>

@endsection