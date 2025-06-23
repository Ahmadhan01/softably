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
            'phone'   => 'nullable|string|max:20',
            'dob'     => 'nullable|date',
            'country' => 'nullable|string|max:100',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png|max:1024',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $user->fill($request->only(['name', 'username', 'email', 'phone', 'dob', 'country']));

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->file('image')->getClientOriginalExtension();

            $destination = public_path('profile');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            if ($user->image && file_exists($destination . '/' . $user->image)) {
                unlink($destination . '/' . $user->image);
            }

            $request->file('image')->move($destination, $imageName);
            $user->image = $imageName;
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
