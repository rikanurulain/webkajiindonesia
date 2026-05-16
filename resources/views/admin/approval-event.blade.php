@extends('layouts.admin')

@section('page-title', 'Approval Event')

@section('content')

<div class="max-w-6xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            📅 Approval Event
        </h1>
        <span class="text-sm text-gray-500">{{ now()->translatedFormat('l, d F Y') }}</span>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm font-semibold">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- Tab Status --}}
    <div class="flex gap-2 mb-6">
        @foreach(['pending' => 'Pending', 'approved' => 'Disetujui', 'rejected' => 'Ditolak'] as $val => $label)
            <a href="{{ route('admin.approval.event', ['status' => $val]) }}"
               class="px-5 py-2 rounded-full text-sm font-semibold border transition-all
                      {{ $status === $val
                          ? 'bg-green-700 text-white border-green-700'
                          : 'bg-white text-gray-600 border-gray-200 hover:border-green-400' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    {{-- Daftar Event --}}
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="p-4 border-b border-gray-100 flex items-center gap-2">
            <span class="text-lg">📅</span>
            <span class="font-bold text-gray-800">Daftar Event</span>
            <span class="text-sm text-gray-400">{{ $events->count() }} event</span>
        </div>

        {{-- Thead --}}
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                    <th class="text-left px-5 py-3">Event</th>
                    <th class="text-left px-5 py-3">Pembimbing</th>
                    <th class="text-left px-5 py-3">Lokasi</th>
                    <th class="text-left px-5 py-3">Tanggal</th>
                    <th class="text-left px-5 py-3">Kapasitas</th>
                    <th class="text-left px-5 py-3">Status</th>
                    <th class="text-left px-5 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($events as $event)
                <tr class="hover:bg-gray-50 transition-colors">
                    {{-- Nama event + biaya --}}
                    <td class="px-5 py-4">
                        <div class="font-semibold text-gray-900 text-sm">{{ $event->judul }}</div>
                        <div class="text-xs text-gray-400 mt-0.5 flex items-center gap-1">
                            @if($event->biaya_label === 'Gratis')
                                <span class="text-green-600 font-semibold">✅ Gratis</span>
                            @else
                                <span class="text-orange-600 font-semibold">💰 {{ $event->biaya_label }}</span>
                            @endif
                        </div>
                    </td>

                    {{-- Trainer --}}
                    <td class="px-5 py-4 text-sm text-gray-600">
                        {{ $event->trainer?->name ?? '-' }}
                    </td>

                    {{-- Lokasi --}}
                    <td class="px-5 py-4 text-sm text-gray-600">{{ $event->lokasi ?? '-' }}</td>

                    {{-- Tanggal + Waktu --}}
                    <td class="px-5 py-4 text-sm text-gray-600">
                        {{ \Carbon\Carbon::parse($event->tanggal)->translatedFormat('d M Y') }}
                        @if($event->waktu_mulai)
                            <div class="text-xs text-gray-400">{{ $event->jam }}</div>
                        @endif
                    </td>

                    {{-- Kapasitas --}}
                    <td class="px-5 py-4 text-sm text-gray-600">
                        {{ $event->kapasitas ? $event->kapasitas . ' orang' : '-' }}
                    </td>

                    {{-- Status --}}
                    <td class="px-5 py-4">
                        @if($event->status === 'approved')
                            <span class="inline-flex items-center gap-1 bg-green-50 text-green-700 border border-green-200 text-xs font-bold px-3 py-1 rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500 inline-block"></span> Disetujui
                            </span>
                        @elseif($event->status === 'rejected')
                            <span class="inline-flex items-center gap-1 bg-red-50 text-red-600 border border-red-200 text-xs font-bold px-3 py-1 rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500 inline-block"></span> Ditolak
                            </span>
                            @if($event->catatan_admin)
                                <div class="text-xs text-red-500 mt-1 italic max-w-xs">{{ $event->catatan_admin }}</div>
                            @endif
                        @else
                            <span class="inline-flex items-center gap-1 bg-yellow-50 text-yellow-700 border border-yellow-200 text-xs font-bold px-3 py-1 rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-yellow-400 inline-block"></span> Pending
                            </span>
                        @endif
                    </td>

                    {{-- Aksi --}}
                    <td class="px-5 py-4">
                        @if($event->status === 'pending')
                        <div class="flex gap-2">
                            {{-- Approve --}}
                            <form action="{{ route('admin.event.approve', $event->id) }}" method="POST"
                                  onsubmit="return confirm('Setujui event ini?')">
                                @csrf
                                <button type="submit"
                                        class="bg-green-600 hover:bg-green-700 text-white text-xs font-bold px-3 py-1.5 rounded-lg transition-colors">
                                    ✅ Setujui
                                </button>
                            </form>

                            {{-- Tolak (buka modal) --}}
                            <button type="button"
                                    onclick="bukaModalTolak({{ $event->id }}, '{{ addslashes($event->judul) }}')"
                                    class="bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 text-xs font-bold px-3 py-1.5 rounded-lg transition-colors">
                                ❌ Tolak
                            </button>
                        </div>
                        @else
                            <span class="text-xs text-gray-400">—</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-20 text-gray-400">
                        <div class="text-4xl mb-3">🎉</div>
                        <div class="font-semibold text-gray-500">Tidak ada event dengan status ini</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ── Modal Tolak ─────────────────────────────────────────────── --}}
<div id="modal-tolak" class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-md shadow-2xl p-6">
        <h2 class="text-lg font-bold text-gray-900 mb-1">Tolak Event</h2>
        <p class="text-sm text-gray-500 mb-5">Berikan catatan alasan penolakan untuk dikirim ke trainer.</p>

        <form id="form-tolak" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">
                    Nama Event
                </label>
                <div id="tolak-nama" class="text-sm font-semibold text-gray-800 bg-gray-50 rounded-lg px-3 py-2 border border-gray-200"></div>
            </div>
            <div class="mb-5">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">
                    Catatan / Alasan Penolakan <span class="text-red-500">*</span>
                </label>
                <textarea name="catatan_admin" rows="4" required
                          class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-green-500 resize-none"
                          placeholder="Jelaskan alasan penolakan event ini..."></textarea>
            </div>
            <div class="flex justify-end gap-3">
                <button type="button" onclick="tutupModalTolak()"
                        class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-200 transition-colors">
                    Batal
                </button>
                <button type="submit"
                        class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-bold rounded-lg transition-colors">
                    Kirim Penolakan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function bukaModalTolak(id, nama) {
    document.getElementById('tolak-nama').textContent     = nama;
    document.getElementById('form-tolak').action          = '/admin/event/' + id + '/reject';
    document.getElementById('modal-tolak').classList.remove('hidden');
}
function tutupModalTolak() {
    document.getElementById('modal-tolak').classList.add('hidden');
    document.getElementById('form-tolak').reset();
}
document.getElementById('modal-tolak').addEventListener('click', function(e) {
    if (e.target === this) tutupModalTolak();
});
</script>

@endsection