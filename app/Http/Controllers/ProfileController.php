<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule; // Import Rule
use Illuminate\Support\Facades\Storage; // Import Storage

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
                Rule::unique('users')->ignore($user->id), // Pastikan email unik kecuali email user sendiri
            ],
            'phone_number' => 'nullable|string|max:20', // Sesuaikan validasi nomor telepon jika perlu
            'date_of_birth' => 'nullable|date',
            // 'country' => 'nullable|string|max:255', // Negara mungkin tidak perlu di-update jika disabled di frontend
        ]);

        // Update data user
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->date_of_birth = $request->date_of_birth;
        // $user->country = $request->country; // Jika ingin bisa diupdate, hapus disabled di blade

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
            // Hapus foto lama jika ada dan bukan gambar default
            if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture) && $user->profile_picture !== 'img/default-user.jpg') {
                Storage::disk('public')->delete($user->profile_picture);
            }

            // Simpan foto baru di direktori 'profile_pictures' dalam storage/app/public
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
            $user->save();

            return redirect()->route('setting-customer')->with('success', 'Foto profil berhasil diunggah!');
        }

        return redirect()->route('setting-customer')->with('error', 'Gagal mengunggah foto profil.');
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