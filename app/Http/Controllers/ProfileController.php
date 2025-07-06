<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    // Method untuk menampilkan halaman pengaturan profil
    public function index()
    {
        $user = Auth::user();
        return view('view-customer.setting-customer', compact('user'));
    }

    // Method untuk memperbarui informasi personal
    public function updatePersonal(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'phone_number' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            // 'profile_picture' validasi di sini redundant karena sudah ditangani di updateProfilePicture
            // 'profile_picture'   => 'nullable|image|mimes:jpg,jpeg,png|max:1024',
        ]);

        // Update data user
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->date_of_birth = $request->date_of_birth;

        $user->save();

        // Redirect dengan pesan sukses
        return redirect()->route('setting-customer')->with('success', 'Informasi personal berhasil diperbarui!');
    }

    // Method untuk memperbarui foto profil
    public function updateProfilePicture(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
        ]);

        if ($request->hasFile('profile_picture')) {
            $imageName = time() . '.' . $request->file('profile_picture')->getClientOriginalExtension();
            $destinationPath = 'profile/' . $imageName; // Path relatif yang akan disimpan di DB

            // Hapus gambar profil lama jika ada
            if ($user->profile_picture) {
                // Periksa apakah gambar lama ada di direktori public dan hapus
                if (file_exists(public_path($user->profile_picture))) {
                    unlink(public_path($user->profile_picture));
                }
                if ($user->profile_picture && file_exists(public_path('profile/' . $user->profile_picture))) {
                    unlink(public_path('profile/' . $user->profile_picture));
                }
            }

            // Pindahkan file baru ke direktori public/profile
            $request->file('profile_picture')->move(public_path('profile'), $imageName);

            // Perbarui atribut profile_picture user dengan path relatif
            $user->profile_picture = $destinationPath;
            $user->save();

            return back()->with('success', 'Profil berhasil diperbarui.');
        }

        return back()->with('error', 'Gagal mengunggah foto profil.');
    }

    // Anda juga bisa menambahkan method untuk update password, dll.
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

        return redirect()->route('setting-customer')->with('success', 'Kata sandi berhasil diperbarui!');
    }
}