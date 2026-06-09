<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Member;
use App\Models\Team;
use App\Models\Produk;
use App\Models\Mentor;
use App\Models\MentorUlasan;
use Illuminate\Support\Facades\Auth;
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
            'metaDescription' => 'Pendampingan dan penguatan kapasitas UMKM oleh KAJI Indonesia.',
            'members' => $members,
            'teams' => $teams,
        ]);
    }

    public function produk(): View
    {
        $produks = Produk::where('status', 'approved')
            ->latest()
            ->get();

        return view('pages.umkm-produk', [
            'title' => 'Produk UMKM',
            'produks' => $produks,
        ]);
    }

    public function produkDetail($id): View
    {
        $produk = Produk::where('status', 'approved')
            ->findOrFail($id);

        $lainnya = Produk::where('status', 'approved')
            ->where('id', '!=', $id)
            ->take(20)
            ->get();

        return view('pages.detail-produk', [
            'title' => $produk->nama,
            'metaDescription' => $produk->deskripsi,
            'produk' => $produk,
            'lainnya' => $lainnya,
        ]);
    }

    public function pembimbing(): View
    {
        $trainers = Mentor::where('status', 'approved')
            ->withCount('ulasanList')
            ->with('ulasanList')
            ->latest('reviewed_at')
            ->paginate(12);

        return view('pages.umkm-pembimbing', [
            'title' => 'Pembimbing UMKM',
            'metaDescription' => 'Tim pembimbing UMKM yang berpengalaman di KAJI Indonesia.',
            'trainers' => $trainers,
        ]);
    }

public function showMentor($id): View
{
    $mentor = Mentor::where('status', 'approved')
        ->findOrFail($id);

    // Ambil produk / UMKM yang terhubung
    $connectedUmkm = Produk::with('umkm')
        ->where('mentor_id', $mentor->id)
        ->where('status', 'approved')
        ->get();

    /*
    |--------------------------------------------------------------------------
    | Rating & Ulasan
    |--------------------------------------------------------------------------
    */

    $ulasan      = $mentor->ulasanList()->with('user')->latest()->get();
    $avgRating   = $ulasan->avg('rating') ?? 0;
    $totalUlasan = $ulasan->count();

    /*
    |--------------------------------------------------------------------------
    | Cek apakah user yang login boleh memberi ulasan
    | Syarat: sudah login, punya produk approved, produk terhubung ke mentor ini,
    |         dan belum pernah memberi ulasan untuk mentor ini.
    |--------------------------------------------------------------------------
    */

    $bisaMemberiUlasan = false;
    $sudahUlasan       = false;

    if (Auth::check()) {
        $user = Auth::user();

        // Cek apakah user UMKM ini terhubung dengan mentor (produknya punya mentor_id ini)
        $produkUser = Produk::where('user_id', $user->id)
            ->where('status', 'approved')
            ->where('mentor_id', $mentor->id)
            ->first();

        if ($produkUser) {
            $bisaMemberiUlasan = true;

            // Cek apakah sudah pernah memberi ulasan
            $sudahUlasan = MentorUlasan::where('mentor_id', $mentor->id)
                ->where('user_id', $user->id)
                ->exists();
        }
    }

    return view('pages.detail-pembimbing', [
        'mentor'             => $mentor,
        'connectedUmkm'      => $connectedUmkm,
        'avgRating'          => $avgRating,
        'totalUlasan'        => $totalUlasan,
        'ulasan'             => $ulasan,
        'bisaMemberiUlasan'  => $bisaMemberiUlasan,
        'sudahUlasan'        => $sudahUlasan,
    ]);
}

    public function lokasi(): View
    {
        return view('pages.umkm-lokasi', [
            'title' => 'Lokasi UMKM',
            'metaDescription' => 'Lokasi UMKM yang didampingi oleh KAJI Indonesia.',
        ]);
    }

    // =========================================================
    // API DATA PETA UMKM
    // =========================================================

    public function apiPeta()
    {
        $this->geocodeBelumAda();

        $produks = Produk::where('status', 'approved')
            ->whereNotNull('lat')
            ->whereNotNull('lng')
            ->select([
                'id',
                'nama',
                'logo',
                'foto_produk',
                'alamat',
                'lat',
                'lng',
                'provinsi',
                'kabupaten_kota',
                'kecamatan'
            ])
            ->get();

        $data = [];

        foreach ($produks as $p) {

            $fotoFile = $p->logo ?: $p->foto_produk;

            $fotoUrl = $fotoFile
                ? asset('storage/produk-pict/' . $fotoFile)
                : null;

            $wilayah = trim(implode(', ', array_filter([
                $p->kecamatan,
                $p->kabupaten_kota,
                $p->provinsi
            ])));

            $alamatTampil = $p->alamat ?: $wilayah;

            $data[] = [
                'id' => $p->id,
                'nama' => $p->nama,
                'alamat' => $alamatTampil,
                'foto' => $fotoUrl,
                'lat' => (float) $p->lat,
                'lng' => (float) $p->lng,
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

        $totalApproved = Produk::where('status', 'approved')->count();

        $produks = Produk::where('status', 'approved')
            ->whereNotNull('lat')
            ->whereNotNull('lng')
            ->where('lat', '!=', 0)
            ->where('lng', '!=', 0)
            ->select([
                'id',
                'nama',
                'logo',
                'foto_produk',
                'alamat',
                'lat',
                'lng',
                'provinsi',
                'kabupaten_kota',
                'kecamatan'
            ])
            ->get();

        $data = [];

        foreach ($produks as $p) {

            if (!$this->koordinatValid((float) $p->lat, (float) $p->lng)) {
                continue;
            }

            $fotoFile = $p->logo ?: $p->foto_produk;

            $fotoUrl = $fotoFile
                ? asset('storage/produk-pict/' . $fotoFile)
                : null;

            $wilayah = trim(implode(', ', array_filter([
                $p->kecamatan,
                $p->kabupaten_kota,
                $p->provinsi
            ])));

            $alamatTampil = $p->alamat ?: $wilayah;

            $data[] = [
                'id' => $p->id,
                'nama' => $p->nama,
                'alamat' => $alamatTampil,
                'foto' => $fotoUrl,
                'lat' => (float) $p->lat,
                'lng' => (float) $p->lng,
            ];
        }

        return response()->json([
            'data' => $data,
            'total_approved' => $totalApproved,
            'total_mapped' => count($data),
        ]);
    }

    // =========================================================
    // PETA MENTOR
    // =========================================================

    public function petaDataMentor()
    {
        $totalApproved = Mentor::where('status', 'approved')->count();

        $mentors = Mentor::where('status', 'approved')
            ->get();

        $data = [];

        foreach ($mentors as $m) {

            if ($m->lat && $m->lng) {

                $koordinat = [
                    'lat' => (float) $m->lat,
                    'lng' => (float) $m->lng
                ];

            } else {

                $wilayah = trim(implode(', ', array_filter([
                    $m->kecamatan,
                    $m->kabupaten,
                    $m->provinsi
                ])));

                $alamatGeocode = $m->gmaps_location ?: ($wilayah ?: $m->lokasi);

                if (!$alamatGeocode) {
                    continue;
                }

                $koordinat = $this->geocodeAlamat($alamatGeocode);

                if (!$koordinat) {
                    continue;
                }

                $m->update([
                    'lat' => $koordinat['lat'],
                    'lng' => $koordinat['lng'],
                ]);
            }

            $fotoPath = null;

            if ($m->white_bg_photo) {
                $fotoPath = asset('storage/' . $m->white_bg_photo);
            } elseif ($m->foto) {
                $fotoPath = asset('storage/pembimbing/' . $m->foto);
            }

            $data[] = [
                'id' => $m->id,
                'nama' => $m->full_name ?: $m->nama,
                'lokasi' => $m->gmaps_location ?: ($m->lokasi ?: implode(', ', array_filter([$m->kecamatan, $m->kabupaten, $m->provinsi]))),
                'foto' => $fotoPath,
                'lat' => $koordinat['lat'],
                'lng' => $koordinat['lng'],
            ];
        }

        return response()->json([
            'data' => $data,
            'total_approved' => $totalApproved,
            'total_mapped' => count($data),
        ]);
    }

    // =========================================================
    // GEOCODING
    // =========================================================

    private function geocodeBelumAda(): void
    {
        $belum = Produk::where('status', 'approved')
            ->where(function ($q) {
                $q->whereNull('lat')
                  ->orWhereNull('lng');
            })
            ->get();

        foreach ($belum as $produk) {

            $wilayah = trim(implode(', ', array_filter([
                $produk->kecamatan,
                $produk->kabupaten_kota,
                $produk->provinsi
            ])));

            $alamatGeocode = $produk->alamat ?: $wilayah;

            if (!$alamatGeocode) {
                continue;
            }

            $koordinat = $this->geocodeAlamat($alamatGeocode);

            if ($koordinat) {

                $produk->update([
                    'lat' => $koordinat['lat'],
                    'lng' => $koordinat['lng'],
                ]);
            }

            usleep(500000);
        }
    }

    private function koordinatValid(float $lat, float $lng): bool
    {
        return $lat >= -11 &&
               $lat <= 6 &&
               $lng >= 95 &&
               $lng <= 141;
    }

    private function geocodeAlamat(string $alamat): ?array
    {
        try {

            $response = Http::timeout(8)
                ->withHeaders([
                    'User-Agent' => 'KaryaKamiUMKMApp/1.0',
                ])
                ->get('https://nominatim.openstreetmap.org/search', [
                    'q' => $alamat . ', Indonesia',
                    'format' => 'json',
                    'limit' => 1,
                ]);

            $hasil = $response->json();

            if (!empty($hasil)) {

                return [
                    'lat' => (float) $hasil[0]['lat'],
                    'lng' => (float) $hasil[0]['lon'],
                ];
            }

        } catch (\Exception $e) {

            Log::error('Geocode Error: ' . $e->getMessage());
        }

        return null;
    }
}