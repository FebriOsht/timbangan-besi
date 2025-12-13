<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotaDiskon extends Model
{
    protected $fillable = [
        'nota_id',
        'nota_detail_id',
        'diskon_id',
        'tipe',
        'jenis',
        'nilai',
        'keterangan',
    ];

    public function nota()
    {
        return $this->belongsTo(Nota::class);
    }

    public function detail()
    {
        return $this->belongsTo(NotaDetail::class, 'nota_detail_id');
    }

    public function master()
    {
        return $this->belongsTo(Diskon::class, 'diskon_id');
    }
}
