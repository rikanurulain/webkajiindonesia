@extends('layouts.app')

@section('title', 'Daftar Trainer')

@section('content')

    {{-- HERO SECTION --}}
    <section class="bg-gradient-to-br from-primary-dark via-primary to-primary- py-16 text-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="max-w-2xl">
                <h1 class="font-serif text-4xl font-bold sm:text-5xl uppercase">
                    DAFTAR TRAINER
                </h1>
                <p class="mt-4 text-lg text-white/90">
                    Temukan trainer profesional yang siap mendampingi perjalanan usaha Anda bersama KAJI INDONESIA.
                </p>
            </div>
            <div>
                <img src="{{ asset('storage/logo/KAMILATIH.png') }}"
                     alt="Logo Kamilatih"
                     class="w-64 md:w-80 object-contain">
            </div>
        </div>
    </section>

    <section class="bg-white py-16 px-6 min-h-screen">
        <h2 class="font-serif text-center text-3xl font-bold text-gray-900 sm:text-4xl mb-10">Daftar Trainer</h2>

        {{-- Search & Filter --}}
        <div class="max-w-2xl mx-auto flex flex-col sm:flex-row gap-4 mb-10">
            <div class="relative flex-1">
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                    </svg>
                </span>
                <input type="text" id="searchInput"
                       placeholder="Cari nama atau lokasi..."
                       class="w-full pl-9 pr-4 py-2.5 border border-gray-300 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-green-300">
            </div>
            <select id="bidangFilter"
                    class="px-4 py-2.5 border border-gray-300 rounded-full text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-green-300 bg-white">
                <option value="">Semua Bidang</option>
                @foreach($bidangList as $bidang)
                    <option value="{{ strtolower($bidang) }}">{{ $bidang }}</option>
                @endforeach
            </select>
        </div>

        {{-- Grid Kartu Trainer --}}
        <div class="max-w-5xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6" id="trainerGrid">

            @forelse($trainers as $trainer)
                <a href="{{ route('pelatihan.mentor.detail', $trainer->id) }}"
                   class="pembimbing-card block bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-lg hover:-translate-y-1 transition duration-300"
                   data-nama="{{ strtolower($trainer->name) }}"
                   data-lokasi="{{ strtolower($trainer->gmaps_location ?? '') }}"
                   data-bidang="{{ strtolower($trainer->bidang_keahlian ?? '') }}">

                    {{-- Foto --}}
                    <div class="w-full h-44 bg-gray-100 flex items-center justify-center overflow-hidden">
                        @if($trainer->white_bg_photo)
                            <img src="{{ asset('storage/' . $trainer->white_bg_photo) }}"
                                 alt="{{ $trainer->name }}"
                                 class="w-full h-full object-cover">
                        @elseif($trainer->profile_photo_path)
                            <img src="{{ asset('storage/' . $trainer->profile_photo_path) }}"
                                 alt="{{ $trainer->name }}"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="text-3xl font-bold text-emerald-700">
                                {{ strtoupper(substr($trainer->name, 0, 2)) }}
                            </div>
                        @endif
                    </div>

                    {{-- Info --}}
                    <div class="bg-green-50 px-4 py-2 border-b">
                        <h3 class="font-bold text-gray-900 text-sm line-clamp-1">
                            {{ $trainer->academic_degree ?? $trainer->name }}
                        </h3>
                        <p class="text-xs text-emerald-600 font-bold uppercase">
                            {{ $trainer->bidang_keahlian ?? 'Trainer' }}
                        </p>
                    </div>

                    <div class="px-4 py-3 text-gray-600">
                    <p class="text-xs mb-2">{{ $trainer->location ?? 'Lokasi tidak tersedia' }}</p>
                        <div class="flex items-center gap-1 mt-1">
    <div class="flex items-center gap-0.5 text-amber-400">
        @for($i = 1; $i <= 5; $i++)
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3"
                 fill="{{ $i <= round($trainer->avg_rating ?? 0) ? 'currentColor' : 'none' }}"
                 stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
            </svg>
        @endfor
    </div>
    <span class="text-xs text-gray-400 ml-1">
        {{ number_format($trainer->avg_rating ?? 0, 1) }}
        ({{ $trainer->total_ulasan ?? 0 }} ulasan)
    </span>
</div>
                    </div>

                </a>
            @empty
                <div class="col-span-full text-center py-20 text-gray-400 italic">
                    Belum ada trainer yang tersedia.
                </div>
            @endforelse

        </div>

        {{-- Pagination --}}
        <div class="mt-10 max-w-5xl mx-auto text-center">
            {{ $trainers->links() }}
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchInput');
            const bidangFilter = document.getElementById('bidangFilter');
            const cards = document.querySelectorAll('.pembimbing-card');

            function filterCards() {
                const keyword = searchInput.value.toLowerCase();
                const bidang  = bidangFilter.value.toLowerCase();

                cards.forEach(card => {
                    const matchSearch = card.dataset.nama.includes(keyword)
                                     || card.dataset.lokasi.includes(keyword);
                    const matchBidang = bidang === ''
                                     || card.dataset.bidang.includes(bidang);

                    card.style.display = (matchSearch && matchBidang) ? 'block' : 'none';
                });
            }

            searchInput.addEventListener('input', filterCards);
            bidangFilter.addEventListener('change', filterCards);
        });
    </script>

@endsection