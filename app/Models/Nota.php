<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    use HasFactory;

    protected $table = 'notas';

    protected $fillable = [
        'kode_nota',
        'besi_id',
        'timbangan_id',
        'customer_id',
        'pabrik_id',
        'user_id',
        'jenis_pembayaran',
        'total_bayar',
        'tanggal_nota',
        'jenis_nota',
        'ppn',
    ];

    // RELASI
    public function besi()
    {
        return $this->belongsTo(Besi::class);
    }

    public function timbangan()
    {
        return $this->belongsTo(Timbangan::class);
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
