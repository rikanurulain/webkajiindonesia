<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Produk extends Model
{
    protected $fillable = [
        'nama',
        'kategori',
        'deskripsi',
        'keterangan',
        'harga',
        'foto',
        'foto_detail',
        'whatsapp',
        'alamat',
        'koordinat',
        'status',
        'catatan_admin',
        'approved_at',
        'approved_by',
        'rejected_at',
        'rejected_by',
        'user_id',      // FK ke user (UMKM pemilik produk)
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
}