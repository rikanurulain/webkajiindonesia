<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembimbing extends Model
{
    protected $table = 'pembimbing';
    protected $fillable = [
        'nama',
        'role',
        'lokasi',
        'foto',
        'deskripsi',
        'ulasan',
    ];
}
