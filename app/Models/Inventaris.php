<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventaris extends Model
{
    use HasFactory;

    protected $table = 'inventaris';

    protected $fillable = [
    'kode_barang',
    'nama_barang',
    'kategori',
    'jumlah_total',
    'jumlah_tersedia',
    'satuan',
    'kondisi',
    'lokasi',
    'keterangan',
];

}
