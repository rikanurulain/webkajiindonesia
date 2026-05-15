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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}