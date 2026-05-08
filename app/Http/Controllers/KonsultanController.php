<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class KonsultanController extends Controller
{
    public function index(): View
    {
        return view('pages.konsultan', [
            'title' => 'Konsultan',
            'metaDescription' => 'Layanan konsultasi strategi bisnis, manajemen, dan pengembangan organisasi oleh Kaji Indonesia.',
        ]);
    }

    public function layanan(): View
    {
        return view('pages.konsultan-layanan', [   // ← titik di-escape dengan \
            'title' => 'Layanan Konsultan',
            'metaDescription' => 'Berbagai jenis layanan konsultasi yang ditawarkan Kaji Indonesia.',
        ]);
    }

    public function paket(): View
    {
        return view('pages.konsultan-paket', [     // ← titik di-escape dengan \
            'title' => 'Paket Konsultan',
            'metaDescription' => 'Pilihan paket konsultasi sesuai kebutuhan bisnis Anda.',
        ]);
    }
}