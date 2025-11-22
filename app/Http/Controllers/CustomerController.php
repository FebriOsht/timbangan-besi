<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        return view('admin.master.customer.index', [
            'customers' => Customer::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required'
        ]);

        Customer::create($request->all());

        return back()->with('success', 'Customer berhasil ditambahkan!');
    }

    public function update(Request $request, Customer $customer)
    {
        $customer->update($request->all());

        return back()->with('success', 'Customer berhasil diperbarui!');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return back()->with('success', 'Customer berhasil dihapus!');
    }
}
