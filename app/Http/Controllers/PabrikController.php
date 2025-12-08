<?php

namespace App\Http\Controllers;

use App\Models\Pabrik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PabrikController extends Controller
{
    public function index()
    {
        return view('admin.master.pabrik.index', [
            'pabriks' => Pabrik::orderBy('id', 'desc')->paginate(10)

        ]);
    }

    private function generateKodePabrik()
    {
        $bulan = now()->format('m');
        $tahun = now()->format('y');

        // Ambil nomor urut terakhir bulan ini
        $last = Pabrik::whereMonth('created_at', now()->month)
                      ->whereYear('created_at', now()->year)
                      ->orderBy('id', 'desc')
                      ->first();

        if ($last) {
            $lastNumber = intval(substr($last->kode_pabrik, -3));
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        $ZZZ = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        return "P{$bulan}{$tahun}{$ZZZ}";
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
        ]);

        $kode = $this->generateKodePabrik();

        $pabrik = Pabrik::create([
            'kode_pabrik' => $kode,
            'nama'        => $request->nama,
            'alamat'      => $request->alamat,
            'rekening'    => $request->rekening,
            'kontak'      => $request->kontak,
        ]);

        return back()->with('success', "Pabrik berhasil ditambahkan! Kode: {$pabrik->kode_pabrik}");
    }

    public function update(Request $request, Pabrik $pabrik)
    {
        $request->validate([
            'nama' => 'required',
        ]);

        $pabrik->update([
            'nama'        => $request->nama,
            'alamat'      => $request->alamat,
            'rekening'    => $request->rekening,
            'kontak'      => $request->kontak,
        ]);

        return back()->with('success', 'Pabrik berhasil diperbarui!');
    }

    public function destroy(Pabrik $pabrik)
    {
        $pabrik->delete();
        return back()->with('success', 'Pabrik berhasil dihapus!');
    }
}
