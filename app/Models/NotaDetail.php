<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotaDetail extends Model
{
    protected $fillable = [
        'nota_id',
        'timbangan_id',
        'besi_id',
    ];

    public function nota()
    {
        return $this->belongsTo(Nota::class);
    }

    public function timbangan()
    {
        return $this->belongsTo(Timbangan::class);
    }

    public function besi()
    {
        return $this->belongsTo(Besi::class);
    }

    public function diskons()
    {
        return $this->hasMany(NotaDiskon::class);
    }
}
