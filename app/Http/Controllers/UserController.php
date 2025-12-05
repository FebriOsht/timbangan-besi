<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // default password new user & reset
    private $defaultPassword = 'password123';

    public function index(Request $request)
    {
        $q        = $request->query('q');
        $role     = $request->query('role');
        $perPage  = (int) $request->query('per_page', 10);

        $query = User::query();

        // Search
        if ($q) {
            $query->where(function($qbuilder) use ($q) {
                $qbuilder->where('first_name', 'like', "%{$q}%")
                         ->orWhere('last_name', 'like', "%{$q}%")
                         ->orWhere('email', 'like', "%{$q}%")
                         ->orWhereRaw("CONCAT(phone_code, phone_number) LIKE ?", ["%{$q}%"]);
            });
        }

        // Filter role
        if ($role) {
            $query->where('role', $role);
        }

        $users = $query->orderBy('created_at', 'desc')
                       ->paginate($perPage)
                       ->withQueryString();

        return view('admin.master.user.index', [
            'title'        => 'Data User',
            'users'        => $users,
            'search_q'     => $q ?? '',
            'filter_role'  => $role ?? '',
            'per_page'     => $perPage,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name'   => 'required|string|max:100',
            'last_name'    => 'nullable|string|max:100',
            'email'        => 'required|email|unique:users,email',
            'phone_code'   => 'nullable|string|max:10',
            'phone_number' => 'nullable|string|max:20',
            'role'         => ['required', Rule::in(['Admin','Operator','User'])],
            'password'     => 'nullable|string|min:6|confirmed',
        ]);

        // Determine password (use provided or default)
        $passwordToUse = $request->filled('password') ? $request->password : $this->defaultPassword;

        // CREATE USER
        $user = User::create([
            'first_name'   => $request->first_name,
            'last_name'    => $request->last_name,
            'email'        => $request->email,
            'phone_code'   => $request->phone_code,
            'phone_number' => $request->phone_number,
            'role'         => $request->role,
            'password'     => bcrypt($passwordToUse),
            'profile_photo'=> null, // auto avatar
        ]);

  

        return back()->with('success', 'User berhasil ditambahkan');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'first_name'   => 'required|string|max:100',
            'last_name'    => 'nullable|string|max:100',
            'email'        => ['required','email', Rule::unique('users')->ignore($user->id)],
            'phone_code'   => 'nullable|string|max:10',
            'phone_number' => 'nullable|string|max:20',
            'role'         => ['required', Rule::in(['Admin','Operator','User'])],
            'password'     => 'nullable|string|min:6|confirmed',
        ]);

        $user->update([
            'first_name'   => $request->first_name,
            'last_name'    => $request->last_name,
            'email'        => $request->email,
            'phone_code'   => $request->phone_code,
            'phone_number' => $request->phone_number,
            'role'         => $request->role,
        ]);

        // Jika password diisi, update tanpa memerlukan current password
        if ($request->filled('password')) {
            $user->update(['password' => bcrypt($request->password)]);
        }

 

        return back()->with('success', 'User berhasil diupdate')
                     ->with('open_edit_modal', $user->id);
    }

    public function destroy(User $user)
    {
        $name = "{$user->first_name} {$user->last_name}";
        $user->delete();



        return back()->with('success', 'User berhasil dihapus');
    }

    // Reset Password
    public function resetPassword(User $user)
    {
        $user->update([
            'password' => bcrypt($this->defaultPassword),
        ]);



        if (request()->expectsJson()) {
            return response()->json([
                'success' => true, 
                'message' => 'Password di-reset ke: ' . $this->defaultPassword
            ]);
        }

        return back()->with('success', 'Password berhasil di-reset ke: ' . $this->defaultPassword);
    }
}
