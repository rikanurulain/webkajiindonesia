<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Member;
use App\Models\Team;
use App\Models\Produk;
use App\Models\Mentor;
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
        // Ambil dari tabel mentor (bukan users) — mentor yang sudah disetujui admin
        $trainers = Mentor::where('status', 'approved')
            ->latest('reviewed_at')
            ->paginate(12);

        return view('pages.umkm-pembimbing', [
            'title'           => 'Pembimbing UMKM',
            'metaDescription' => 'Tim pembimbing UMKM yang berpengalaman di Kaji Indonesia.',
            'trainers'        => $trainers,
        ]);
    }

    public function showMentor($id)
    {
        $mentor = Mentor::where('status', 'approved')->findOrFail($id);
        return view('pages.detail-pembimbing', compact('mentor'));
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
        // Geocode produk yang belum punya koordinat
        $this->geocodeBelumAda();
    
        // Tampilkan semua produk yang sudah punya koordinat (bukan hanya approved)
        // agar marker muncul meski status masih pending
        $produks = Produk::whereNotNull('lat')
            ->whereNotNull('lng')
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

    // ─────────────────────────────────────────────────────────
    // API endpoint — kembalikan data Mentor sebagai JSON untuk peta
    // Koordinat di-cache per mentor via Nominatim (tanpa perlu kolom lat/lng di DB)
    // ─────────────────────────────────────────────────────────
    public function petaDataMentor()
    {
        // Ambil semua mentor yang SUDAH DISETUJUI dan punya minimal satu info lokasi
        $mentors = Mentor::select([
                'id', 'nama', 'full_name', 'white_bg_photo', 'foto',
                'lokasi', 'gmaps_location', 'provinsi', 'kabupaten', 'kecamatan',
                'lat', 'lng',
                'phone', 'role', 'status',
            ])
            ->where('status', 'approved')
            ->where(function ($q) {
                $q->whereNotNull('gmaps_location')
                  ->orWhereNotNull('lokasi')
                  ->orWhereNotNull('provinsi');
            })
            ->get();

        $data = [];
        foreach ($mentors as $m) {
            // ── Alamat untuk DITAMPILKAN di popup ─────────────────────────
            // Prioritas: gmaps_location (alamat lengkap dari user) > gabungan wilayah
            $wilayah = trim(implode(', ', array_filter([$m->kecamatan, $m->kabupaten, $m->provinsi])));
            $alamatTampil = $m->gmaps_location ?: ($wilayah ?: $m->lokasi);

            // Pastikan alamat tampil bukan koordinat (angka seperti "-7.123, 112.456")
            if ($alamatTampil && preg_match('/^-?\d+\.\d+\s*,\s*-?\d+\.\d+$/', trim($alamatTampil))) {
                $alamatTampil = $wilayah ?: null;
            }

            // ── Alamat untuk GEOCODING (mencari koordinat) ────────────────
            // Prioritas: gmaps_location > lokasi > wilayah administratif
            // Hindari geocoding string koordinat mentah
            $alamatGeocode = null;
            foreach ([$m->gmaps_location, $wilayah, $m->lokasi] as $kandidat) {
                if (!$kandidat) continue;
                // Lewati jika isinya koordinat angka
                if (preg_match('/^-?\d+\.\d+\s*,\s*-?\d+\.\d+$/', trim($kandidat))) continue;
                $alamatGeocode = $kandidat;
                break;
            }

            if (!$alamatGeocode) continue;

            // Gunakan lat/lng tersimpan di DB jika ada, geocode jika belum
            if ($m->lat && $m->lng) {
                $koordinat = ['lat' => (float) $m->lat, 'lng' => (float) $m->lng];
            } else {
                $koordinat = $this->geocodeAlamat($alamatGeocode);
                if ($koordinat) {
                    // Simpan ke DB agar tidak geocode ulang tiap request
                    $m->update(['lat' => $koordinat['lat'], 'lng' => $koordinat['lng']]);
                }
            }

            if (!$koordinat) continue;

            // Foto: utamakan white_bg_photo, fallback foto
            $fotoPath = null;
            if ($m->white_bg_photo) {
                $fotoPath = asset('storage/' . $m->white_bg_photo);
            } elseif ($m->foto) {
                $fotoPath = asset('storage/pembimbing/' . $m->foto);
            }

            $data[] = [
                'id'     => $m->id,
                'nama'   => $m->full_name ?: $m->nama,
                'lokasi' => $alamatTampil, // alamat yang ditampilkan di popup
                'foto'   => $fotoPath,
                'lat'    => $koordinat['lat'],
                'lng'    => $koordinat['lng'],
            ];
        }

        return response()->json(['data' => $data]);
    }

    private function geocodeBelumAda(): void
    {
        $belum = Produk::whereNull('lat')
            ->whereNull('lng')
            ->whereNotNull('alamat')
            ->where('alamat', '!=', '')
            ->get();

        foreach ($belum as $produk) {
            $koordinat = $this->geocodeAlamat($produk->alamat);
            if ($koordinat) {
                $produk->update([
                    'lat' => $koordinat['lat'],
                    'lng' => $koordinat['lng'],
                ]);
            }
            // Jeda singkat agar tidak rate-limit Nominatim
            usleep(500000); // 0.5 detik
        }
    }

    /**
     * Validasi apakah koordinat berada di dalam wilayah Indonesia
     * (batas kasar: lat -11 s/d 6, lng 95 s/d 141)
     */
    private function koordinatValid(float $lat, float $lng): bool
    {
        return $lat >= -11 && $lat <= 6 && $lng >= 95 && $lng <= 141;
    }

    private function geocodeAlamat(string $alamat): ?array
    {
        // Tolak jika input adalah koordinat mentah (bukan alamat teks)
        if (preg_match('/^-?\d+\.\d+\s*,\s*-?\d+\.\d+$/', trim($alamat))) {
            return null;
        }

        // Coba beberapa versi alamat dari spesifik ke umum
        $kandidat = $this->sederhanakAlamat($alamat);

        foreach ($kandidat as $query) {
            $cacheKey = 'geocode_osm_' . md5($query);

            $cached = Cache::get($cacheKey);
            if ($cached !== null) {
                return $cached;
            }

            try {
                $response = Http::timeout(8)
                    ->withHeaders([
                        'User-Agent'      => 'KaryaKamiUMKMApp/1.0',
                        'Accept-Language' => 'id,en',
                    ])
                    ->get('https://nominatim.openstreetmap.org/search', [
                        'q'            => $query . ', Indonesia',
                        'format'       => 'json',
                        'limit'        => 1,
                        'countrycodes' => 'id',
                    ]);

                $hasil = $response->json();

                if (!empty($hasil)) {
                    $lat = (float) $hasil[0]['lat'];
                    $lng = (float) $hasil[0]['lon'];

                    // Pastikan koordinat masuk akal untuk Indonesia
                    if (!$this->koordinatValid($lat, $lng)) {
                        usleep(300000);
                        continue;
                    }

                    $koordinat = ['lat' => $lat, 'lng' => $lng];
                    Cache::put($cacheKey, $koordinat, now()->addDays(30));
                    return $koordinat;
                }

                usleep(300000); // 0.3 detik jeda antar percobaan

            } catch (\Exception $e) {
                Log::error("Geocode error untuk '$query': " . $e->getMessage());
            }
        }

        return null;
    }

    /**
     * Buat daftar query dari alamat lengkap → makin sederhana
     * Contoh: "Jl. Rungkut Madya 60294 Gunung Anyar Jawa Timur"
     * → ["Jl. Rungkut Madya Gunung Anyar Jawa Timur",
     *    "Gunung Anyar Jawa Timur",
     *    "Jawa Timur"]
     */
    private function sederhanakAlamat(string $alamat): array
    {
        $kandidat = [];

        // 1. Hilangkan kode pos (5 digit angka) dari alamat asli
        $tanpaKodePos = trim(preg_replace('/\b\d{5}\b/', '', $alamat));
        $tanpaKodePos = preg_replace('/\s+/', ' ', $tanpaKodePos);
        if ($tanpaKodePos && $tanpaKodePos !== $alamat) {
            $kandidat[] = $tanpaKodePos;
        }

        // 2. Alamat asli
        $kandidat[] = $alamat;

        // 3. Ambil kata-kata terakhir (kecamatan + kota + provinsi)
        $bagian = array_filter(array_map('trim', explode(',', $alamat)));
        if (count($bagian) >= 2) {
            // Ambil 2 bagian terakhir
            $kandidat[] = implode(', ', array_slice($bagian, -2));
        }

        // 4. Ambil bagian terakhir saja (biasanya provinsi/kota)
        $kata = array_filter(array_map('trim', preg_split('/[\s,]+/', $alamat)));
        if (count($kata) >= 3) {
            // Ambil 3 kata terakhir
            $kandidat[] = implode(' ', array_slice($kata, -3));
        }
        if (count($kata) >= 2) {
            // Ambil 2 kata terakhir
            $kandidat[] = implode(' ', array_slice($kata, -2));
        }

        // Hapus duplikat dan kosong
        return array_values(array_unique(array_filter($kandidat)));
    }
}