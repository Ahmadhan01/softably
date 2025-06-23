<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminSettingController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'username'=> 'required|string|max:255',
            'email'   => 'required|email|unique:users,email,' . Auth::id(),
            'phone_number'   => 'nullable|string|max:20',
            'date_of_birth'     => 'nullable|date',
            'country' => 'nullable|string|max:100',
            'profile_picture'   => 'nullable|image|mimes:jpg,jpeg,png|max:1024',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $user->fill($request->only(['name', 'username', 'email', 'phone_number', 'date_of_birth', 'country']));

        if ($request->hasFile('profile_picture')) {
            $imageName = time() . '.' . $request->file('profile_picture')->getClientOriginalExtension();

            $destination = public_path('profile');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            if ($user->profile_picture && file_exists($destination . '/' . $user->profile_picture)) {
                unlink($destination . '/' . $user->profile_picture);
            }

            $request->file('profile_picture')->move($destination, $imageName);
            $user->profile_picture = $imageName;
        }

        $user->save();
 
        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    // App Settings - Tampilkan Halaman
public function appSettings()
{
    $settings = \App\Models\Setting::all()->keyBy('key');
    return view('view-admin.app-settings', compact('settings'));
}

// App Settings - Simpan Perubahan
public function updateAppSettings(Request $request)
{
    foreach ($request->except('_token') as $key => $value) {
        \App\Models\Setting::updateOrCreate(
            ['key' => $key],
            ['value' => is_array($value) ? json_encode($value) : $value]
        );
    }

    return back()->with('success', 'Pengaturan aplikasi berhasil diperbarui.');
}

}