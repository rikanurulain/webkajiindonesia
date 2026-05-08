{{-- resources/views/pages/pelatihaneventdetail.blade.php --}}
@extends('layouts.app')

@section('title', $event['judul'] . ' - KAJI INDONESIA')

@section('content')

    {{-- Hero --}}
    {{-- <section class="bg-gradient-to-br from-primary-dark via-primary to-primary- py-16 text-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <a href="{{ route('pelatihan.event') }}" class="inline-flex items-center gap-2 text-white/80 hover:text-white text-sm font-semibold mb-6 transition-colors">
                ← Kembali ke Event Pelatihan
            </a>
            <h1 class="font-serif text-4xl font-bold sm:text-5xl">{{ $event['judul'] }}</h1>
            <p class="mt-3 text-white/90 text-lg">{{ $event['tipe_ikon'] }} {{ $event['tipe'] }}</p>
        </div>
    </section> --}}

        {{-- Header --}}
    <section class="bg-gradient-to-br from-primary-dark via-primary to-primary- py-10 text-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-3">
                <a href="{{ url()->previous() }}" class="text-white/80 hover:text-white transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <h1 class="font-serif text-2xl font-bold">Event Pelatihan</h1>
            </div>
        </div>
    </section>

    <section class="bg-gray-50 py-12 px-4 min-h-screen">
        <div class="max-w-4xl mx-auto space-y-6">

            {{-- Hero Card --}}
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-200 grid grid-cols-1 sm:grid-cols-2">

                {{-- Ikon --}}
                <div class="h-56 sm:h-auto flex items-center justify-center text-7xl"
                     style="background: {{ $event['warna'] }};">
                    {{ $event['ikon'] }}
                </div>

                {{-- Info --}}
                <div class="p-6 flex flex-col justify-center gap-4">
                    <div class="space-y-2">
                    <div class="flex items-center gap-2 text-sm text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-700 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                </svg>
                                <span class="font-semibold text-green-800">{{ $event['tanggal'] }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-700 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="font-semibold text-green-800">{{ $event['jam'] }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-700 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                </svg>
                                <span class="font-semibold text-green-800">{{ $event['lokasi'] }}</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-700 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                </svg>
                                <span class="font-semibold text-green-800">Kapasitas {{ $event['kapasitas'] }}</span>
                            </div>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <a href="https://wa.me/6281234567890?text=Halo,%20saya%20ingin%20mendaftar%20{{ urlencode($event['judul']) }}%20pada%20{{ urlencode($event['tanggal']) }}"
                            target="_blank"
                            class="bg-green-500 hover:bg-green-600 text-white text-sm font-bold px-5 py-2.5 rounded-lg transition-colors">
                                Daftar via WhatsApp
                            </a>
                            <a href="{{ route('pelatihan.event') }}"
                            class="border border-green-600 text-green-700 hover:bg-green-50 text-sm font-bold px-5 py-2.5 rounded-lg transition-colors">
                                ← Kembali
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Statistik --}}
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">

                    {{-- Durasi --}}
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-4 text-center">
                        <div class="flex justify-center mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="font-bold text-green-900 text-sm">{{ $event['durasi'] }}</div>
                        <div class="text-xs text-gray-500 mt-1">Durasi Acara</div>
                    </div>

                    {{-- Kapasitas --}}
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-4 text-center">
                        <div class="flex justify-center mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                            </svg>
                        </div>
                        <div class="font-bold text-green-900 text-sm">{{ $event['kapasitas'] }}</div>
                        <div class="text-xs text-gray-500 mt-1">Kapasitas</div>
                    </div>

                    {{-- Pembicara --}}
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-4 text-center">
                        <div class="flex justify-center mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
                            </svg>
                        </div>
                        <div class="font-bold text-green-900 text-sm">{{ $event['jumlah_mentor'] }}</div>
                        <div class="text-xs text-gray-500 mt-1">Pembicara</div>
                    </div>

                    {{-- Sertifikat --}}
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-4 text-center">
                        <div class="flex justify-center mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                            </svg>
                        </div>
                        <div class="font-bold text-green-900 text-sm">Sertifikat</div>
                        <div class="text-xs text-gray-500 mt-1">Resmi KAJI</div>
                    </div>

                </div>

            {{-- Tentang Event --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                <h2 class="font-serif font-bold text-gray-900 text-xl mb-4 pb-3 border-b border-gray-100">
                    Tentang {{ $event['tipe'] }} Ini
                </h2>
                <p class="text-sm text-gray-600 leading-relaxed">{{ $event['deskripsi_panjang'] }}</p>
            </div>

            {{-- Rundown --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                <h2 class="font-serif font-bold text-gray-900 text-xl mb-4 pb-3 border-b border-gray-100">
                    Rundown Acara
                </h2>
                <div class="divide-y divide-dashed divide-green-100">
                    @foreach($event['rundown'] as $sesi)
                    <div class="grid grid-cols-[90px_1fr] gap-4 py-4">
                        <div class="text-sm font-bold text-green-700 pt-0.5">{{ $sesi['waktu'] }}</div>
                        <div>
                            <div class="font-bold text-green-900 text-sm mb-1">{{ $sesi['judul'] }}</div>
                            <div class="text-xs text-gray-500 leading-relaxed">{{ $sesi['keterangan'] }}</div>
                            <span class="inline-block mt-2 text-xs font-bold px-2 py-0.5 rounded-full
                                {{ $sesi['tag_warna'] === 'hijau' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ $sesi['tag'] }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Pembicara --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                <h2 class="font-serif font-bold text-gray-900 text-xl mb-4 pb-3 border-b border-gray-100">
                    Pembicara & Mentor
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @foreach($event['pembicara'] as $orang)
                    <div class="flex items-center gap-3 bg-gray-50 rounded-xl border border-gray-100 p-3">
                        <div class="w-12 h-12 rounded-full bg-green-700 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                            {{ $orang['inisial'] }}
                        </div>
                        <div>
                            <div class="font-bold text-green-900 text-sm">{{ $orang['nama'] }}</div>
                            <div class="text-xs text-gray-500 mt-0.5 leading-snug">{{ $orang['peran'] }}</div>
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
                    @foreach($event['benefit'] as $item)
                    <div class="flex items-start gap-2 text-sm text-gray-700 leading-relaxed">
                        <span class="text-green-500 font-bold mt-0.5">✔</span>
                        {{ $item }}
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Informasi Teknis --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                <h2 class="font-serif font-bold text-gray-900 text-xl mb-4 pb-3 border-b border-gray-100">
                    Informasi Teknis
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach ([
                        ['Jenis Event',   $event['tipe']],
                        ['Tanggal',       $event['tanggal']],
                        ['Waktu',         $event['jam']],
                        ['Lokasi',        $event['lokasi']],
                        ['Kapasitas',     $event['kapasitas']],
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