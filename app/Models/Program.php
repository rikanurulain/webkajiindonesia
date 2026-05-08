<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Program extends Model
{
    protected $fillable = [
        'judul',
        'deskripsi',
        'metode',
        'tingkat',
        'durasi',
        'kuota',
        'bahasa',
        'status',
        'catatan_admin',
        'approved_at',
        'approved_by',
        'rejected_at',
        'rejected_by',
        'trainer_id',
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
    public function pembimbing(): BelongsTo
    {
        return $this->belongsTo(Trainer::class, 'trainer_id');
    }
}