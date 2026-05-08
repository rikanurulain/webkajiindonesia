<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    use HasFactory;

    protected $table = 'trainer';

    protected $fillable = [
        'nama',
        'foto',
        'bidang',
        'lokasi',
        'deskripsi',
        'keahlian',
        'no_hp',
        'email',
    ];

    public function ulasan()
    {
        return $this->hasMany(UlasanPembimbing::class, 'pembimbing_id');
    }
}