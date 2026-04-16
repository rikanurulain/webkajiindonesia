@extends('layouts.app')

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
            <h1 class="font-serif text-2xl font-bold">Detail Produk</h1>
        </div>
    </div>
</section>

<section class="bg-gray-50 py-12 px-4 min-h-screen">
    <h2 class="font-serif text-center text-2xl font-bold text-gray-900 mb-10">Detail Produk</h2>

    <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- KOLOM KIRI: Foto Detail --}}
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
            <h3 class="font-serif font-bold text-gray-900 text-xl text-center mb-4">{{ $produk->nama }}</h3>

            @if ($produk->foto_detail)
                <img
                    src="{{ $produk->foto_detail ? asset('storage/produk-detail/' . $produk->foto_detail) : asset('images/no-image.png') }}"
                    alt="{{ $produk->nama }}"
                    class="w-full rounded-sm object-cover"
                >
                {{-- <img 
                src="{{ $produk->foto_detail ? asset('storage/produk-detail/' . $produk->foto_detail) : asset('images/no-image.png') }}"
                alt="{{ $produk->nama }}"
                class="..."> --}}
            @else
                <div class="w-full h-64 bg-gray-200 rounded-xl flex items-center justify-center">
                    <span class="text-gray-400 text-sm">Tidak ada foto detail</span>
                </div>
            @endif
        </div>

        {{-- KOLOM TENGAH: Info & Tombol --}}
        <div class="flex flex-col gap-6">

            {{-- Info Box --}}
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm flex-1">

                @if ($produk->harga)
                <div class="mb-4">
                    <p class="text-sm font-bold text-gray-700">Harga</p>
                    <p class="text-green-600 font-semibold text-lg">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                </div>
                @endif

                {{-- Tambahkan ini SEBELUM blok keterangan --}}
                @if ($produk->kategori)
                <div class="mb-4">
                    <p class="text-sm font-bold text-gray-700">Kategori</p>
                    <span class="inline-block bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full mt-1">
                        {{ $produk->kategori }}
                    </span>
                </div>
                @endif

                <div class="mb-4">
                    <p class="text-sm font-bold text-gray-700">Keterangan</p>
                    <p class="text-gray-600 text-sm leading-relaxed mt-1">{{ $produk->keterangan ?? $produk->deskripsi }}</p>
                </div>

                @if ($produk->alamat)
                <div class="mb-4">
                    <p class="text-sm font-bold text-gray-700">Alamat</p>
                    <p class="text-gray-600 text-sm mt-1">{{ $produk->alamat }}</p>
                </div>
                @endif

                @if ($produk->whatsapp)
                <div>
                    <p class="text-sm font-bold text-gray-700">Kontak</p>
                    <p class="text-gray-600 text-sm mt-1">{{ $produk->whatsapp }}</p>
                </div>
                @endif

            </div>

            {{-- Tombol --}}
            <div class="flex flex-col gap-3">
                @if ($produk->whatsapp)
                <a href="https://wa.me/{{ $produk->whatsapp }}"
                   target="_blank"
                   class="bg-green-500 hover:bg-green-600 text-white font-semibold text-center py-4 rounded-xl transition-colors duration-200 text-base">
                    Hubungi WhatsApp
                </a>
                @endif

                @if ($produk->alamat)
                <a href="https://www.google.com/maps/search/{{ urlencode($produk->alamat) }}"
                   target="_blank"
                   class="bg-orange-400 hover:bg-orange-500 text-white font-semibold text-center py-4 rounded-xl transition-colors duration-200 text-base">
                    Lihat Alamat
                </a>
                @endif
            </div>

        </div>

        {{-- KOLOM KANAN: UMKM Lainnya --}}
<div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
    <h3 class="font-serif font-bold text-gray-900 text-lg text-center mb-4">UMKM Lainnya</h3>

    <div class="flex flex-col gap-4 max-h-[600px] overflow-y-auto pr-1">
        @foreach ($lainnya as $item)
        <a href="{{ route('produk.show', $item->id) }}" class="flex flex-col items-center gap-2 group">
            @if ($item->foto)
                <img
                    src="{{ asset('storage/produk-pict/' . $item->foto) }}"
                    alt="{{ $item->nama }}"
                    class="w-full h-24 object-cover rounded-xl group-hover:opacity-80 transition"
                >
            @else
                <div class="w-full h-24 bg-gray-200 rounded-xl flex items-center justify-center">
                    <span class="text-gray-400 text-xs">Tidak ada foto</span>
                </div>
            @endif
            <p class="text-sm text-gray-700 font-medium text-center group-hover:text-green-600 transition">
                {{ $item->nama }}
            </p>
        </a>
        @endforeach
    </div>
</div>

@endsection