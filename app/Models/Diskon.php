<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diskon extends Model
{
    protected $fillable = ['kode_diskon','nama', 'potongan'];
}
