<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        

        return view('admin.laporan.index');
        
    }
}
