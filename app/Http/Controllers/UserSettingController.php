<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserSettingController extends Controller
{
    /**
     * Tampilkan halaman User Settings
     */
    public function index()
    {
        $user = Auth::user();
        return view('admin.user_setting.index', compact('user'));
    }


    /**
     * Update Profile (nama, email, phone, foto)
     */
    public function updateProfile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'nullable|string|max:255',
            'email'         => 'required|email|unique:users,email,' . $user->id,
            'phone_code'    => 'nullable|string|max:10',
            'phone_number'  => 'nullable|string|max:30',

            // upload foto (optional)
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);


        // Upload foto profil
        if ($request->hasFile('profile_photo')) {

            // hapus foto lama jika ada
            if ($user->profile_photo && Storage::exists($user->profile_photo)) {
                Storage::delete($user->profile_photo);
            }

            $path = $request->file('profile_photo')->store('profile_photos');
        } else {
            $path = $user->profile_photo; // tetap gunakan foto lama
        }

        $user->update([
            'first_name'    => $request->first_name,
            'last_name'     => $request->last_name,
            'email'         => $request->email,
            'phone_code'    => $request->phone_code,
            'phone_number'  => $request->phone_number,
            'profile_photo' => $path,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }


    /**
     * Update Password
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password'         => 'required',
            'current_password_confirm' => 'required|same:current_password',

            'new_password'             => 'required|min:6',
            'new_password_confirm'     => 'required|same:new_password',
        ]);

        // // Update password
        // $user->update([
        //     'password' => bcrypt($request->new_password)
        // ]);

        // return back()->with('success', 'Password berhasil diubah.');
    }
}
