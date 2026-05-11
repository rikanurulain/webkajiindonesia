<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Member;
use App\Models\Team;
use App\Models\Produk;
use App\Models\User; // Menggunakan model User untuk Mentor
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class UmkmController extends Controller
{
    public function index(): View
    {
        $members = Member::all();
        $teams = Team::all();
        
        return view('pages.umkm', [
            'title' => 'UMKM',
            'metaDescription' => 'Pendampingan dan penguatan kapasitas UMKM oleh Kaji Indonesia.',
            'members' => $members,
            'teams' => $teams,
        ]);
    }
    
    public function produk(): View
    {
        $produks = Produk::all();

        return view('pages.umkm-produk', [
            'title' => 'Produk UMKM',
            'produks' => $produks,
            ]);
    }

    public function produkDetail($id): View
    {
        $produk  = Produk::findOrFail($id);
        $lainnya = Produk::where('id', '!=', $id)->take(20)->get();

        return view('pages.detail-produk', [
            'title'       => $produk->nama,
            'metaDescription' => $produk->deskripsi,
            'produk'      => $produk,
            'lainnya'     => $lainnya,
        ]);
    }

    public function pembimbing(): View
{
    // Kita gunakan nama variabel $trainers agar cocok dengan file Blade Anda
    $trainers = \App\Models\User::where('trainer_status', 'approved')->paginate(12);

    return view('pages.umkm-pembimbing', [
        'title' => 'Pembimbing UMKM',
        'metaDescription' => 'Tim pembimbing UMKM yang berpengalaman di Kaji Indonesia.',
        'trainers' => $trainers, // Menggunakan 'trainers' sebagai kunci
    ]);
}

    public function showMentor($id)
    {
        // PERBAIKAN: Mengambil detail mentor dari model User
        $mentor = User::where('trainer_status', 'approved')->findOrFail($id);
        
        // Menggunakan file detail yang sudah Anda miliki
        return view('pages.umkm-pembimbing_detail', compact('mentor'));
    }

    public function lokasi(): View
    {
        return view('pages.umkm-lokasi', [
            'title' => 'Lokasi UMKM',
            'metaDescription' => 'Lokasi UMKM yang didampingi oleh Kaji Indonesia.',
        ]);
    }

    // ─────────────────────────────────────────────────────────
    // API endpoint — kembalikan data UMKM sebagai JSON
    // ─────────────────────────────────────────────────────────
    public function apiPeta()
    {
        $this->geocodeBelumAda();

        $produks = Produk::whereNotNull('lat')
            ->whereNotNull('lng')
            ->select(['id', 'nama', 'foto','alamat', 'lat', 'lng'])
            ->get();

        $data = [];
        foreach ($produks as $p) {
            $data[] = [
                'id' => $p->id,
                'nama' => $p->nama,
                'alamat' => $p->alamat,
                'foto' => $p->foto ? asset('storage/produk-pict/' . $p->foto) : null,
                'lat' => $p->lat,
                'lng' => $p->lng,
            ];
        }

        return response()->json([
            'status' => 'success',
            'total' => count($data),
            'data' => $data,
        ]);
    }

    public function petaData()
    {
        $this->geocodeBelumAda();
    
        $produks = Produk::whereNotNull('lat')
            ->whereNotNull('lng')
            ->where('status', 'approved')
            ->select(['id', 'nama', 'foto', 'alamat', 'lat', 'lng'])
            ->get();
    
        $data = [];
        foreach ($produks as $p) {
            $data[] = [
                'id'     => $p->id,
                'nama'   => $p->nama,
                'alamat' => $p->alamat,
                'foto'   => $p->foto ? asset('storage/produk-pict/' . $p->foto) : null,
                'lat'    => $p->lat,
                'lng'    => $p->lng,
            ];
        }
    
        return response()->json(['data' => $data]);
    }

    private function geocodeBelumAda(): void
    {
       $belum = Produk::whereNull('lat')
       ->whereNull('lng')
       ->whereNotNull('alamat')
       ->get();

       foreach ($belum as $produk) {
            $koordinat = $this->geocodeAlamat($produk->alamat);
            if ($koordinat) {
                $produk->update([
                    'lat' => $koordinat['lat'],
                    'lng' => $koordinat['lng'],
                ]);
            }
            sleep(1);
       }
    }

    private function geocodeAlamat(string $alamat): ?array
    {
        $cacheKey = 'geocode_osm_' . md5($alamat);
 
        return Cache::remember($cacheKey, now()->addDays(30), function () use ($alamat) {
            try {
                $response = Http::timeout(8)
                    ->withHeaders([
                        'User-Agent'      => 'KaryaKamiUMKMApp/1.0',
                        'Accept-Language' => 'id,en',
                    ])
                    ->get('https://nominatim.openstreetmap.org/search', [
                        'q'            => $alamat . ', Indonesia',
                        'format'       => 'json',
                        'limit'        => 1,
                        'countrycodes' => 'id',
                    ]);
 
                $hasil = $response->json();
 
                if (!empty($hasil)) {
                    return [
                        'lat' => (float) $hasil[0]['lat'],
                        'lng' => (float) $hasil[0]['lon'],
                    ];
                }
                return null;
            } catch (\Exception $e) {
                Log::error("Geocode error: " . $e->getMessage());
                return null;
            }
        });
    }
}