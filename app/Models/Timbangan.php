<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timbangan extends Model
{
    protected $fillable = [
        'kode',
        'jenis',
        'berat',
        'harga',
        'status'
    ];
}
