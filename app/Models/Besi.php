<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Besi extends Model
{
    protected $table = 'besi'; // ← perbaikan penting

    protected $fillable = [
        'kode',
        'nama',
        'jenis',
        'harga',
        'stok'
    ];
}
