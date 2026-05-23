<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mentor extends Model
{
    protected $table = 'mentor';

    protected $fillable = [
        'user_id',
        'nama',
        'full_name',
        'role',
        'lokasi',
        'gmaps_location',
        'provinsi',
        'kabupaten',
        'kecamatan',
        'kelurahan',
        'lat',
        'lng',
        'foto',
        'white_bg_photo',
        'ktp_scan',
        'bukti_transfer',
        'agree_terms',
        'deskripsi',
        'bio',
        'phone',
        'email',
        'ulasan',
        'status',
        'rejection_reason',
        'reviewed_at',
    ];

    protected $casts = [
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
        'reviewed_at' => 'datetime',
        'agree_terms' => 'boolean',
    ];

    /**
     * Mengembalikan alamat yang layak ditampilkan ke publik.
     * Prioritas: gmaps_location > wilayah (kecamatan/kabupaten/provinsi) > lokasi
     */
    public function getAlamatTampilAttribute(): ?string
    {
        $isKoordinat = fn($s) => $s && preg_match('/^-?\d+\.\d+\s*,\s*-?\d+\.\d+$/', trim($s));

        if ($this->gmaps_location && !$isKoordinat($this->gmaps_location)) {
            return $this->gmaps_location;
        }

        $wilayah = trim(implode(', ', array_filter([
            $this->kecamatan,
            $this->kabupaten,
            $this->provinsi,
        ])));
        if ($wilayah) return $wilayah;

        if ($this->lokasi && !$isKoordinat($this->lokasi)) {
            return $this->lokasi;
        }

        return null;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * UMKM (Produk) yang terhubung dengan mentor ini
     */
    public function produks()
    {
        return $this->hasMany(Produk::class, 'mentor_id');
    }

    /**
     * Semua ulasan untuk mentor ini
     */
    public function ulasanList()
    {
        return $this->hasMany(MentorUlasan::class, 'mentor_id');
    }

    /**
     * Rata-rata rating dari ulasan
     */
    public function getAvgRatingAttribute(): float
    {
        return round($this->ulasanList()->avg('rating') ?? 0, 1);
    }

    /**
     * Total jumlah ulasan
     */
    public function getTotalUlasanAttribute(): int
    {
        return $this->ulasanList()->count();
    }
}