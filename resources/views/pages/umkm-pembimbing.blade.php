@extends('layouts.app')

@section('content')
    {{-- Header Section --}}
    <section class="bg-gradient-to-br from-primary-dark via-primary to-primary- py-16 text-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="max-w-2xl">
                <h1 class="font-serif text-4xl font-bold sm:text-5xl uppercase">
                    UMKM KARYA KAMI
                </h1>
                <p class="mt-4 text-lg text-white/90">
                    Pendampingan dan penguatan kapasitas usaha mikro, kecil, dan menengah.
                </p>
            </div>
            <div>
                <img src="{{ asset('storage/logo/KARYAKAMI.png') }}" alt="Logo Karya Kami" class="w-64 md:w-80 object-contain">
            </div>
        </div>
    </section>   

    <section class="bg-white py-16 px-6 min-h-screen">
        <h2 class="font-serif text-center text-3xl font-bold text-gray-900 sm:text-4xl mb-10">Daftar Mentor</h2>
    
        {{-- Search & Filter --}}
        <div class="max-w-2xl mx-auto flex flex-col sm:flex-row gap-4 mb-10">
            <div class="relative flex-1">
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                    </svg>
                </span>
                <input type="text" id="searchInput" placeholder="Cari nama atau lokasi..." class="w-full pl-9 pr-4 py-2.5 border border-gray-300 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-green-300">
            </div>
            <select id="filterRole" class="px-4 py-2.5 border border-gray-300 rounded-full text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-green-300 bg-white">
                <option value="">Semua Bidang</option>
                <option value="Pendamping">BNSP Pendamping UMKM</option>
                <option value="Digital Marketing">BNSP Digital Marketing</option>
            </select>
        </div>
    
        {{-- Grid Kartu Mentor --}}
        <div class="max-w-5xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6" id="pembimbingGrid">

            @forelse($trainers as $m)
                <a href="{{ route('pelatihan.mentor.detail', $m->id) }}"
                    class="pembimbing-card block bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-lg hover:-translate-y-1 transition duration-300"
                    data-nama="{{ strtolower($m->name) }}"
                    data-lokasi="{{ strtolower($m->location) }}"
                    data-role="{{ strtolower($m->role) }}">
                    
                    {{-- Foto --}}
                    <div class="w-full h-44 bg-gray-100 flex items-center justify-center overflow-hidden">
                        @if ($m->white_bg_photo)
                            <img src="{{ asset('storage/' . $m->white_bg_photo) }}" alt="{{ $m->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="text-3xl font-bold text-emerald-700">
                                {{ strtoupper(substr($m->name, 0, 2)) }}
                            </div>
                        @endif
                    </div>

                    {{-- Info --}}
                    <div class="bg-green-50 px-4 py-2 border-b">
                        <h3 class="font-bold text-gray-900 text-sm line-clamp-1">{{ $m->academic_degree ?? $m->name }}</h3>
                        <p class="text-xs text-emerald-600 font-bold uppercase">{{ $m->role ?? 'Mentor' }}</p>
                    </div>

                    <div class="px-4 py-3 text-gray-600">
                        <p class="text-xs mb-2">{{ $m->location ?? 'Lokasi tidak tersedia' }}</p>
                        <div class="flex items-center gap-1 text-amber-400">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                </svg>
                            @endfor
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-20 text-gray-400 italic">
                    Belum ada mentor yang tersedia.
                </div>
            @endforelse

        </div>

        {{-- Pagination --}}
        <div class="mt-10 max-w-5xl mx-auto text-center">
            {{ $trainers->links() }}
        </div>
    </section>

    {{-- Script Search & Filter --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const filterRole  = document.getElementById('filterRole');
            const cards       = document.querySelectorAll('.pembimbing-card');

            function filterCards() {
                const keyword = searchInput.value.toLowerCase();
                const role    = filterRole.value.toLowerCase();

                cards.forEach(card => {
                    const nama    = card.dataset.nama || '';
                    const lokasi  = card.dataset.lokasi || '';
                    const cardRole = card.dataset.role || '';

                    const matchSearch = nama.includes(keyword) || lokasi.includes(keyword);
                    const matchRole   = role === '' || cardRole.includes(role);

                    card.style.display = (matchSearch && matchRole) ? 'block' : 'none';
                });
            }

            searchInput.addEventListener('input', filterCards);
            filterRole.addEventListener('change', filterCards);
        });
    </script>
@endsection