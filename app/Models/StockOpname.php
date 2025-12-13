<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOpname extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'besi_id',
        'stok_fisik',

    ];

    /**
     * Relasi ke tabel besi
     */
    public function besi()
    {
        return $this->belongsTo(Besi::class);
    }

    /**
     * Attribute dinamis: selisih
     * (stok sistem - stok fisik)
     */
    public function getSelisihAttribute()
    {
        return ($this->besi->stok ?? 0) - $this->stok_fisik;
    }

    public function pabrik()
{
    return $this->belongsTo(Pabrik::class);
}
}
