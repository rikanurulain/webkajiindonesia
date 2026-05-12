@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-10">
    <div class="max-w-6xl mx-auto px-4">
        
        <!-- Header -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Profil Saya</h1>
                <p class="text-gray-500 text-sm">Kelola informasi profil dan keamanan akun Anda.</p>
            </div>
            <a href="{{ route('home') }}" 
               class="flex items-center gap-2 px-4 py-2 text-sm font-semibold text-emerald-700 border border-emerald-600 rounded-xl hover:bg-emerald-50 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Beranda
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Kolom Kiri: Foto Profil & Tombol Trainer -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold mb-6 pb-2 border-b">Foto Profil</h3>
                    <div class="flex flex-col items-center">
                        <div class="w-full aspect-[3/4] bg-gray-100 rounded-lg overflow-hidden mb-4 border border-gray-200 flex items-center justify-center">
                            @if($user->profile_photo_path)
                                <img id="preview-foto" src="{{ asset('storage/' . $user->profile_photo_path) }}" class="w-full h-full object-cover">
                            @else
                                <div id="preview-placeholder" class="text-6xl font-bold text-emerald-600 uppercase">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <img id="preview-foto" src="" class="w-full h-full object-cover hidden">
                            @endif
                        </div>

                        <form action="{{ route('profile.update-photo') }}" method="POST" enctype="multipart/form-data" class="w-full">
                            @csrf
                            <input type="file" name="photo" id="input-foto"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 
                                       file:rounded-md file:border-0 file:text-sm file:font-semibold 
                                       file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 mb-4"
                                accept="image/*">
                            <button type="submit" class="w-full py-2 text-sm font-medium text-emerald-700 border border-emerald-600 rounded-md hover:bg-emerald-50 transition">
                                Update Foto
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Box Status / Daftar Role -->
                @if($user->role !== 'trainer')
                <div class="mt-6">
                    <div class="p-6 rounded-xl text-white shadow-md transition-all duration-300
                        @if($user->trainer_status == 'pending') bg-amber-500 
                        @elseif($user->trainer_status == 'approved') bg-emerald-800 
                        @elseif($user->trainer_status == 'rejected') bg-red-600 
                        @else bg-emerald-700 @endif">

                        @if($user->trainer_status == 'pending')
                            <!-- TAMPILAN SAAT MENUNGGU VERIFIKASI -->
                            <div class="flex items-center gap-3 mb-3">
                                <div class="p-2 bg-white/20 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h4 class="font-bold text-lg leading-tight">Pendaftaran Sedang Ditinjau</h4>
                            </div>
                            <p class="text-xs text-amber-50 leading-relaxed mb-4">
                                Dokumen Anda telah kami terima. Tim Admin sedang melakukan verifikasi data pendaftaran Anda.
                            </p>
                            <div class="py-2 px-3 bg-black/10 rounded-lg border border-white/20 text-center">
                                <span class="text-[10px] uppercase tracking-wider font-black">Status: Menunggu Persetujuan</span>
                            </div>

                        @elseif($user->trainer_status == 'approved')
                            <!-- TAMPILAN SAAT SUDAH DISETUJUI -->
                            <div class="flex items-center gap-3 mb-2">
                                <div class="p-1 bg-white rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-800" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <h4 class="font-bold text-lg">Anda adalah Trainer!</h4>
                            </div>
                            <p class="text-xs text-emerald-100 leading-relaxed">
                                Selamat! Akun Anda telah diverifikasi. Anda sekarang dapat mulai memberikan pendampingan UMKM.
                            </p>

                        @elseif($user->trainer_status == 'rejected')
                            <!-- TAMPILAN SAAT DITOLAK -->
                            <h4 class="font-bold mb-2 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                Pendaftaran Ditolak
                            </h4>
                            <p class="text-xs text-red-50 mb-4">
                                Mohon maaf, data Anda belum memenuhi syarat. Silakan periksa kembali dokumen Anda dan daftar ulang.
                            </p>
                            <a href="{{ route('profile.daftar-trainer') }}" class="block w-full bg-white text-red-600 py-2 rounded-lg font-bold text-sm text-center hover:bg-gray-100 transition">
                                Daftar Ulang
                            </a>

                        @else
                            <!-- TAMPILAN AWAL (BELUM DAFTAR) -->
                            <h4 class="font-bold mb-2">Ingin Bergabung?</h4>
                            <p class="text-xs text-emerald-100 mb-4 leading-relaxed">
                                Pilih peran Anda di Kaji Indonesia.
                            </p>

                            <!-- Card UMKM -->
                            <div class="bg-emerald-600 rounded-xl p-4 mb-3">
                                <h5 class="font-bold text-sm mb-1">Bergabunglah sebagai UMKM</h5>
                                <p class="text-xs text-emerald-100 mb-3 leading-relaxed">
                                    Bergabunglah sebagai bagian dari mitra UMKM KAJI INDONESIA
                                </p>
                                <a href="{{ route('profile.daftar-umkm') }}" 
                                   class="block w-full bg-white text-emerald-700 py-2 rounded-lg font-bold text-sm text-center hover:bg-gray-100 transition shadow-sm">
                                    Daftar Sekarang
                                </a>
                            </div>

                            <!-- Card Mentor -->
                            <div class="bg-emerald-600 rounded-xl p-4 mb-3">
                                <h5 class="font-bold text-sm mb-1">Bergabunglah sebagai Mentor</h5>
                                <p class="text-xs text-emerald-100 mb-3 leading-relaxed">
                                    Bergabunglah sebagai pembimbing dan fasilitator UMKM
                                </p>
                                <a href="{{ route('profile.daftar-mentor') }}" 
                                   class="block w-full bg-white text-emerald-700 py-2 rounded-lg font-bold text-sm text-center hover:bg-gray-100 transition shadow-sm">
                                    Daftar Sekarang
                                </a>
                            </div>

                            <!-- Card Trainer -->
                            <div class="bg-emerald-600 rounded-xl p-4">
                                <h5 class="font-bold text-sm mb-1">Bergabunglah sebagai Trainer</h5>
                                <p class="text-xs text-emerald-100 mb-3 leading-relaxed">
                                    Bergabunglah sebagai pengajar profesional di KAJI INDONESIA
                                </p>
                                <a href="{{ route('profile.daftar-trainer') }}" 
                                   class="block w-full bg-white text-emerald-700 py-2 rounded-lg font-bold text-sm text-center hover:bg-gray-100 transition shadow-sm">
                                    Daftar Sekarang
                                </a>
                            </div>
                        @endif

                    </div>
                </div>
                @endif
            </div>

            <!-- Kolom Kanan: Informasi Akun -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
                    <h3 class="text-lg font-semibold mb-6 pb-2 border-b">Informasi Akun</h3>
                    
                    <form action="{{ route('profile.update') }}" method="POST" class="space-y-5">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                            <input type="text" value="{{ $user->username }}" disabled class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-gray-500 cursor-not-allowed">
                        </div>

                        <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                        <input type="text" 
                        name="username" 
                        value="{{ old('username', $user->username) }}" 
                        class="w-full px-4 py-2 bg-white border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-emerald-500">
    
                            @error('username')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama *</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon *</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat (opsional)</label>
                            <textarea name="address" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-emerald-500">{{ old('address', $user->address) }}</textarea>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="w-full bg-emerald-600 text-white py-3 rounded-lg font-bold hover:bg-emerald-700 transition flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                </svg>
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Box Ubah Password -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
                    <h3 class="text-lg font-semibold mb-6 pb-2 border-b">Ubah Password</h3>

                    @if(session('success'))
                        <div class="mb-4 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm rounded-lg">
                            ✅ {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->has('current_password'))
                        <div class="mb-4 px-4 py-3 bg-red-50 border border-red-200 text-red-600 text-sm rounded-lg">
                            ❌ {{ $errors->first('current_password') }}
                        </div>
                    @endif

                    <form action="{{ route('profile.update-password') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Password Saat Ini</label>
                            <input type="password" name="current_password"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-emerald-500"
                                placeholder="Masukkan password lama">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                                <input type="password" name="password"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-emerald-500"
                                    placeholder="Minimal 8 karakter">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg outline-none focus:ring-2 focus:ring-emerald-500"
                                    placeholder="Ulangi password baru">
                            </div>
                        </div>
                        <button type="submit" class="mt-2 text-sm font-bold text-emerald-700 hover:text-emerald-800 transition">
                            Update Password →
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('input-foto').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function(event) {
            const preview = document.getElementById('preview-foto');
            const placeholder = document.getElementById('preview-placeholder');

            preview.src = event.target.result;
            preview.classList.remove('hidden');

            if (placeholder) placeholder.style.display = 'none';
        };
        reader.readAsDataURL(file);
    });
</script>
@endsection