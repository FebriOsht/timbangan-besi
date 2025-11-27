<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StockOpnameController extends Controller
{
    // Menampilkan halaman index
    public function index()
    {
        return view('admin.stock_opname.index');
    }
}
