<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pabrik extends Model
{
    protected $fillable = ['kode_pabrik','nama', 'alamat', 'rekening', 'kontak'];
}
