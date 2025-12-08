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
    'is_transfer',
    'tanggal',
    'customer_id',
    'pabrik_id',
];


    // RELASI KE TABEL BESI
    // relations
    public function besi()
    {
        return $this->belongsTo(Besi::class);
    }

    public function customer()
    {
        return $this->belongsTo(\App\Models\Customer::class);
    }

    public function pabrik()
    {
        return $this->belongsTo(\App\Models\Pabrik::class);
    }
}
