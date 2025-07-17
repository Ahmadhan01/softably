<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SellerSettingController extends Controller
{
    /**
     * Tampilkan halaman pengaturan profil seller.
     */
    public function index()
    {
        $user = Auth::user();
        return view('view-seller.setting-seller', compact('user'));
    }

    /**
     * Update data profil seller (name, username, email, phone_number, date_of_birth, country, profile_picture).
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            // 'country' => 'nullable|string|max:100',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:1024', // max 1MB
        ]);

        // Update data user
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->date_of_birth = $request->date_of_birth;
        // $user->country = $request->country;

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            $imageName = time() . '.' . $request->file('profile_picture')->getClientOriginalExtension();
            $destination = public_path('profile');

            // Pastikan direktori ada
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            // Hapus gambar lama jika ada dan bukan default
            if ($user->profile_picture && $user->profile_picture !== 'img/default-profile.jpg') {
                $oldImagePath = public_path($user->profile_picture);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Pindahkan file baru
            $request->file('profile_picture')->move($destination, $imageName);

            // Simpan path relatif ke database
            $user->profile_picture = 'profile/' . $imageName;
        }

        $user->save();

        return redirect()->route('seller.setting')->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Update password seller.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Kata sandi saat ini salah.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('seller.setting')->with('success', 'Kata sandi berhasil diperbarui!');
    }
}
