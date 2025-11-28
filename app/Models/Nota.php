<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_nota',
        'tanggal_nota',
        'nama_supplier',
        'customer',
        'nama_barang',
        'harga_per_kg',
        'total_berat',
        'potongan',
        'jenis_pembayaran',
        'total_bayar',
    ];
}
