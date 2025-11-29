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
        'status',
        'is_cetak',
        'is_transfer'
    ];

    // RELASI KE TABEL BESI
    public function besi()
    {
        return $this->belongsTo(Besi::class, 'besi_id');
    }
}
