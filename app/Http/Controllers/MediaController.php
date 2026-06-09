<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class MediaController extends Controller
{
    public function index(): View
    {
        return view('pages.media', [
            'title' => 'Media',
            'metaDescription' => 'Konten edukatif dan informasi seputar kajian, bisnis, dan halal dari KAJI Indonesia.',
        ]);
    }
}
