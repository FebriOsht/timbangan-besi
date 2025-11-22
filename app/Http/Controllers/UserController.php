<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.master.user.index', [
            'title' => 'Data User',
            'users' => User::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'role' => 'required'
        ]);

        User::create([
            'name' => $request->name,
            'role' => $request->role,
            'email' => strtolower(str_replace(' ', '', $request->name)) . '@mail.com',
            'password' => bcrypt('password'),
        ]);

        return back()->with('success', 'User berhasil ditambahkan');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'role' => 'required'
        ]);

        $user->update([
            'name' => $request->name,
            'role' => $request->role
        ]);

        return back()->with('success', 'User berhasil diupdate');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return back()->with('success', 'User berhasil dihapus');
    }
}
