<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use App\Models\Timbangan;
use App\Models\Pabrik;
use App\Models\Customer;
use Illuminate\Http\Request;

class NotaController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data timbangan jika ada "ids" dari transfer
        $timbangan = [];

        if ($request->has('ids')) {
            $ids = explode(',', $request->ids);
            $timbangan = Timbangan::with('besi')->whereIn('id', $ids)->get();
        }

        return view('admin.nota.index', [
            'timbangan' => $timbangan,
            'pabrik'    => Pabrik::all(),
            'customer'  => Customer::all(),
        ]);
    }

    /**
     * CREATE (alias untuk index dengan query params)
     * Digunakan saat transfer dari timbangan page
     */
    public function create(Request $request)
    {
        return $this->index($request);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nomor_nota'       => 'required|string',
            'tanggal_nota'     => 'required|date',
            'nama_supplier'    => 'nullable|string',
            'customer'         => 'nullable|string',
            'nama_barang'      => 'required|string',
            'harga_per_kg'     => 'required|integer',
            // 'total_berat'      -> 'required|integer',
            'potongan'         => 'nullable|integer',
            'jenis_pembayaran' => 'required|in:tunai,transfer,tempo',
            'total_bayar'      => 'required|integer',
        ]);

        Nota::create($data);

        return redirect()->back()->with('success', 'Nota berhasil disimpan.');
    }

    public function cetak()
    {
        return view('admin.nota.cetak_nota');
    }
}
