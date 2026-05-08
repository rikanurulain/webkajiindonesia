@extends('layouts.app')

@section('content')
    <section class="bg-gradient-to-br from-primary-dark via-primary to-primary- py-16 text-white">
        {{-- <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8"> --}}
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-8">
            {{-- <h1 class="font-serif text-4xl font-bold sm:text-5xl">UMKM KARYA KAMI</h1>
            <p class="mt-4 max-w-2xl text-lg text-white/90">Pendampingan dan penguatan kapasitas usaha mikro, kecil, dan menengah.</p>
                
            <div>
                <img src="{{ asset('images/LOGO KARYA KAMI.png') }}"   
                     alt="Logo Karya Kami"
                     class="w-64 md:w-80 object-contain">
            </div> --}}
            <!-- TEXT -->
        <div class="max-w-2xl">
            <h1 class="font-serif text-4xl font-bold sm:text-5xl">
                UMKM KARYA KAMI
            </h1>
            <p class="mt-4 text-lg text-white/90">
                Pendampingan dan penguatan kapasitas usaha mikro, kecil, dan menengah.
            </p>
        </div>

        <!-- IMAGE -->
        <div>
            <img src="{{ asset('storage/logo/KARYAKAMI.png') }}"  
                 alt="Logo Karya Kami"
                 class="w-64 md:w-80 object-contain">
        </div>

        </div>
    </section>

    {{-- Tentang Karya Kami --}}
    <section class="bg-white py-16 sm:py-20 px-6 pb-16">
        <h2 class="font-serif text-center text-3xl font-bold text-black-900 sm:text-4xl mb-8">Tentang Karya Kami</h2>
        <div class="max-w-7xl mx-auto border border-gray-300 rounded-2xl p-8 bg-white">
            <p class="text-center text-3x1 leading-relaxed text-black-600">
                <strong class="text-gray-900">Karya Kami</strong> adalah sebuah lembaga yang menjadi wadah berkumpulnya para pelaku UMKM dan pendampingan UMKM dari berbagai latar belakang dan keahlian. Kami memiliki visi untuk meningkatkan kompetensi para pendamping agar mampu memberikan pendampingan yang lebih efektif, relevan, dan berdampak bagi pelaku UMKM di seluruh Indonesia.
            </p>
            <p class="text-center text-3x1 leading-relaxed text-black-600 mt-4">
                Melalui <strong>pelatihan</strong>, <strong>kolaborasi</strong>, dan <strong>berbagi pengetahuan</strong>, Karya Kami mendorong <em>peningkatan kapasitas pendamping</em> dalam berbagai aspek usaha, mulai dari manajemen bisnis, pengembangan produk, hingga digitalisasi usaha. Kami percaya bahwa pendamping yang andal adalah kunci utama dalam membantu
                <span class="text-green-700">UMKM tumbuh</span>,
                <span class="text-green-700">beradaptasi</span>, dan
                <span class="text-green-700">bersaing</span>
                di era yang terus berubah.
            </p>
        </div>
    </section>

    {{-- Layanan --}}
    <section class="bg-gray-50 py-16 sm:py-20 px-6 pb-16">
        <h2 class="font-serif text-center text-3xl font-bold text-black-900 sm:text-4xl mb-8">Layanan</h2>

        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- Kartu 1: Pelatihan bagi UMKM --}}
        <div class="bg-green-50 border border-green-200 rounded-2xl p-7 duration-300 hover:shadow-lg hover:-translate-y-1">
            <div class="flex justify-center mb-4">
                <div class="bg-green-100 rounded-full p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
            </div>
            <h3 class="font-serif text-center text-2xl font-semibold text-gray-900 mb-5">Pelatihan bagi UMKM</h3>
            <ul class="list-disc pl-15 space-y-1 text-base text-gray-700">
                <li>Kewirausahaan</li>
                <li>Manajemen Pemasaran</li>
                <li>Manajemen SDM</li>
                <li>Manajemen Umum</li>
                <li>Manajemen Keuangan</li>
            </ul>
        </div>

        {{-- Kartu 2: Pelatihan bagi Fasilitator --}}
        <div class="bg-green-50 border border-green-200 rounded-2xl p-7 duration-300 hover:shadow-lg hover:-translate-y-1">
            <div class="flex justify-center mb-4">
                <div class="bg-green-100 rounded-full p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
            </div>
            <h3 class="font-serif text-center text-2xl font-semibold text-gray-900 mb-5">Pelatihan bagi Fasilitator</h3>
            <ul class="list-disc pl-15 space-y-1 text-base text-gray-700">
                <li>BNSP Pendampingan UMKM</li>
                <li>Pendampingan Produk Halal</li>
                <li>BNSP Trainer dan Metodologi Pelatihan</li>
                <li>dll</li>
            </ul>
        </div>

        {{-- Kartu 3: Formalisasi Usaha --}}
        <div class="bg-green-50 border border-green-200 rounded-2xl p-7 duration-300 hover:shadow-lg hover:-translate-y-1">
            <div class="flex justify-center mb-4">
                <div class="bg-green-100 rounded-full p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
            <h3 class="font-serif text-center text-2xl font-semibold text-gray-900 mb-5">Formalisasi Usaha</h3>
            <div class="grid grid-cols-2 gap-x-4 text-base text-gray-700">
                <ul class="list-disc pl-20 space-y-1">
                    <li>NIB</li>
                    <li>P-IRT</li>
                    <li>BPOM</li>
                    <li>SNI</li>
                </ul>
                <ul class="list-disc pl-5 space-y-1">
                    <li>Halal</li>
                    <li>HACCP</li>
                    <li>Merk</li>
                    <li>Badan Hukum Usaha</li>
                </ul>
            </div>
        </div>

        </div>
    </section>

    {{-- kenapa harus kami --}}
    <section class=" bg-white py-16 sm:py-20 px-6 pb-16">
         <h2 class="bg-black-50 font-serif text-center text-3xl font-bold text-black-900 sm:text-4xl mb-8">Kenapa Memilih Layanan Kami</h2>

        {{-- Baris 1: 2 kartu --}}
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
 
            {{-- Kartu 1: Pelatihan bagi UMKM --}}
            <div class="bg-green-50 border border-green-200 rounded-2xl p-7 duration-300 hover:shadow-lg hover:-translate-y-1">
                <div class="flex justify-center mb-4">
                    {{-- <div class="bg-green-100 rounded-full p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div> --}}
                    <div class="bg-green-100 rounded-full p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                        </svg>
                    </div>
                </div>
                <h3 class="font-serif text-center text-2xl font-semibold text-gray-900 mb-5">Mutu Jaminan</h3>
                <p class="text-center" class="border border-gray-300 rounded-lg p-6">Pendampingan Karya Kami memiliki kompetensi dan berpengalaman.</p>
            </div>
 
            {{-- Kartu 2: Pelatihan bagi Fasilitator --}}
            <div class="bg-green-50 border border-green-200 rounded-2xl p-7 duration-300 hover:shadow-lg hover:-translate-y-1">
                <div class="flex justify-center mb-4">
                    {{-- <div class="bg-green-100 rounded-full p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </div> --}}
                    <div class="bg-green-100 rounded-full p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                        </svg>
                    </div>
                </div>

                <h3 class="font-serif text-center text-2xl font-semibold text-gray-900 mb-5">Jaringan seluruh Indonesia</h3>
               
                <p class="text-center" class="border border-gray-300 rounded-lg p-6">Pendampingan tersebar di seluruh provinsi di Indonesia.</p>

            </div>

             <div class="bg-green-50 border border-green-200 rounded-2xl p-7 duration-300 hover:shadow-lg hover:-translate-y-1">
                <div class="flex justify-center mb-4">
                    {{-- <div class="bg-green-100 rounded-full p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div> --}}
                    <div class="bg-green-100 rounded-full p-3">
                         <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                             <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.5c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 012.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 00.322-1.672V3a.75.75 0 01.75-.75A2.25 2.25 0 0116.5 4.5c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 01-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 00-1.423-.23H5.904M14.25 9h2.25M5.904 18.75c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 01-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 10.203 4.167 9.75 5 9.75h1.053c.472 0 .745.556.5.96a8.958 8.958 0 00-1.302 4.665c0 1.194.232 2.333.654 3.375z" />
                         </svg>
                    </div>
                </div>

                <h3 class="font-serif text-center text-2xl font-semibold text-gray-900 mb-5">Pasar Luas</h3>
                <p class="text-center" class="border border-gray-300 rounded-lg p-6">Karya Kami juga menjalin kemitraan dengan berbagai Stakeholders.</p>

                </div>
 
        </div>
 
        </div>
    </section>


    


    







 
 
    {{-- Visi & Misi --}}
    <section class="bg-white py-16 sm:py-20 px-6 pb-16">
        <h2 class="bg-black-50 font-serif text-center text-3xl font-bold text-black-900 sm:text-4xl mb-8">Visi & Misi</h2>
        <div class="max-w-6xl mx-auto flex flex-col gap-6">
 
            {{-- Visi --}}
            <div class="bg-green-50 border border-green-200 rounded-2xl p-7">
                <h3 class="font-serif text-center text-2xl font-bold text-black-900 mb-4">Visi</h3>
                <p class="text-center text-3x1 leading-relaxed text-black-600">
                    Menjadi pusat pengembangan kapasitas pendamping UMKM yang unggul, kolaboratif, dan berkelanjutan untuk mendorong kemajuan usaha pelaku UMKM di seluruh Indonesia.
                </p>
            </div>
 
            {{-- Misi --}}
            <div class="bg-green-50 border border-green-200 rounded-2xl p-7">
                <h3 class="font-serif text-center text-2xl font-semibold text-gray-900 mb-5">Misi</h3>
                <ul class="list-disc pl-5 space-y-4 text-3x1 leading-relaxed text-black-600">
                    <li>
                        <strong class="text-black-900">Meningkatkan Kompetensi Pendamping</strong><br>
                        Menyelenggarakan pelatihan, workshop, dan pengembangan berkelanjutan bagi pendamping UMKM agar mampu memberikan pendampingan yang tepat, adaptif, dan berdampak.
                    </li>
                    <li>
                        <strong class="text-black-900">Mendorong Inovasi dan Digitalisasi</strong><br>
                        Membekali pendamping dengan pengetahuan dan keterampilan di bidang teknologi dan digitalisasi usaha, guna membantu UMKM bertransformasi dan bersaing di era digital.
                    </li>
                    <li>
                        <strong class="text-black-900">Membangun Jejaring dan Kolaborasi</strong><br>
                        Memfasilitasi kolaborasi antara pendamping, pelaku UMKM, instansi pemerintah, swasta, dan komunitas untuk memperkuat ekosistem pendampingan UMKM yang saling mendukung.
                    </li>
                    <li>
                        <strong class="text-black-900">Mengedepankan Pendekatan Humanis dan Partisipatif</strong><br>
                        Mendorong pendekatan yang berfokus pada pemberdayaan, partisipasi aktif pelaku UMKM, dan pemahaman kontekstual terhadap tantangan yang mereka hadapi.
                    </li>
                    <li>
                        <strong class="text-black-900">Memonitoring dan Mengevaluasi Dampak Pendampingan</strong><br>
                        Membangun sistem evaluasi yang terukur untuk memastikan setiap pendampingan memberikan kontribusi nyata terhadap pertumbuhan dan kemandirian UMKM.
                    </li>
                </ul>
            </div>
 
        </div>
    </section>


    {{-- Member Kami --}}
    <section class="py-10 px-6 pb-16">

        <h2 class="bg-black-50 font-serif text-center text-3xl font-bold text-black-900 sm:text-4xl mb-6">Member Kami</h2>
 
        <div class="max-w-6xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
 
            {{-- Ulangi kartu ini sesuai data --}}
            @foreach($members as $member)
            <div class="bg-white border border-gray-200 rounded-2xl p-6 min-h-40 duration-300 hover:shadow-lg hover:-translate-y-1">
                <div class="flex items-center gap-3 mb-3">
                    <div class="bg-green-100 rounded-xl p-2 flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-900 leading-snug">{{ $member->nama }}</p>
                    </div>
                </div>
                <hr class="border-gray-100 mb-3">
                <p class="text-sm text-black-500">{{ $member->jumlah_pendamping }} Pendamping</p>
            </div>
            @endforeach
 
        </div>
    </section>
    

     {{-- Tim Terbaik --}}

    <section class="bg-gray-50 py-16 sm:py-20 px-6 pb-16">
         <h2 class="bg-black-50 font-serif text-center text-3xl font-bold text-black-900 sm:text-4xl mb-8">Tim Terbaik</h2>
         <div class="max-w-4xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach($teams as $team)
            <div class="bg-white border border-gray-200 rounded-2xl overflow-hiddenduration-300 hover:shadow-lg hover:-translate-y-1">
                {{-- Foto --}}
                <div class="w-full h-56 overflow-hidden">
                    <img src="{{ asset('storage/teams/' . $team->foto) }}"
                         alt="{{ $team->nama }}"
                         class="w-full h-full object-cover object-center">
                </div>
 
                {{-- Info --}}
                <div class="p-5">
                    <p class="text-sm font-bold text-gray-900 uppercase mb-1">{{ $team->nama }}</p>
                    <p class="text-sm text-gray-500">{{ $team->jabatan }}</p>
                </div>
            </div>
            @endforeach
         </div>
        
    </section>

     
      



{{-- ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ --}}

    <section class="bg-white py-16 sm:py-20" id="layanan">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="font-serif text-3xl font-bold text-gray-900 sm:text-4xl">Sejarah Perusahaan</h2>
        </div>
        <div class="border border-gray-300 rounded-lg p-8 flex flex-col md:flex-row items-center gap-10">

            {{-- Teks kiri --}}
            <div class="flex-1 text-sm text-gray-700 leading-relaxed">
                <p>
                    <b>Karya Kami</b> berdiri atas inisiatif sekelompok pendamping UMKM yang memiliki semangat untuk terus mengembangkan diri dan meningkatkan kualitas pendamping yang mereka berikan. Mereka menyadari bahwa peran pendamping sangat krusial dalam membentu pelaku UMKM bertumbuh, namun seringkali belum mendapatkan dukungan yang memadai dalam hal peningkatan kapasitas dan jejaring. Berangkat dari kebutuhan tersebut, para pendamping ini sepakat untuk membentuk sebuah lembaga yang menjadi ruang belajar, berbagi dan saling menguatkan antarpelaku pendampingan.
                </p>
                <br>
                <p>
                    Seiring waktu, <b>Karya Kami</b> berkembang menjadi lembaga yang menjalin kolaborasi luas dengan berbagai stakeholder, termasuk pemerintah, sektor swasta, akademisi, dan komunitas. Melalui kemitraan ini, <b>Karya Kami</b> mendorong terciptanya ekosistem pendampingan UMKM yang lebih terstruktur, adaptif, dan responsif terhadap tantangan zaman, terutama dalam menghadapi transformasi digital dan perubahan pasar. Lembaga ini terus berkomitmen untuk memperkuat peran pendamping sebagai agen perubahan dalam mendorong pertumbuhan UMKM yang berkelanjutan.
                </p>
            </div>

            {{-- Logo kanan --}}
            <div class="flex-shrink-0">
                <img src="{{ asset('storage/logo/KARYAKAMI.png') }}" alt="Karya Kami" class="w-48 md:w-64 object-contain">
            </div>

                </div>
            </div>
        </section>






{{-- ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- --}}




@endsection
