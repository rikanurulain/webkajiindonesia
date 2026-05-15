<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Produk extends Model
{
    protected $fillable = [
    'user_id',
    'nama',
    'kategori',
    'owner',
    'kontak',
    'nib',
    'id_tkm',
    'provinsi',        
    'kabupaten_kota',  
    'kecamatan',       
    'kelurahan',       
    'alamat',
    'deskripsi',
    'logo',            
    'foto_produk',
    'status',
];

    protected $casts = [
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    // ── Scopes ──────────────────────────────────
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApprovedThisMonth($query)
    {
        return $query->where('status', 'approved')
                     ->whereMonth('updated_at', now()->month)
                     ->whereYear('updated_at', now()->year);
    }

    // ── Relasi ──────────────────────────────────
    // Relasi ke user UMKM pemilik produk
    public function umkm(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function petaData()
{
    $data = \App\Models\Produk::whereNotNull('lat')
                ->whereNotNull('lng')
                ->where('status', 'approved')
                ->get(['id', 'nama', 'alamat', 'lat', 'lng', 'foto']);

    return response()->json(['data' => $data]);
}
}