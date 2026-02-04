<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeminjamanInventaris extends Model
{
    protected $table = 'peminjaman_inventaris';

    protected $fillable = [
        'user_id',
        'inventaris_id',
        'jumlah',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
        'keterangan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function inventaris()
    {
        return $this->belongsTo(Inventaris::class);
    }
}
