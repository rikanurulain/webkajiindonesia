@extends('layouts.app')

@section('content')
<section class="min-h-[60vh] bg-gray-50 py-16">
    <div class="mx-auto max-w-md px-4 sm:px-6 lg:px-8">
        <div class="rounded-2xl bg-white p-8 shadow-lg ring-1 ring-gray-200/50">
            
            <h1 class="font-serif text-2xl font-bold text-gray-900">Daftar</h1>
            <p class="mt-2 text-sm text-gray-600">Buat akun untuk mengakses layanan kami.</p>

            {{-- SUCCESS MESSAGE --}}
            @if(session('success'))
                <div class="mt-4 text-green-600 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- ERROR MESSAGE --}}
            @if ($errors->any())
                <div class="mt-4 bg-red-500 text-white p-3 rounded">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>- {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="mt-6 space-y-4" action="{{ route('register') }}" method="POST" novalidate>
                @csrf

                {{-- NAME --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <input type="text" name="name"
                        value="{{ old('name') }}"
                        class="mt-1 w-full rounded-xl border border-gray-300 px-4 py-2.5">
                </div>

                {{-- EMAIL --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email"
                        value="{{ old('email') }}"
                        class="mt-1 w-full rounded-xl border border-gray-300 px-4 py-2.5">
                </div>

                {{-- PHONE --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                    <input type="text" name="phone"
                        value="{{ old('phone') }}"
                        class="mt-1 w-full rounded-xl border border-gray-300 px-4 py-2.5">
                </div>

                {{-- PASSWORD --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password"
                        class="mt-1 w-full rounded-xl border border-gray-300 px-4 py-2.5">
                </div>

                {{-- PASSWORD CONFIRM --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation"
                        class="mt-1 w-full rounded-xl border border-gray-300 px-4 py-2.5">
                </div>

                {{-- BUTTON --}}
                <button type="submit"
                    class="w-full rounded-xl bg-blue-600 py-3 font-semibold text-white hover:bg-blue-700">
                    Daftar
                </button>
            </form>

            <p class="mt-4 text-center text-sm text-gray-600">
                Sudah punya akun? 
                <a href="/login" class="font-semibold text-blue-600 hover:underline">Masuk</a>
            </p>

        </div>
    </div>
</section>
@endsection