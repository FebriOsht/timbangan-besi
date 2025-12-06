<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::query();

        // Search (nama, alamat, kontak)
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('alamat', 'like', '%' . $request->search . '%')
                  ->orWhere('kontak', 'like', '%' . $request->search . '%');
            });
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'nama');
        $sortDir = $request->get('sort_dir', 'asc');

        if (!in_array($sortBy, ['nama', 'alamat', 'rekening', 'kontak', 'created_at'])) {
            $sortBy = 'nama';
        }

        $query->orderBy($sortBy, $sortDir);

        return view('admin.master.customer.index', [
            'customers' => $query->paginate(10)->withQueryString()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
        ]);

        // Generate kode_customer
        $kodeCustomer = $this->generateKodeCustomer();

        $customer = Customer::create([
            'kode_customer' => $kodeCustomer,
            'nama'          => $request->nama,
            'alamat'        => $request->alamat,
            'rekening'      => $request->rekening,
            'kontak'        => $request->kontak,
        ]);

        return back()->with('success', 'Customer berhasil ditambahkan! ID: ' . $customer->kode_customer);
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'nama' => 'required',
        ]);

        $customer->update([
            'nama'     => $request->nama,
            'alamat'   => $request->alamat,
            'rekening' => $request->rekening,
            'kontak'   => $request->kontak,
        ]);

        return back()->with('success', 'Customer berhasil diperbarui!');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return back()->with('success', 'Customer berhasil dihapus!');
    }

    private function generateKodeCustomer()
    {
        $bulan = date('m');
        $tahun = date('y');

        $prefix = "C{$bulan}{$tahun}";

        // Ambil nomor urut terakhir bulan ini
        $last = Customer::where('kode_customer', 'like', $prefix . '%')
            ->orderBy('kode_customer', 'desc')
            ->first();

        if (!$last) {
            $urut = 1;
        } else {
            $lastNum = (int)substr($last->kode_customer, -3);
            $urut = $lastNum + 1;
        }

        return $prefix . str_pad($urut, 3, '0', STR_PAD_LEFT);
    }
}
