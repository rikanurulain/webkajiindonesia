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

    <section class="bg-white py-16 px-6 min-h-screen">
        <h2 class="font-serif text-center text-3xl font-bold text-gray-900 sm:text-4xl mb-10">Daftar Pembimbing</h2>
    
        {{-- Search & Filter --}}
        <div class="max-w-2xl mx-auto flex flex-col sm:flex-row gap-4 mb-10">
            <div class="relative flex-1">
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                    </svg>
                </span>
                <input
                    type="text"
                    id="searchInput"
                    placeholder="Cari"
                    class="w-full pl-9 pr-4 py-2.5 border border-gray-300 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-green-300"
                >
            </div>
            <select
                id="filterRole"
                class="px-4 py-2.5 border border-gray-300 rounded-full text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-green-300 bg-white "
            >
                <option value="">Bidang Pendampingan</option>
                <option value="Pendamping">BNSP Pendamping UMKM</option>
                <option value="Pembimbing">BNSP Digital Marketing</option>
                <option value="Pendamping">Fasilitator Nasional BPOM</option>
                <option value="Pembimbing">Fasilitator Daerah BPOM</option>
                <option value="Pendamping">Pendamping Proses Produk Halal</option>
                <option value="Pembimbing">Fasilitator Nasional Formalisasi Usaha</option>
                <option value="Pendamping">Fasilitator SNI</option>
                <option value="Pembimbing">BNSP Penyelia Hala</option>
                <option value="Pendamping">BNSP Trainer</option>
                <option value="Pembimbing">BNSP Fasilitator Pendidikan dan Pelatihan</option>
                <option value="Pendamping">BNSP Ekspor</option>
                <option value="Pembimbing">BNSP Kuarator Produk UMKM</option>
                <option value="Pendamping">BNSP Asesor</option>
                <option value="Pembimbing">Tenaga Ahli Konsultan</option>
                <option value="Pendamping">Tenaga Ahli Akuntan</option>
                <option value="Pembimbing">Tenaga Ahli Logistik</option>
                <option value="Pendamping">Tenaga Ahli Manajemen Bisnis</option>
                <option value="Pembimbing">Tenaga Ahli Hukum</option>
            </select>
        </div>
    
        {{-- Grid Kartu --}}
        <div class="max-w-5xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6" id="pembimbingGrid">
    
            @forelse ($pembimbing as $p)
            <a href="{{ route('pembimbing.show', $p->id) }}"
                class="pembimbing-card block bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-lg hover:-translate-y-1 transition duration-300"
                data-nama="{{ strtolower($p->nama) }}"
                data-role="{{ $p->role }}">
                
                {{-- Foto --}}
                @if ($p->foto)
                    <img src="{{ asset('storage/pendamping/' . $p->foto) }}" alt="{{ $p->nama }}" class="w-full h-44 object-cover">
                @else
                    <div class="w-full h-44 bg-gray-300 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5.121 17.804A9 9 0 1112 21a9 9 0 01-6.879-3.196z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                @endif
    
                {{-- Info --}}
                <div class="bg-green-100 px-4 py-2">
                    <h3 class="font-bold text-gray-900 text-base">{{ $p->nama }}</h3>
                    <p class="text-sm text-gray-500">{{ $p->role }}</p>
                </div>
    
                <div class="px-4 py-3">
                    <p class="text-sm text-gray-600 mb-2">{{ $p->lokasi }}</p>
    
                    {{-- Bintang Ulasan --}}
                    <div class="flex items-center gap-1 text-gray-300 text-sm">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                            </svg>
                        @endfor
                        <span class="text-gray-400 text-xs ml-1">({{ $p->ulasan }} Ulasan)</span>
                    </div>
                </div>
    
            </a>
            @empty
                <div class="col-span-4 text-center text-gray-400 py-20">
                    Belum ada pembimbing tersedia.
                </div>
            @endforelse
    
        </div>
    </section>
 
{{-- Script Search & Filter --}}
<script>
    const searchInput = document.getElementById('searchInput');
    const filterRole  = document.getElementById('filterRole');
    const cards       = document.querySelectorAll('.pembimbing-card');
 
    function filterCards() {
        const keyword = searchInput.value.toLowerCase();
        const role    = filterRole.value.toLowerCase();
 
        cards.forEach(card => {
            const nama    = card.dataset.nama;
            const cardRole = card.dataset.role.toLowerCase();
 
            const matchSearch = nama.includes(keyword);
            const matchRole   = role === '' || cardRole === role;
 
            card.style.display = (matchSearch && matchRole) ? 'block' : 'none';
        });
    }
 
    searchInput.addEventListener('input', filterCards);
    filterRole.addEventListener('change', filterCards);
</script>

@endsection
