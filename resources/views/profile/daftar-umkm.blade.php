@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-10">
    <div class="max-w-4xl mx-auto px-4">
        
        <div class="mb-6">
            <a href="{{ route('profile') }}" class="inline-flex items-center text-sm font-medium text-emerald-700 hover:text-emerald-800 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Profil
            </a>
        </div>

        <div class="bg-emerald-700 px-8 py-10 text-white text-center">
            <h2 class="text-3xl font-bold">Formulir Pendaftaran Mitra UMKM</h2>
            <p class="text-emerald-50 text-sm mt-2">Lengkapi data di bawah ini dengan benar untuk ditinjau oleh Admin.</p>
        </div>

            <form action="{{ route('profile.simpan-umkm') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Toko / Usaha *</label>
                        <input type="text" name="nama" required value="{{ old('nama') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition" 
                               placeholder="Contoh: Batik Nusantara">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Kategori Usaha *</label>
                        <select name="kategori" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition">
                            <option value="">Pilih Kategori</option>
                            <option value="Kuliner">Kuliner</option>
                            <option value="Fashion">Fashion</option>
                            <option value="Kerajinan">Kerajinan</option>
                            <option value="Pertanian">Pertanian</option>
                            <option value="Jasa">Jasa</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Pemilik (Owner) *</label>
                        <input type="text" name="owner" required value="{{ old('owner') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Kontak WhatsApp *</label>
                        <input type="text" name="kontak" required value="{{ old('kontak') }}"
                               placeholder="Contoh: 628123456789"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition">
                        <p class="text-[10px] text-gray-400 mt-1">*Gunakan format angka mulai dari 62</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Induk Berusaha (NIB) <span class="text-gray-400 font-normal">(Opsional)</span></label>
                        <input type="text" name="nib" value="{{ old('nib') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">ID TKM <span class="text-gray-400 font-normal">(Opsional)</span></label>
                        <input type="text" name="id_tkm" value="{{ old('id_tkm') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition">
                    </div>
                </div>

               
                <div class="space-y-4 bg-white p-6 rounded-xl border border-gray-200">
                <h3 class="text-sm font-bold text-emerald-700 uppercase tracking-wider">Lokasi Usaha</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Provinsi *</label>
                        <select name="provinsi" id="provinsi" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition bg-white">
                            <option value="">Pilih Provinsi</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Kabupaten / Kota *</label>
                        <select name="kabupaten_kota" id="kota" required disabled class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition bg-gray-50">
                            <option value="">Pilih Kabupaten/Kota</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Kecamatan *</label>
                        <select name="kecamatan" id="kecamatan" required disabled class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition bg-gray-50">
                            <option value="">Pilih Kecamatan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Kelurahan / Desa *</label>
                        <select name="kelurahan" id="kelurahan" required disabled class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition bg-gray-50">
                            <option value="">Pilih Kelurahan</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Detail Alamat (Jalan, No Rumah, RT/RW) *</label>
                    <textarea name="alamat" rows="2" required placeholder="Contoh: Jl. Sudirman No. 123, RT 01/RW 02"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition">{{ old('alamat') }}</textarea>
                </div>
            </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi Usaha *</label>
                    <textarea name="deskripsi" rows="4" required placeholder="Jelaskan produk unggulan dan keunikan usaha Anda..."
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition">{{ old('deskripsi') }}</textarea>
                </div>

               {{-- KOTAK UPLOAD (LOGO & FOTO) --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-6 bg-gray-50 rounded-2xl border border-dashed border-gray-300">
                    <div class="space-y-3">
                        <label class="block text-sm font-medium text-gray-700">Logo Usaha <span class="text-red-500">*</span></label>
                        <p class="text-xs text-gray-500">Upload 1 file logo (JPG, PNG, WebP). Maks 10 MB.</p>
                        <div class="relative">
                            <input type="file" name="logo" id="file-logo" class="hidden" accept="image/*" onchange="updateFileName(this, 'name-logo')">
                            <button type="button" onclick="document.getElementById('file-logo').click()" 
                                    class="flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-md bg-white text-blue-600 font-medium text-sm hover:bg-blue-50 transition shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                                Pilih Logo
                            </button>
                            <p id="name-logo" class="text-xs text-emerald-600 mt-2 font-medium italic"></p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <label class="block text-sm font-medium text-gray-700">Foto Produk Unggulan <span class="text-red-500">*</span></label>
                        <p class="text-xs text-gray-500">Upload 1 foto produk terbaik (JPG, PNG, WebP). Maks 10 MB.</p>
                        <div class="relative">
                            <input type="file" name="foto_produk" id="file-produk" class="hidden" accept="image/*" onchange="updateFileName(this, 'name-produk')">
                            <button type="button" onclick="document.getElementById('file-produk').click()" 
                                    class="flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-md bg-white text-blue-600 font-medium text-sm hover:bg-blue-50 transition shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                                Pilih Foto
                            </button>
                            <p id="name-produk" class="text-xs text-emerald-600 mt-2 font-medium italic"></p>
                        </div>
                    </div>
                </div>

                {{-- CHECKBOX PERSETUJUAN --}}
                <div class="flex items-start gap-3 p-4 bg-white border border-gray-100 rounded-lg">
                    <input id="terms" name="terms" type="checkbox" required class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500 mt-1">
                    <label for="terms" class="text-sm text-gray-600 cursor-pointer">
                        Saya setuju dengan <span class="font-bold text-emerald-700">Syarat dan Ketentuan</span> serta <span class="font-bold text-emerald-700">Kebijakan Privasi</span> yang berlaku di KAJI Indonesia
                    </label>
                </div>

                
                <div class="pt-4">
                    <button type="submit" class="w-full bg-emerald-600 text-white py-3 rounded-xl font-bold text-lg hover:bg-emerald-700 transition shadow-lg shadow-emerald-200">
                        Kirim Pendaftaran UMKM
                    </button>
                    <p class="text-center text-xs text-gray-400 mt-4 italic">
                        * Pendaftaran akan ditinjau oleh Admin sebelum ditampilkan di halaman UMKM.
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function updateFileName(input, targetId) {
        const fileName = input.files[0] ? input.files[0].name : "";
        const label = document.getElementById(targetId);
        label.textContent = fileName ? "✓ " + fileName : "";
    }

    const BASE_URL = 'https://www.emsifa.com/api-wilayah-indonesia/api';

    const selectProvinsi = document.getElementById('provinsi');
    const selectKota = document.getElementById('kota');
    const selectKecamatan = document.getElementById('kecamatan');
    const selectKelurahan = document.getElementById('kelurahan');

    // Ambil Data Provinsi
    fetch(`${BASE_URL}/provinces.json`)
        .then(response => {
            if (!response.ok) throw new Error('Gagal koneksi ke API');
            return response.json();
        })
        .then(provinces => {
            provinces.forEach(prov => {
                let opt = document.createElement('option');
                opt.value = prov.id;
                opt.text = prov.name;
                selectProvinsi.add(opt);
            });
        })
        .catch(error => {
            console.error("Error saat ambil provinsi:", error);
            alert("Gagal memuat data provinsi. Pastikan internet aktif!");
        });

    // Event saat Provinsi dipilih
    selectProvinsi.addEventListener('change', function() {
        let id = this.value;
        selectKota.disabled = !id;
        selectKota.innerHTML = '<option value="">Pilih Kabupaten/Kota</option>';
        
        if(id) {
            fetch(`${BASE_URL}/regencies/${id}.json`)
                .then(res => res.json())
                .then(data => {
                    data.forEach(item => {
                        let opt = document.createElement('option');
                        opt.value = item.id;
                        opt.text = item.name;
                        selectKota.add(opt);
                    });
                });
        }
    });

    // Event saat Kota dipilih
    selectKota.addEventListener('change', function() {
        let id = this.value;
        selectKecamatan.disabled = !id;
        selectKecamatan.innerHTML = '<option value="">Pilih Kecamatan</option>';
        
        if(id) {
            fetch(`${BASE_URL}/districts/${id}.json`)
                .then(res => res.json())
                .then(data => {
                    data.forEach(item => {
                        let opt = document.createElement('option');
                        opt.value = item.id;
                        opt.text = item.name;
                        selectKecamatan.add(opt);
                    });
                });
        }
    });

    // Event saat Kecamatan dipilih
    selectKecamatan.addEventListener('change', function() {
        let id = this.value;
        selectKelurahan.disabled = !id;
        selectKelurahan.innerHTML = '<option value="">Pilih Kelurahan</option>';
        
        if(id) {
            fetch(`${BASE_URL}/villages/${id}.json`)
                .then(res => res.json())
                .then(data => {
                    data.forEach(item => {
                        let opt = document.createElement('option');
                        opt.value = item.id;
                        opt.text = item.name;
                        selectKelurahan.add(opt);
                    });
                });
        }
    });

    // Sebelum submit, ubah VALUE dari ID menjadi NAMA
    document.querySelector('form').addEventListener('submit', function(e) {
        const selects = ['provinsi', 'kota', 'kecamatan', 'kelurahan'];
        selects.forEach(id => {
            const el = document.getElementById(id);
            if(el.selectedIndex > 0) {
                // Buat input hidden sementara agar nama terkirim, bukan ID
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = el.name; // Pakai nama yang sama (provinsi, kabupaten_kota, dll)
                hiddenInput.value = el.options[el.selectedIndex].text;
                this.appendChild(hiddenInput);
                el.removeAttribute('name'); // Hapus name di select asli agar tidak bentrok
            }
        });
    });
</script>
@endsection