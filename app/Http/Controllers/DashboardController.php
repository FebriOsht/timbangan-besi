<?php

namespace App\Http\Controllers;

use App\Models\Besi;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung total besi yang memiliki stok lebih dari 0
        $totalBesiBerstock = Besi::where('stok', '>', 0)->count();

        return view('dashboard', [
            'totalBesiBerstock' => $totalBesiBerstock
        ]);
    }
}