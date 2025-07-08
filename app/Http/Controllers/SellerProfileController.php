<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule; // Import Rule

class SellerProfileController extends Controller
{
    public function index()
    {
        $loggedInUser = Auth::user();
        // You might load additional seller-specific data here
        return view('view-seller.settings-seller', compact('loggedInUser')); // Assuming your seller settings view is here
    }

    public function updatePersonal(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            // Add other seller-specific fields here, e.g., 'store_name', 'store_description'
            'store_name' => ['nullable', 'string', 'max:255'],
            'store_description' => ['nullable', 'string'],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'date_of_birth' => ['nullable', 'date'],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->store_name = $request->store_name; // Assuming you have this column in your users table
        $user->store_description = $request->store_description; // Assuming you have this column
        $user->phone_number = $request->phone_number; // Assuming you have this column
        $user->date_of_birth = $request->date_of_birth; // Assuming you have this column
        $user->save();

        return back()->with('success', 'Personal information updated successfully!');
    }

    public function updateProfilePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);

        $user = Auth::user();

        if ($request->hasFile('profile_picture')) {
            // Delete old picture if exists
            if ($user->profile_picture_url && file_exists(public_path($user->profile_picture_url))) {
                unlink(public_path($user->profile_picture_url));
            }

            $imageName = time().'.'.$request->profile_picture->extension();
            $request->profile_picture->move(public_path('uploads/profile_pictures'), $imageName);
            $user->profile_picture_url = 'uploads/profile_pictures/' . $imageName;
            $user->save();
        }

        return back()->with('success', 'Profile picture updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password updated successfully!');
    }
}