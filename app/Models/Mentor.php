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
    'foto', 
    'white_bg_photo', 
    'ktp_scan', 
    'deskripsi', 
    'bio',
    'phone', 
    'email', 
    'ulasan', 
    'status', 
    'rejection_reason', 
    'reviewed_at',
    ];

        public function user()
    {
        return $this->belongsTo(User::class);
    }
}
