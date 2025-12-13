<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    protected $fillable = [
        'kode_nota',
        'tanggal_nota',
        'jenis_nota',
        'ppn',
        'customer_id',
        'pabrik_id',
        'user_id',
        'jenis_pembayaran',
    ];

    // =====================
    // RELASI UTAMA
    // =====================

    public function details()
    {
        return $this->hasMany(NotaDetail::class);
    }

    public function diskons()
    {
        return $this->hasMany(NotaDiskon::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function pabrik()
    {
        return $this->belongsTo(Pabrik::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
