@extends('layouts.app')

@section('title', 'Profil ' . $pembimbing->nama)

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
            <h1 class="font-serif text-2xl font-bold">Profil Mentor</h1>
        </div>
    </div>
</section>

{{-- KONTEN --}}
<div style="background:#f7f7f2; min-height:100vh; padding:2rem 0;">
    <div style="max-width:900px; margin:0 auto; padding:0 1rem;">

        {{-- KARTU UTAMA --}}
        <div style="background:#fff; border-radius:16px; border:1px solid #e5e5e5; overflow:hidden; margin-bottom:1.2rem;">
            <div style="display:flex; align-items:stretch; flex-wrap:wrap;">

                {{-- FOTO --}}
                <div style="width:220px; min-height:260px; background:#c8e6c9; flex-shrink:0; overflow:hidden; display:flex; align-items:center; justify-content:center;">
                    @if($pembimbing->foto)
                        <img src="{{ asset('storage/' . $pembimbing->foto) }}"
                             alt="{{ $pembimbing->nama }}"
                             style="width:220px; height:100%; object-fit:cover; object-position:top center; display:block;">
                    @else
                        @php
                            $parts = explode(' ', $pembimbing->nama);
                            $inisial = strtoupper(substr($parts[0], 0, 1)) . (isset($parts[1]) ? strtoupper(substr($parts[1], 0, 1)) : '');
                        @endphp
                        <div style="font-size:64px; font-weight:700; color:#1b5e20;">{{ $inisial }}</div>
                    @endif
                </div>

                {{-- INFO --}}
                <div style="padding:1.5rem; flex:1; min-width:0;">
                    <span style="display:inline-block; background:#e8f5e9; color:#2e7d32; font-size:11px; font-weight:600; padding:4px 12px; border-radius:20px; margin-bottom:10px;">
                        {{ $pembimbing->bidang ?? 'Umum' }}
                    </span>
                    <div style="font-size:22px; font-weight:700; color:#1a1a1a; margin-bottom:4px;">
                        {{ $pembimbing->nama }}
                    </div>
                    <div style="font-size:13px; color:#777; margin-bottom:14px;">
                        Pendamping Profesional
                    </div>

                    @if($pembimbing->lokasi)
                    <div style="display:flex; align-items:center; gap:6px; font-size:13px; color:#555; margin-bottom:7px;">
                        <svg viewBox="0 0 20 20" fill="#4caf50" style="width:14px;height:14px;flex-shrink:0;">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                        </svg>
                        {{ $pembimbing->lokasi }}
                    </div>
                    @endif

                    @if($pembimbing->no_hp)
                    <div style="display:flex; align-items:center; gap:6px; font-size:13px; color:#555; margin-bottom:7px;">
                        <svg viewBox="0 0 20 20" fill="#4caf50" style="width:14px;height:14px;flex-shrink:0;">
                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                        </svg>
                        {{ $pembimbing->no_hp }}
                    </div>
                    @endif

                    @if($pembimbing->email)
                    <div style="display:flex; align-items:center; gap:6px; font-size:13px; color:#555; margin-bottom:7px;">
                        <svg viewBox="0 0 20 20" fill="#4caf50" style="width:14px;height:14px;flex-shrink:0;">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                        </svg>
                        {{ $pembimbing->email }}
                    </div>
                    @endif

                    {{-- RATING --}}
                    @php $rating = round($pembimbing->ulasan_avg_rating ?? 0); @endphp
                    <div style="display:flex; align-items:center; gap:3px; margin-top:12px;">
                        @for($i = 1; $i <= 5; $i++)
                            <span style="font-size:18px; color:{{ $i <= $rating ? '#f59e0b' : '#ddd' }};">★</span>
                        @endfor
                        <span style="font-size:15px; font-weight:600; color:#1a1a1a; margin-left:5px;">
                            {{ number_format($pembimbing->ulasan_avg_rating ?? 0, 1) }}
                        </span>
                        <span style="font-size:12px; color:#aaa; margin-left:3px;">
                            ({{ $pembimbing->ulasan_count ?? 0 }} Ulasan)
                        </span>
                    </div>

                    @if($pembimbing->no_hp)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pembimbing->no_hp) }}"
                       target="_blank"
                       style="display:inline-block; margin-top:16px; padding:9px 22px; background:#4caf50; color:#fff; border-radius:9px; font-size:13px; font-weight:500; text-decoration:none;">
                        Hubungi Pembimbing
                    </a>
                    @endif
                </div>

            </div>
        </div>

        {{-- TENTANG SAYA --}}
        @if($pembimbing->deskripsi)
        <div style="background:#fff; border-radius:16px; border:1px solid #e5e5e5; padding:1.2rem 1.4rem; margin-bottom:1.2rem;">
            <div style="font-size:14px; font-weight:600; color:#1b5e20; margin-bottom:10px; padding-bottom:8px; border-bottom:1px solid #f0f0f0;">
                Tentang Saya
            </div>
            <div style="font-size:13px; color:#555; line-height:1.8;">
                {{ $pembimbing->deskripsi }}
            </div>
        </div>
        @endif

        {{-- KEAHLIAN --}}
        @if($pembimbing->keahlian)
        <div style="background:#fff; border-radius:16px; border:1px solid #e5e5e5; padding:1.2rem 1.4rem; margin-bottom:1.2rem;">
            <div style="font-size:14px; font-weight:600; color:#1b5e20; margin-bottom:10px; padding-bottom:8px; border-bottom:1px solid #f0f0f0;">
                Keahlian
            </div>
            <div style="display:flex; flex-wrap:wrap; gap:7px;">
                @foreach(explode(',', $pembimbing->keahlian) as $keahlian)
                <span style="background:#e8f5e9; color:#2e7d32; font-size:12px; padding:5px 13px; border-radius:20px;">
                    {{ trim($keahlian) }}
                </span>
                @endforeach
            </div>
        </div>
        @endif

        {{-- ULASAN --}}
        <div style="background:#fff; border-radius:16px; border:1px solid #e5e5e5; padding:1.2rem 1.4rem; margin-bottom:1.2rem;">
            <div style="font-size:14px; font-weight:600; color:#1b5e20; margin-bottom:10px; padding-bottom:8px; border-bottom:1px solid #f0f0f0;">
                Ulasan ({{ $pembimbing->ulasan_count ?? 0 }})
            </div>

            @forelse($ulasan as $item)
            <div style="padding:12px 0; border-bottom:1px solid #f5f5f5;">
                <div style="display:flex; align-items:center; gap:8px; margin-bottom:5px;">
                    <div style="width:32px; height:32px; border-radius:50%; background:#c8e6c9; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:600; color:#1b5e20; flex-shrink:0;">
                        {{ strtoupper(substr($item->user->name ?? 'U', 0, 1)) }}
                    </div>
                    <div>
                        <div style="font-size:13px; font-weight:600; color:#333;">{{ $item->user->name ?? 'Pengguna' }}</div>
                        <div>
                            @for($i = 1; $i <= 5; $i++)
                                <span style="font-size:12px; color:{{ $i <= $item->rating ? '#f59e0b' : '#ddd' }};">★</span>
                            @endfor
                        </div>
                    </div>
                    <div style="font-size:11px; color:#aaa; margin-left:auto;">
                        {{ $item->created_at->format('d M Y') }}
                    </div>
                </div>
                <div style="font-size:12px; color:#666; line-height:1.6; padding-left:40px;">
                    {{ $item->komentar }}
                </div>
            </div>
            @empty
            <div style="text-align:center; padding:2rem; color:#aaa; font-size:13px;">
                Belum ada ulasan untuk pembimbing ini.
            </div>
            @endforelse
        </div>

        {{-- FORM ULASAN --}}
        @auth
            @if(!$sudahUlasan)
            <div style="background:#fff; border-radius:16px; border:1px solid #e5e5e5; padding:1.2rem 1.4rem; margin-bottom:1.2rem;">
                <div style="font-size:14px; font-weight:600; color:#1b5e20; margin-bottom:10px; padding-bottom:8px; border-bottom:1px solid #f0f0f0;">
                    Tulis Ulasan
                </div>

                @if(session('success'))
                <div style="background:#e8f5e9; color:#2e7d32; padding:10px 14px; border-radius:8px; font-size:13px; margin-bottom:12px;">
                    {{ session('success') }}
                </div>
                @endif

                <form action="{{ route('pelatihan.pembimbing.ulasan', $pembimbing->id) }}" method="POST">
                    @csrf

                    <div style="margin-bottom:14px;">
                        <div style="font-size:13px; color:#555; margin-bottom:6px;">Rating</div>
                        <div style="display:flex; gap:6px;">
                            @for($i = 1; $i <= 5; $i++)
                            <span data-value="{{ $i }}"
                                  onclick="setRating({{ $i }})"
                                  style="font-size:28px; cursor:pointer; color:#ddd; transition:color 0.15s;"
                                  class="star-input">★</span>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" id="ratingInput" value="">
                        @error('rating')
                            <div style="font-size:12px; color:#e53935; margin-top:4px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div style="margin-bottom:14px;">
                        <div style="font-size:13px; color:#555; margin-bottom:6px;">Komentar</div>
                        <textarea name="komentar" rows="3"
                            placeholder="Ceritakan pengalaman Anda bersama pembimbing ini..."
                            style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:10px; font-size:13px; color:#333; resize:vertical; outline:none; font-family:inherit;">{{ old('komentar') }}</textarea>
                        @error('komentar')
                            <div style="font-size:12px; color:#e53935; margin-top:4px;">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit"
                        style="padding:9px 24px; background:#4caf50; color:#fff; border:none; border-radius:9px; font-size:13px; font-weight:500; cursor:pointer;">
                        Kirim Ulasan
                    </button>
                </form>
            </div>
            @else
            <div style="background:#e8f5e9; border-radius:12px; padding:14px; text-align:center; font-size:13px; color:#2e7d32; margin-bottom:1.2rem;">
                Anda sudah memberikan ulasan untuk pembimbing ini.
            </div>
            @endif
        @else
        <div style="background:#fff; border-radius:16px; border:1px solid #e5e5e5; padding:1.2rem 1.4rem; text-align:center; margin-bottom:1.2rem;">
            <div style="font-size:13px; color:#777; margin-bottom:10px;">Login untuk memberikan ulasan</div>
            <a href="{{ route('login') }}"
               style="padding:8px 20px; background:#4caf50; color:#fff; border-radius:8px; font-size:13px; text-decoration:none;">
                Login Sekarang
            </a>
        </div>
        @endauth

    </div>
</div>

@endsection

@push('scripts')
<script>
function setRating(val) {
    document.getElementById('ratingInput').value = val;
    document.querySelectorAll('.star-input').forEach(function(el) {
        el.style.color = parseInt(el.dataset.value) <= val ? '#f59e0b' : '#ddd';
    });
}

document.querySelectorAll('.star-input').forEach(function(el) {
    el.addEventListener('mouseover', function() {
        var val = parseInt(this.dataset.value);
        document.querySelectorAll('.star-input').forEach(function(s) {
            s.style.color = parseInt(s.dataset.value) <= val ? '#f59e0b' : '#ddd';
        });
    });
    el.addEventListener('mouseout', function() {
        var current = parseInt(document.getElementById('ratingInput').value) || 0;
        document.querySelectorAll('.star-input').forEach(function(s) {
            s.style.color = parseInt(s.dataset.value) <= current ? '#f59e0b' : '#ddd';
        });
    });
});
</script>
@endpush