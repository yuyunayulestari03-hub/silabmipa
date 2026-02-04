<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPratikum extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kegiatan',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
