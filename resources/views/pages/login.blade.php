@extends('layouts.app')

@section('content')
    <section class="min-h-[60vh] bg-gray-50 py-16">
        <div class="mx-auto max-w-md px-4 sm:px-6 lg:px-8">
            <div class="rounded-2xl bg-white p-8 shadow-lg ring-1 ring-gray-200/50">
                
                <h1 class="font-serif text-2xl font-bold text-gray-900">Masuk</h1>
                <p class="mt-2 text-sm text-gray-600">Gunakan akun Anda untuk masuk.</p>

                {{-- SUCCESS MESSAGE --}}
                @if(session('success'))
                    <div class="mt-4 text-green-600 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- ERROR MESSAGE --}}
                @if(session('error'))
                    <div class="mt-4 text-red-600 text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- VALIDATION ERROR --}}
                @if($errors->any())
                    <div class="mt-4 text-red-600 text-sm">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>- {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="mt-6 space-y-4" action="/login" method="POST">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            required 
                            value="{{ old('email') }}"
                            class="mt-1 w-full rounded-xl border border-gray-300 px-4 py-2.5 focus:border-primary focus:ring-primary">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            required 
                            class="mt-1 w-full rounded-xl border border-gray-300 px-4 py-2.5 focus:border-primary focus:ring-primary">
                    </div>

                    <button 
                        type="submit" 
                        class="w-full rounded-xl bg-primary py-3 font-semibold text-white hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                        Masuk
                    </button>
                </form>

                <p class="mt-4 text-center text-sm text-gray-600">
                    Belum punya akun? 
                    <a href="/register" class="font-semibold text-primary hover:underline">Daftar</a>
                </p>

            </div>
        </div>
    </section>
@endsection