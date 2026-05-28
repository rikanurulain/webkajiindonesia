@extends('layouts.app')

@section('content')
    {{-- 1. HERO --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-primary-dark via-primary to-primary-light">
        <div class="absolute inset-0 opacity-[0.03]" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23000\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        <div class="relative mx-auto max-w-7xl px-4 py-16 sm:px-6 sm:py-20 lg:flex lg:items-center lg:gap-12 lg:px-8">
            <div class="max-w-2xl lg:max-w-xl">
                <h1 class="font-serif text-4xl font-bold tracking-tight text-white sm:text-5xl lg:text-6xl">
                    Membangun Indonesia Melalui Kajian & Pelatihan
                </h1>
                <p class="mt-4 text-lg text-white/90">
                    Kaji Indonesia hadir sebagai mitra terpercaya dalam pengembangan SDM, pendampingan UMKM, sertifikasi halal, dan konsultasi bisnis dengan nilai-nilai profesional dan islami.
                </p>
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="#layanan" class="inline-flex items-center justify-center rounded-xl bg-secondary px-6 py-3.5 text-base font-semibold text-gray-900 shadow-lg transition-all hover:bg-secondary-dark hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-secondary focus:ring-offset-2">
                        Lihat Program
                    </a>
                    <a href="#kontak" class="inline-flex items-center justify-center rounded-xl border-2 border-white/80 bg-white/10 px-6 py-3.5 text-base font-semibold text-white backdrop-blur-sm transition-all hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-primary">
                        Hubungi Kami
                    </a>
                </div>
            </div>
            <div class="mt-10 flex justify-center lg:mt-0 lg:shrink-0">
                <div class="relative rounded-2xl bg-white/10 p-6 backdrop-blur-sm ring-1 ring-white/20">
                    <div class="flex h-64 w-64 items-center justify-center rounded-xl bg-white/5 sm:h-80 sm:w-80">
                        <svg class="h-40 w-40 text-white/80 sm:h-52 sm:w-52" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>

 {{-- 2. STATISTIK --}}
<section class="bg-white py-16 sm:py-20" id="statistik"
         x-data="{
             shown: false,
             counters: { event: 0, speakers: 0, participants: 0, topics: 0 },
             target: { event: 108, speakers: 512, participants: 15053, topics: 1024 },
             intervalId: null,
             step() {
                 const speed = 80;
                 let selesai = true;
                 ['event','speakers','participants','topics'].forEach(k => {
                     if (this.counters[k] < this.target[k]) {
                         selesai = false;
                         const add = Math.ceil(this.target[k] / speed);
                         this.counters[k] = Math.min(this.counters[k] + add, this.target[k]);
                     }
                 });
                 if (selesai) clearInterval(this.intervalId);
             },
             mulai() {
                 if (this.shown) return;
                 this.shown = true;
                 this.intervalId = setInterval(() => this.step(), 20);
             }
         }"
         x-init="
             const observer = new IntersectionObserver((entries) => {
                 entries.forEach(entry => {
                     if (entry.isIntersecting) {
                         mulai();
                         observer.disconnect();
                     }
                 });
             }, { threshold: 0.2 });
             observer.observe($el);
         ">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">

{{-- Acara --}}
<div class="rounded-2xl border border-gray-100 bg-gray-50 p-6 text-center transition-all duration-300 hover:border-primary/20 hover:bg-primary/5">
    <p class="text-3xl font-bold tracking-tight text-primary sm:text-4xl lg:text-5xl"
       x-text="counters.event.toLocaleString('id-ID')">0</p>
    <p class="mt-2 text-sm text-gray-500">Acara</p>
</div>

{{-- Pembicara --}}
<div class="rounded-2xl border border-gray-100 bg-gray-50 p-6 text-center transition-all duration-300 hover:border-primary/20 hover:bg-primary/5">
    <p class="text-3xl font-bold tracking-tight text-primary sm:text-4xl lg:text-5xl"
       x-text="counters.speakers.toLocaleString('id-ID')">0</p>
    <p class="mt-2 text-sm text-gray-500">Pembicara</p>
</div>

{{-- Peserta --}}
<div class="rounded-2xl border border-gray-100 bg-gray-50 p-6 text-center transition-all duration-300 hover:border-primary/20 hover:bg-primary/5">
    <p class="text-3xl font-bold tracking-tight text-primary sm:text-4xl lg:text-5xl"
       x-text="counters.participants.toLocaleString('id-ID')">0</p>
    <p class="mt-2 text-sm text-gray-500">Peserta</p>
</div>

{{-- Topik Dibahas --}}
<div class="rounded-2xl border border-gray-100 bg-gray-50 p-6 text-center transition-all duration-300 hover:border-primary/20 hover:bg-primary/5">
    <p class="text-3xl font-bold tracking-tight text-primary sm:text-4xl lg:text-5xl"
       x-text="counters.topics.toLocaleString('id-ID')">0</p>
    <p class="mt-2 text-sm text-gray-500">Topik Dibahas</p>
</div>

</div>
    </div>
</section>

{{-- 3. LAYANAN UNGGULAN --}}
<section class="bg-gray-50 py-10 sm:py-16 lg:py-20" id="layanan">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="font-serif text-2xl font-bold text-gray-900 sm:text-3xl lg:text-4xl">Layanan Unggulan</h2>
            <p class="mx-auto mt-3 max-w-2xl text-sm sm:text-base text-gray-600">Berbagai program dan layanan untuk mendukung perkembangan bisnis dan SDM Anda.</p>
        </div>
        <div class="mt-8 sm:mt-12 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @php
    $layanan = [
        ['route' => 'pelatihan.program',   'external' => false, 'icon' => 'academic', 'title' => 'Pelatihan',    'desc' => 'Program pelatihan berkualitas untuk peningkatan kompetensi SDM dan profesional.'],
        ['route' => 'umkm.produk',         'external' => false, 'icon' => 'store',    'title' => 'UMKM',         'desc' => 'Pendampingan dan penguatan kapasitas usaha mikro, kecil, dan menengah.'],
        ['route' => 'halal-center.gratis', 'external' => false, 'icon' => 'halal',    'title' => 'Halal Center', 'desc' => 'Sertifikasi dan konsultasi halal untuk produk dan proses bisnis Anda.'],
        ['route' => 'konsultan.layanan',   'external' => false, 'icon' => 'consult',  'title' => 'Konsultan',    'desc' => 'Konsultasi strategi bisnis, manajemen, dan pengembangan organisasi.'],
        ['route' => 'https://infojawatimur.com', 'external' => true, 'icon' => 'media', 'title' => 'Media',      'desc' => 'Konten edukatif dan informasi seputar kajian, bisnis, dan halal.'],
        ['route' => null,                  'external' => false, 'icon' => 'book',     'title' => 'Kajian',       'desc' => 'Forum kajian dan diskusi untuk pengembangan wawasan dan jaringan.'],
    ];
@endphp
            @foreach ($layanan as $item)
                <div class="rounded-2xl bg-white p-5 sm:p-6 shadow-sm ring-1 ring-gray-200/50 transition-shadow hover:shadow-lg">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-primary/10 text-primary">
                        @if (($item['icon'] ?? '') === 'academic')
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                        @elseif (($item['icon'] ?? '') === 'store')
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        @elseif (($item['icon'] ?? '') === 'halal')
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        @elseif (($item['icon'] ?? '') === 'consult')
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        @elseif (($item['icon'] ?? '') === 'media')
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        @else
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        @endif
                    </div>
                    <h3 class="mt-4 font-serif text-lg sm:text-xl font-semibold text-gray-900">{{ $item['title'] }}</h3>
                    <p class="mt-2 text-sm text-gray-600 leading-relaxed">{{ $item['desc'] }}</p>
                    @if ($item['external'])
                        <a href="{{ $item['route'] }}" target="_blank" rel="noopener noreferrer"
                           class="mt-4 inline-flex items-center text-sm font-semibold text-primary hover:underline">
                            Selengkapnya
                            <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </a>
                    @elseif (!empty($item['route']))
                        <a href="{{ route($item['route']) }}"
                           class="mt-4 inline-flex items-center text-sm font-semibold text-primary hover:underline">
                            Selengkapnya
                            <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    @else
                        <a href="#kontak" class="mt-4 inline-flex items-center text-sm font-semibold text-primary hover:underline">
                            Selengkapnya
                            <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>

 {{-- 4. TENTANG KAMI --}}
<section class="bg-white py-16 sm:py-20" id="tentang-kami">
    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

        {{-- Header Tengah --}}
        <div class="text-center mb-6">
            <h2 class="font-serif text-3xl font-bold text-gray-900 sm:text-4xl">Tentang Kami</h2>
        </div>

        {{-- Konten: Logo kiri sejajar Teks kanan --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:items-stretch">

         {{-- Kiri: Logo --}}
<div class="flex items-center justify-center" style="min-height: 280px;">
    <img
        src="{{ asset('storage/logo/logo.png') }}"
        alt="Logo Kaji Indonesia"
        class="object-contain"
        style="height: 280px; width: auto;"
    />
</div>

            {{-- Kanan: Deskripsi --}}
            <div class="flex flex-col justify-center" style="min-height: 280px;">
                <p class="text-gray-600 leading-relaxed text-sm sm:text-base text-justify">
                    <span class="font-semibold text-gray-800">KAJI Indonesia</span> adalah lembaga yang berfokus pada penguatan kolaborasi antar komunitas, organisasi, dan instansi. Berdiri sejak <span class="font-semibold text-primary">2008</span> sebagai penghubung komunitas di Jawa Timur, kini berkembang menjadi jaringan kolaboratif berskala nasional.
                </p>
                <p class="mt-4 text-gray-600 leading-relaxed text-sm sm:text-base text-justify">
                    Resmi menjadi lembaga nasional pada <span class="font-semibold text-primary">2012</span>, KAJI menghadirkan sinergi aktif dan berkelanjutan melalui inkubator bisnis dan layanan konsultasi untuk mendukung pertumbuhan ekonomi dan kualitas SDM.
                </p>
                <p class="mt-4 text-gray-600 leading-relaxed text-sm sm:text-base text-justify">
                    Dengan pendekatan <span class="font-medium text-gray-800">digital, legal, dan modern</span>, KAJI mendorong ekosistem kewirausahaan yang mandiri dan berdaya saing hingga tingkat global.
                </p>
                <div class="mt-6 flex flex-wrap gap-2">
                    <span class="inline-flex items-center rounded-full bg-primary/10 px-4 py-1.5 text-xs font-semibold text-primary ring-1 ring-primary/20">Sejak 2008</span>
                    <span class="inline-flex items-center rounded-full bg-primary/10 px-4 py-1.5 text-xs font-semibold text-primary ring-1 ring-primary/20">Lembaga Nasional</span>
                    <span class="inline-flex items-center rounded-full bg-primary/10 px-4 py-1.5 text-xs font-semibold text-primary ring-1 ring-primary/20">Jaringan Global</span>
                </div>
            </div>

        </div>
    </div>
</section>

   {{-- 5. TESTIMONI / PARTNER --}}
<section class="bg-gray-50 py-16 sm:py-20">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        
        {{-- Testimoni --}}
        <div class="text-center">
            <h2 class="font-serif text-3xl font-bold text-gray-900 sm:text-4xl">Apa Kata Mereka</h2>
            <p class="mx-auto mt-3 max-w-2xl text-gray-600">Testimoni dari mitra dan peserta program Kaji Indonesia.</p>
        </div>
        <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <div class="rounded-2xl bg-white p-6 shadow-lg ring-1 ring-gray-200/50">
                <p class="text-gray-700">"Pelatihan dari Kaji Indonesia sangat aplikatif. Tim kami langsung bisa mengimplementasikan di lapangan."</p>
                <p class="mt-4 font-semibold text-gray-900">Bapak Ahmad, Direktur HR</p>
                <p class="text-sm text-gray-500">Perusahaan Manufaktur</p>
            </div>
            <div class="rounded-2xl bg-white p-6 shadow-lg ring-1 ring-gray-200/50">
                <p class="text-gray-700">"Pendampingan UMKM dan proses sertifikasi halal kami berjalan lancar. Recommended."</p>
                <p class="mt-4 font-semibold text-gray-900">Ibu Siti, Pemilik UMKM</p>
                <p class="text-sm text-gray-500">Produk Makanan</p>
            </div>
            <div class="rounded-2xl bg-white p-6 shadow-lg ring-1 ring-gray-200/50 sm:col-span-2 lg:col-span-1">
                <p class="text-gray-700">"Konsultan profesional dan komunikatif. Hasil rekomendasi strategi sangat membantu perkembangan bisnis kami."</p>
                <p class="mt-4 font-semibold text-gray-900">Bapak Rudi, CEO Startup</p>
                <p class="text-sm text-gray-500">Teknologi</p>
            </div>
        </div>

        {{-- Partner --}}
        <div class="mt-16 border-t border-gray-200 pt-12">
            <p class="text-center text-sm font-medium uppercase tracking-wider text-gray-500">Dipercaya oleh</p>

            @php
                $partners = [
                    ['image' => 'partners/Partner-01.png', 'name' => 'Partner 1'],
                    ['image' => 'partners/partner-02.png', 'name' => 'Partner 2'],
                    ['image' => 'partners/partner-03.png', 'name' => 'Partner 3'],
                    ['image' => 'partners/partner-04.png', 'name' => 'Partner 4'],
                    ['image' => 'partners/partner-05.png', 'name' => 'Partner 5'],
                    ['image' => 'partners/partner-06.jpg', 'name' => 'Partner 6'],
                    ['image' => 'partners/partner-07.png', 'name' => 'Partner 7'],
                    ['image' => 'partners/partner-08.png', 'name' => 'Partner 8'],
                    ['image' => 'partners/partner-09.jpg', 'name' => 'Partner 9'],
                    ['image' => 'partners/partner-10.png', 'name' => 'Partner 10'],
                    ['image' => 'partners/partner-11.png', 'name' => 'Partner 11'],
                    ['image' => 'partners/partner-12.png', 'name' => 'Partner 12'],
                    ['image' => 'partners/partner-13.jpeg', 'name' => 'Partner 13'],
                    ['image' => 'partners/partner-14.jpeg', 'name' => 'Partner 14'],
                    ['image' => 'partners/partner-15.jpg', 'name' => 'Partner 15'],
                    ['image' => 'partners/partner-16.png', 'name' => 'Partner 16'],
                    ['image' => 'partners/partner-17.png', 'name' => 'Partner 17'],
                ];
            @endphp

           <div class="mt-8 flex flex-wrap justify-center gap-4">
    @foreach ($partners as $partner)
        <div class="group flex items-center justify-center rounded-xl bg-white px-8 py-5 shadow-sm ring-1 ring-gray-200/60 transition-all duration-300 hover:shadow-md hover:ring-gray-300">
            <img
                src="{{ asset('storage/' . $partner['image']) }}"
                alt="{{ $partner['name'] }}"
                class="h-14 w-auto max-w-[140px] object-contain transition-all duration-300 group-hover:scale-105"
                loading="lazy"
            />
        </div>
    @endforeach
</div>

    </div>
</section>

    {{-- 6. CTA BANNER --}}
    <section class="bg-primary py-16 sm:py-20" id="kontak">
        <div class="mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8">
            <h2 class="font-serif text-3xl font-bold text-white sm:text-4xl">Siap Berkembang Bersama Kami?</h2>
            <p class="mt-4 text-lg text-white/90">Daftar sekarang untuk program pelatihan, pendampingan UMKM, atau konsultasi. Tim kami siap mendampingi Anda.</p>
            <a href="{{ route('register') }}" class="mt-8 inline-flex items-center justify-center rounded-xl bg-secondary px-8 py-4 text-base font-semibold text-gray-900 shadow-lg transition-all hover:bg-secondary-dark hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-secondary focus:ring-offset-2 focus:ring-offset-primary">
                Daftar Sekarang
            </a>
        </div>
    </section>
@endsection
