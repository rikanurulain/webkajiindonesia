<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mentor extends Model
{
    protected $table = 'mentor';
    protected $fillable = [
        'nama',
        'role',
        'lokasi',
        'foto',
        'deskripsi',
        'ulasan',
    ];
}
