<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    ];
}
