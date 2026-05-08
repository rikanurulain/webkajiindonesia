{{-- resources/views/pages/pelatihanprogramdetail.blade.php --}}
@extends('layouts.app')

@section('title', $program['judul'] . ' - KAJI INDONESIA')

@section('content')


            {{-- Header --}}
    <section class="bg-gradient-to-br from-primary-dark via-primary to-primary- py-10 text-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-3">
                <a href="{{ url()->previous() }}" class="text-white/80 hover:text-white transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <h1 class="font-serif text-2xl font-bold">Program Pelatihan</h1>
            </div>
        </div>
    </section>

    <section class="bg-gray-50 py-12 px-4 min-h-screen">
        <div class="max-w-4xl mx-auto space-y-6">

            {{-- Hero Card --}}
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-200 grid grid-cols-1 sm:grid-cols-2">

                {{-- Ikon --}}
                <div class="h-56 sm:h-auto flex items-center justify-center text-7xl"
                     style="background: {{ $program['warna'] }};">
                    {{ $program['ikon'] }}
                </div>

                {{-- Info --}}
                <div class="p-6 flex flex-col justify-center gap-4">
                    <span class="inline-block bg-green-100 text-green-700 text-xs font-bold uppercase tracking-wide px-3 py-1 rounded-full w-fit">
                        Kurikulum Pelatihan
                    </span>
                    <p class="text-sm text-gray-600 leading-relaxed">{{ $program['deskripsi'] }}</p>
                    <div class="flex flex-wrap gap-3">
                        <a href="https://wa.me/6281234567890?text=Halo,%20saya%20ingin%20mendaftar%20program%20{{ urlencode($program['judul']) }}"
                           target="_blank"
                           class="bg-green-500 hover:bg-green-600 text-white text-sm font-bold px-5 py-2.5 rounded-lg transition-colors">
                            Daftar via WhatsApp
                        </a>
                        <a href="{{ route('pelatihan.program') }}"
                           class="border border-green-600 text-green-700 hover:bg-green-50 text-sm font-bold px-5 py-2.5 rounded-lg transition-colors">
                            ← Kembali
                        </a>
                    </div>
                </div>
            </div>

            {{-- Statistik --}}
            <div class="grid grid-cols-3 gap-4">

                {{-- Modul --}}
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-4 text-center">
                    <div class="flex justify-center mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                        </svg>
                    </div>
                    <div class="font-bold text-green-900 text-sm">{{ $program['total_modul'] }} Modul</div>
                    <div class="text-xs text-gray-500 mt-1">Total Materi</div>
                </div>

                {{-- Durasi --}}
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-4 text-center">
                    <div class="flex justify-center mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="font-bold text-green-900 text-sm">{{ $program['durasi'] }}</div>
                    <div class="text-xs text-gray-500 mt-1">Durasi Pelatihan</div>
                </div>

                {{-- Sertifikat --}}
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-4 text-center">
                    <div class="flex justify-center mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                        </svg>
                    </div>
                    <div class="font-bold text-green-900 text-sm">Sertifikat</div>
                    <div class="text-xs text-gray-500 mt-1">Resmi KAJI INDONESIA</div>
                </div>

            </div>

            {{-- Modul Pembelajaran --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                <h2 class="font-serif font-bold text-gray-900 text-xl mb-4 pb-3 border-b border-gray-100">
                    Modul Pembelajaran
                </h2>
                <div class="flex flex-col gap-3">
                    @foreach($program['modul'] as $index => $modul)
                    <div class="flex items-start gap-3 bg-gray-50 rounded-xl border border-gray-100 p-3">
                        <div class="w-7 h-7 rounded-full bg-green-700 flex items-center justify-center text-white text-xs font-bold flex-shrink-0 mt-0.5">
                            {{ $index + 1 }}
                        </div>
                        <div>
                            <div class="font-bold text-green-900 text-sm mb-1">{{ $modul['judul'] }}</div>
                            <div class="text-xs text-gray-500 leading-relaxed">{{ $modul['isi'] }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Benefit --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                <h2 class="font-serif font-bold text-gray-900 text-xl mb-4 pb-3 border-b border-gray-100">
                    Yang Akan Anda Dapatkan
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @foreach($program['benefit'] as $item)
                    <div class="flex items-start gap-2 text-sm text-gray-700 leading-relaxed">
                        <span class="text-green-500 font-bold mt-0.5">✔</span>
                        {{ $item }}
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Informasi Pelatihan --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                <h2 class="font-serif font-bold text-gray-900 text-xl mb-4 pb-3 border-b border-gray-100">
                    Informasi Pelatihan
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach ([
                        ['Metode',        $program['metode']],
                        ['Tingkat',       $program['tingkat']],
                        ['Durasi',        $program['durasi']],
                        ['Bahasa',        $program['bahasa']],
                        ['Peserta Maks.', $program['kuota']],
                        ['Penyelenggara', 'KAJI INDONESIA'],
                    ] as [$lbl, $val])
                    <div>
                        <div class="text-xs uppercase tracking-wide font-semibold text-gray-400 mb-1">{{ $lbl }}</div>
                        <div class="text-sm font-semibold text-green-900">{{ $val }}</div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </section>

@endsection