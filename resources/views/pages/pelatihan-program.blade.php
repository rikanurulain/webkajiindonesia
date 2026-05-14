@extends('layouts.app')

@section('title', 'Program Pelatihan - KAJI Indonesia')

@section('content')

    {{-- Hero --}}
    <section class="bg-gradient-to-br from-primary-dark via-primary to-primary- py-16 text-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="max-w-2xl">
                <h1 class="font-serif text-4xl font-bold sm:text-5xl">PROGRAM KAMI LATIH</h1>
                <p class="mt-4 text-lg text-white/90">Kurikulum dan materi pelatihan untuk penguatan kapasitas Usaha.</p>
            </div>
            <div>
                <img src="{{ asset('storage/logo/KAMILATIH.png') }}" alt="Logo Karya Kami" class="w-64 md:w-80 object-contain">
            </div>
        </div>
    </section>

    <section class="bg-gray-50 py-16 px-6 min-h-screen">

        <h2 class="font-serif text-center text-3xl font-bold text-gray-900 sm:text-4xl mb-6">
            Kurikulum Pelatihan UMKM
        </h2>

        {{-- Search Bar (Live Search, tanpa form submit) --}}
        <div class="max-w-xl mx-auto mb-10">
            <div class="flex gap-2 items-center">
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-3 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                        </svg>
                    </span>
                    <input
                        id="live-search-input"
                        type="text"
                        placeholder="Cari nama kurikulum..."
                        class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 bg-white text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500"
                        autocomplete="off"
                    >
                </div>
                <span id="search-count" class="text-sm text-gray-400 whitespace-nowrap px-1"></span>
            </div>
        </div>

        {{-- Semua Kartu (hidden, dikelola JavaScript) --}}
        <div id="all-cards-data" class="hidden">
            @foreach($programsDB as $program)
            <div
                class="program-card-data"
                data-id="{{ $program->id }}"
                data-title="{{ strtolower($program->judul) }}"
                data-desc="{{ strtolower($program->deskripsi ?? '') }}"
                data-judul="{{ $program->judul }}"
                data-deskripsi="{{ Str::limit($program->deskripsi, 80) }}"
                data-gambar="{{ $program->gambar ? asset('storage/' . $program->gambar) : '' }}"
                data-trainer="{{ $program->trainer ? ($program->trainer->academic_degree ?? $program->trainer->name) : '' }}"
                data-phone="{{ !empty($program->phone) ? $program->phone : (!empty($program->trainer->phone) ? $program->trainer->phone : '6281234567890') }}"
                data-detail-url="{{ route('pelatihan.detail', $program->id) }}"
            ></div>
            @endforeach
        </div>

        {{-- Grid Kartu (dirender oleh JS) --}}
        <div id="program-grid" class="max-w-6xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-8">
            {{-- Kartu diisi oleh JavaScript --}}
        </div>

        {{-- Empty State --}}
        <div id="empty-state" class="hidden max-w-6xl mx-auto text-center py-20 text-gray-400">
            <div class="text-5xl mb-4">🔍</div>
            <p id="empty-message" class="text-lg font-semibold text-gray-500">Belum ada kurikulum tersedia.</p>
        </div>

        {{-- Pagination --}}
        <div id="pagination-wrapper" class="max-w-6xl mx-auto mt-6 flex flex-col sm:flex-row items-center justify-between gap-4">

            {{-- Info halaman --}}
            <p id="pagination-info" class="text-sm text-gray-500 order-2 sm:order-1"></p>

            {{-- Tombol prev/next/angka --}}
            <div id="pagination-controls" class="flex items-center gap-1 order-1 sm:order-2"></div>

        </div>

    </section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ── Konfigurasi ──────────────────────────────────────────
    const PER_PAGE = 8; // jumlah kartu per halaman

    // ── Ambil semua data dari DOM ────────────────────────────
    const rawNodes = document.querySelectorAll('.program-card-data');
    const allPrograms = Array.from(rawNodes).map(el => ({
        id:        el.dataset.id,
        title:     el.dataset.title,
        desc:      el.dataset.desc,
        judul:     el.dataset.judul,
        deskripsi: el.dataset.deskripsi,
        gambar:    el.dataset.gambar,
        trainer:   el.dataset.trainer,
        phone:     el.dataset.phone,
        detailUrl: el.dataset.detailUrl,
    }));

    // ── State ────────────────────────────────────────────────
    let filtered   = [...allPrograms];
    let currentPage = 1;

    // ── Elemen ──────────────────────────────────────────────
    const grid       = document.getElementById('program-grid');
    const emptyState = document.getElementById('empty-state');
    const emptyMsg   = document.getElementById('empty-message');
    const countEl    = document.getElementById('search-count');
    const infoEl     = document.getElementById('pagination-info');
    const ctrlEl     = document.getElementById('pagination-controls');
    const searchInput = document.getElementById('live-search-input');

    // ── Build card HTML ──────────────────────────────────────
    function buildCard(p) {
        const imgHtml = p.gambar
            ? `<img src="${p.gambar}" alt="${p.judul}" class="w-full h-full object-cover">`
            : `<span class="text-5xl">🎓</span>`;

        const trainerHtml = p.trainer
            ? `<p class="text-xs text-gray-400 text-center mt-2">oleh ${p.trainer}</p>`
            : '';

        const waText = encodeURIComponent(`Halo, saya ingin tahu lebih lanjut tentang ${p.judul}`);

        return `
        <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-200 flex flex-col duration-300 hover:shadow-lg hover:-translate-y-1">
            <div class="w-full h-44 flex items-center justify-center overflow-hidden bg-green-50">
                ${imgHtml}
            </div>
            <div class="bg-green-100 px-4 py-2">
                <h3 class="font-serif font-bold text-gray-900 text-lg text-center">${p.judul}</h3>
            </div>
            <div class="px-4 py-3 flex-1">
                <p class="text-sm text-gray-600 text-center leading-relaxed">${p.deskripsi}</p>
                ${trainerHtml}
            </div>
            <div class="grid grid-cols-2">
                <a href="https://wa.me/${p.phone}?text=${waText}"
                   target="_blank"
                   class="bg-green-500 hover:bg-green-600 text-white text-sm font-semibold text-center py-3 transition-colors duration-200">
                    WhatsApp
                </a>
                <a href="${p.detailUrl}"
                   class="bg-orange-400 hover:bg-orange-500 text-gray-900 text-sm font-semibold text-center py-3 transition-colors duration-200">
                    Detail
                </a>
            </div>
        </div>`;
    }

    // ── Render kartu sesuai halaman ──────────────────────────
    function renderPage() {
        const totalPages = Math.ceil(filtered.length / PER_PAGE);
        if (currentPage > totalPages) currentPage = totalPages || 1;

        const start = (currentPage - 1) * PER_PAGE;
        const slice = filtered.slice(start, start + PER_PAGE);

        if (filtered.length === 0) {
            grid.classList.add('hidden');
            emptyState.classList.remove('hidden');
            emptyMsg.textContent = searchInput.value.trim()
                ? `Kurikulum "${searchInput.value.trim()}" tidak ditemukan.`
                : 'Belum ada kurikulum tersedia.';
            countEl.textContent = '';
            infoEl.textContent  = '';
            ctrlEl.innerHTML    = '';
            return;
        }

        grid.classList.remove('hidden');
        emptyState.classList.add('hidden');
        grid.innerHTML = slice.map(buildCard).join('');

        // Info
        countEl.textContent = `${filtered.length} kurikulum`;
        infoEl.textContent  = `Halaman ${currentPage} dari ${totalPages} · Menampilkan ${start + 1}–${Math.min(start + PER_PAGE, filtered.length)} dari ${filtered.length} kurikulum`;

        // Tombol pagination
        renderPagination(totalPages);

        // Scroll halus ke atas grid
        grid.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    // ── Render tombol pagination ─────────────────────────────
    function renderPagination(totalPages) {
        if (totalPages <= 1) { ctrlEl.innerHTML = ''; return; }

        const btnBase   = 'inline-flex items-center justify-center w-9 h-9 rounded-lg text-sm font-semibold transition-colors duration-150 border';
        const btnActive = 'bg-green-600 text-white border-green-600';
        const btnNormal = 'bg-white text-gray-700 border-gray-200 hover:bg-green-50 hover:border-green-400';
        const btnDisabled = 'bg-white text-gray-300 border-gray-100 cursor-not-allowed';

        let html = '';

        // Prev
        html += `<button
            class="${btnBase} ${currentPage === 1 ? btnDisabled : btnNormal}"
            ${currentPage === 1 ? 'disabled' : ''}
            onclick="goPage(${currentPage - 1})"
            aria-label="Halaman sebelumnya">
            ‹
        </button>`;

        // Angka halaman (dengan ellipsis)
        const pages = getPageNumbers(currentPage, totalPages);
        pages.forEach(p => {
            if (p === '...') {
                html += `<span class="${btnBase} border-transparent text-gray-400 cursor-default">…</span>`;
            } else {
                html += `<button
                    class="${btnBase} ${p === currentPage ? btnActive : btnNormal}"
                    onclick="goPage(${p})"
                    aria-label="Halaman ${p}"
                    ${p === currentPage ? 'aria-current="page"' : ''}>
                    ${p}
                </button>`;
            }
        });

        // Next
        html += `<button
            class="${btnBase} ${currentPage === totalPages ? btnDisabled : btnNormal}"
            ${currentPage === totalPages ? 'disabled' : ''}
            onclick="goPage(${currentPage + 1})"
            aria-label="Halaman berikutnya">
            ›
        </button>`;

        ctrlEl.innerHTML = html;
    }

    // ── Hitung nomor halaman yang ditampilkan ────────────────
    function getPageNumbers(current, total) {
        if (total <= 7) return Array.from({ length: total }, (_, i) => i + 1);
        const pages = [];
        if (current <= 4) {
            pages.push(1, 2, 3, 4, 5, '...', total);
        } else if (current >= total - 3) {
            pages.push(1, '...', total-4, total-3, total-2, total-1, total);
        } else {
            pages.push(1, '...', current-1, current, current+1, '...', total);
        }
        return pages;
    }

    // ── Global handler untuk tombol pagination ───────────────
    window.goPage = function (page) {
        const totalPages = Math.ceil(filtered.length / PER_PAGE);
        if (page < 1 || page > totalPages) return;
        currentPage = page;
        renderPage();
    };

    // ── Live search dengan debounce ──────────────────────────
    let debounceTimer;
    searchInput.addEventListener('input', function () {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            const q = this.value.trim().toLowerCase();
            filtered = q
                ? allPrograms.filter(p => p.title.includes(q) || p.desc.includes(q))
                : [...allPrograms];
            currentPage = 1;
            renderPage();
        }, 300);
    });

    // ── Render awal ──────────────────────────────────────────
    renderPage();
});
</script>
@endpush