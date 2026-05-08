@extends('layouts.app')

@section('title', 'Daftar Pembimbing')

@section('content')

    {{-- HERO SECTION --}}
    <section class="bg-gradient-to-br from-primary-dark via-primary to-primary- py-16 text-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-8">

            {{-- TEXT --}}
            <div class="max-w-2xl">
                <h1 class="font-serif text-4xl font-bold sm:text-5xl">
                    DAFTAR PEMBIMBING
                </h1>
                <p class="mt-4 text-lg text-white/90">
                    Temukan pembimbing profesional yang siap mendampingi perjalanan usaha Anda bersama KAJI INDONESIA.
                </p>
            </div>

            <div>
                <img src="{{ asset('storage/logo/KAMILATIH.png') }}"
                 alt="Logo Karya Kami"
                 class="w-64 md:w-80 object-contain">
            </div>

        </div>
    </section>

    {{-- KONTEN UTAMA --}}
    <section class="bg-white py-16 px-6 min-h-screen">

        <h2 class="font-serif text-center text-3xl font-bold text-gray-900 sm:text-4xl mb-10">
            Daftar Trainer
        </h2>

        {{-- Search & Filter --}}
        <div class="max-w-2xl mx-auto flex flex-col sm:flex-row gap-4 mb-10">

            {{-- Search --}}
            <div class="relative flex-1">
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                    </svg>
                </span>
                <input
                    type="text"
                    id="searchInput"
                    placeholder="Cari nama atau lokasi..."
                    oninput="filterPembimbing()"
                    class="w-full pl-9 pr-4 py-2.5 border border-gray-300 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-green-300"
                >
            </div>

            {{-- Filter Bidang --}}
            <select
                id="bidangFilter"
                onchange="filterPembimbing()"
                class="px-4 py-2.5 border border-gray-300 rounded-full text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-green-300 bg-white"
            >
                <option value="">Bidang Pendampingan</option>
                @foreach($bidangList as $bidang)
                    <option value="{{ $bidang }}">{{ $bidang }}</option>
                @endforeach
            </select>

        </div>

        {{-- Grid Kartu --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
    @foreach($trainers as $trainer)
    <div class="card-trainer">
        <div class="initials-box">
            {{ strtoupper(substr($trainer->name, 0, 2)) }}
        </div>
        <div class="info-pendaftaran">
            <h3>{{ $trainer->academic_degree ?? $trainer->name }}</h3>
            <p>Pendamping · {{ $trainer->specialization ?? 'Umum' }}</p>
            <p class="location">{{ $trainer->location }}</p>
        </div>
    </div>
    @endforeach
</div>

                {{-- Info Hijau --}}
                <div class="bg-green-100 px-4 py-2">
                    <h3 class="font-bold text-gray-900 text-base">{{ $item->nama }}</h3>
                    <p class="text-sm text-green-700 mt-0.5">Pendamping · {{ $item->bidang ?? 'Umum' }}</p>
                </div>

                {{-- Detail --}}
                <div class="px-4 py-3">
                    @if($item->lokasi)
                    <p class="text-sm text-gray-600 mb-2 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-green-500 flex-shrink-0"
                             viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                  d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                  clip-rule="evenodd"/>
                        </svg>
                        {{ $item->lokasi }}
                    </p>
                    @endif

                    {{-- Bintang Rating --}}
                    <div class="flex items-center gap-0.5 text-sm">
                        @php $avg = round($item->ulasan_avg_rating ?? 0); @endphp
                        @for($i = 1; $i <= 5; $i++)
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="w-4 h-4"
                                 fill="{{ $i <= $avg ? '#f59e0b' : '#e5e7eb' }}"
                                 viewBox="0 0 24 24">
                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                            </svg>
                        @endfor
                        <span class="text-gray-400 text-xs ml-1">({{ $item->ulasan_count ?? 0 }} Ulasan)</span>
                    </div>
                </div>

            </a>
            @empty
            <div class="col-span-4 text-center text-gray-400 py-20">
                Belum ada pembimbing terdaftar.
            </div>
            @endforelse

        </div>

    </section>

@endsection

@push('scripts')
<script>
function filterPembimbing() {
    const search = document.getElementById('searchInput').value.toLowerCase();
    const bidang = document.getElementById('bidangFilter').value.toLowerCase();

    document.querySelectorAll('.pembimbing-card').forEach(card => {
        const matchSearch = !search
            || card.dataset.nama.includes(search)
            || card.dataset.lokasi.includes(search);
        const matchBidang = !bidang
            || card.dataset.bidang === bidang;

        card.style.display = (matchSearch && matchBidang) ? 'block' : 'none';
    });
}
</script>
@endpush