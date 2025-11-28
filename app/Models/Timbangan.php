<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timbangan extends Model
{
    protected $fillable = [
        'kode',
        'besi_id',
        'jenis',
        'berat',
        'harga',
        'status'
    ];

    // RELASI KE TABEL BESI
    public function besi()
    {
        return $this->belongsTo(Besi::class, 'besi_id');
    }
}
