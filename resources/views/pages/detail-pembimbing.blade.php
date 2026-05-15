@extends('layouts.app')

@section('content')
<div class="container py-16 mx-auto px-6">
    <div class="max-w-4xl mx-auto bg-white rounded-3xl shadow-sm border p-8 flex flex-col md:flex-row gap-8">
        <div class="w-full md:w-1/3">
            @if($mentor->white_bg_photo)
                <img src="{{ asset('storage/' . $mentor->white_bg_photo) }}" class="rounded-2xl w-full object-cover">
            @else
                <div class="w-full h-64 bg-gray-100 flex items-center justify-center rounded-2xl text-4xl font-bold text-emerald-700">
                    {{ strtoupper(substr($mentor->full_name ?? 'ME', 0, 2)) }}
                </div>
            @endif
        </div>
        <div class="flex-1">
            <h1 class="text-3xl font-bold text-gray-900">{{ $mentor->full_name ?? 'Mentor' }}</h1>
            <p class="text-emerald-600 font-bold uppercase mb-4">{{ $mentor->role ?? 'Mentor' }}</p>
            
            <div class="space-y-4 text-gray-700">
                <p><strong>Lokasi:</strong> {{ $mentor->lokasi ?? $mentor->gmaps_location ?? '-' }}</p>
                @if($mentor->bio)
                <p><strong>Bio:</strong> {{ $mentor->bio }}</p>
                @endif
                @if($mentor->email)
                <p><strong>Email:</strong> {{ $mentor->email }}</p>
                @endif
            </div>

            @if($mentor->phone)
            <div class="mt-8">
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $mentor->phone) }}" target="_blank" class="bg-emerald-600 text-white px-8 py-3 rounded-full font-bold">
                    Hubungi Mentor
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection