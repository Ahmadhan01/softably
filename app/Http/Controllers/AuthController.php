<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Pusher\Pusher; // Import class Pusher

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            'role' => 'required|in:admin,seller,customer'
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Register berhasil. Silakan login.');
    }


    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        // Cek apakah input 'login' itu email atau username
        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (Auth::attempt([$loginType => $request->login, 'password' => $request->password], $request->remember)) {
            $request->session()->regenerate();

            $user = Auth::user(); // ambil user yang sudah login

            // === Bagian Penambahan untuk Status Online (Pusher) ===
            // Inisialisasi Pusher
            $pusher = new Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                [
                    'cluster' => env('PUSHER_APP_CLUSTER'),
                    'useTLS' => true
                ]
            );

            // Trigger event 'user-online' ke presence channel 'presence-chat'
            $pusher->trigger('presence-chat', 'user-online', [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name, // Kirim nama user juga
                ]
            ]);
            // === Akhir Bagian Penambahan ===

            // 🔁 Arahkan berdasarkan role
            return match ($user->role) {
                'admin' => redirect()->route('admin.dashboard'),
                'seller' => redirect()->route('seller.dashboard'),
                'customer' => redirect()->route('customer.produk'),
                default => abort(403, 'Role tidak dikenali'),
            };
        }

        // Jika login gagal
        return back()->withErrors([
            'login' => 'Username/email atau password salah.',
        ])->withInput();
    }


    public function logout(Request $request)
    {
        $user = Auth::user(); // Ambil user sebelum logout

        // === Bagian Penambahan untuk Status Offline (Pusher) ===
        // Inisialisasi Pusher
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'useTLS' => true
            ]
        );

        // Trigger event 'user-offline' ke presence channel 'presence-chat'
        $pusher->trigger('presence-chat', 'user-offline', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name, // Kirim nama user juga
            ]
        ]);
        // === Akhir Bagian Penambahan ===

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}