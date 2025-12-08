<?php

namespace App\Http\Controllers;

use App\Models\Diskon;
use Illuminate\Http\Request;

class DiskonController extends Controller
{
    // ============================
    // GENERATE KODE DISKON
    // ============================
    private function generateKodeDiskon()
    {
        $bulan = date('m');
        $tahun = date('y');

        $prefix = "D{$bulan}{$tahun}";

        // Ambil nomor urut terakhir berdasarkan prefix
        $last = Diskon::where('kode_diskon', 'like', $prefix . '%')
            ->orderBy('kode_diskon', 'desc')
            ->first();

        if (!$last) {
            $urut = 1;
        } else {
            // Ambil 3 digit terakhir
            $lastNum = (int)substr($last->kode_diskon, -3);
            $urut = $lastNum + 1;
        }

        return $prefix . str_pad($urut, 3, '0', STR_PAD_LEFT);
    }

    // ============================
    // INDEX
    // ============================
public function index(Request $request)
{
    $query = Diskon::query();

    // =============== SEARCH ===============
    if ($request->filled('search')) {
        $query->where('nama', 'like', '%' . $request->search . '%');
    }

    // =============== SORT ===============
    $sortBy = $request->get('sort_by', 'nama');   
    $sortDir = $request->get('sort_dir', 'asc');  

    if (!in_array($sortBy, ['nama', 'potongan'])) {
        $sortBy = 'nama';
    }

    $query->orderBy($sortBy, $sortDir);

    // =============== PAGINATION ===============
    $data = $query->paginate(10)->withQueryString();

    // Auto-generate kode baru
    $kodeBaru = $this->generateKodeDiskon();

    return view('admin.master.diskon.index', compact('data', 'kodeBaru', 'sortBy', 'sortDir'));
}


    // ============================
    // STORE
    // ============================
    public function store(Request $request)
    {
        $request->validate([
            'nama'      => 'required',
            'potongan'  => 'required|numeric'
        ]);

        $d = Diskon::create([
            'kode_diskon' => $this->generateKodeDiskon(),
            'nama'        => $request->nama,
            'potongan'    => $request->potongan
        ]);

        // If request expects JSON (AJAX), return the created resource
        if ($request->wantsJson() || $request->expectsJson() || $request->isJson()) {
            return response()->json($d, 201);
        }

        return back()->with('success', 'Diskon berhasil ditambahkan!');
    }

    /**
     * Search diskon (AJAX) - returns JSON list
     */
    public function search(Request $request)
    {
        $q = $request->get('q', '');

        $query = Diskon::query();

        if (strlen($q) > 0) {
            $query->where('nama', 'like', "%{$q}%");
        }

        $data = $query->orderBy('nama')->limit(50)->get(['id', 'nama', 'potongan']);

        return response()->json($data);
    }

    // ============================
    // UPDATE
    // ============================
    public function update(Request $request, $id)
    {
        $diskon = Diskon::findOrFail($id);

        $request->validate([
            'nama'      => 'required',
            'potongan'  => 'required|numeric'
        ]);

        // kode_diskon tidak boleh berubah
        $diskon->update([
            'nama'      => $request->nama,
            'potongan'  => $request->potongan
        ]);

        return back()->with('success', 'Diskon berhasil diupdate!');
    }

    // ============================
    // DELETE
    // ============================
    public function destroy($id)
    {
        Diskon::findOrFail($id)->delete();
        return back()->with('success', 'Diskon berhasil dihapus!');
    }
}
