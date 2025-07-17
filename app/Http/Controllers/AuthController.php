<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Pusher\Pusher;
use Illuminate\Support\Facades\Log; // TAMBAHKAN INI

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

        return redirect()->route('login')->with('status', 'Register berhasil. Silakan login.');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (Auth::attempt([$loginType => $request->login, 'password' => $request->password], $request->remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->is_banned) {
                Auth::logout();
                return redirect()->back()->withErrors([
                    'login' => 'Akun Anda telah dibanned.',
                ])->withInput();
            }

            // === Status Online dengan Pusher (Modifikasi) ===
            // Pastikan environment variables Pusher tersedia sebelum menginisialisasi
            // $pusherAppKey = env('PUSHER_APP_KEY');
            // $pusherAppSecret = env('PUSHER_APP_SECRET');
            // $pusherAppId = env('PUSHER_APP_ID');
            // $pusherAppCluster = env('PUSHER_APP_CLUSTER');

            $pusherAppKey = config('services.pusher.app_key');
            $pusherAppSecret = config('services.pusher.app_secret');
            $pusherAppId = config('services.pusher.app_id');
            $pusherAppCluster = config('services.pusher.option.app_cluster');

            if ($pusherAppKey && $pusherAppSecret && $pusherAppId && $pusherAppCluster) {
                try {
                    $pusher = new Pusher(
                        $pusherAppKey,
                        $pusherAppSecret,
                        $pusherAppId,
                        [
                            'cluster' => $pusherAppCluster,
                            'useTLS' => true
                        ]
                    );

                    $pusher->trigger('presence-chat', 'user-online', [
                        'user' => [
                            'id' => $user->id,
                            'name' => $user->name,
                        ]
                    ]);
                } catch (\Exception $e) {
                    Log::error('Pusher initialization or trigger failed in AuthController@login: ' . $e->getMessage());
                    // Anda bisa tambahkan toast atau log lain jika inisialisasi Pusher gagal
                }
            } else {
                Log::warning('Pusher environment variables are not fully set in AuthController@login. Skipping Pusher trigger.');
            }
            // === Akhir status online ===

            return response()->json([
                'message' => 'Login berhasil!',
                'redirect_url' => match ($user->role) {
                    'admin' => route('admin.dashboard'),
                    'seller' => route('seller.dashboard'),
                    'customer' => route('customer.produk'),
                    default => '/',
                }
            ], 200);
        }

        return back()->withErrors([
            'login' => 'Email atau password salah.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        $pusherAppKey = env('PUSHER_APP_KEY');
        $pusherAppSecret = env('PUSHER_APP_SECRET');
        $pusherAppId = env('PUSHER_APP_ID');
        $pusherAppCluster = env('PUSHER_APP_CLUSTER');

        if ($pusherAppKey && $pusherAppSecret && $pusherAppId && $pusherAppCluster) {
            try {
                $pusher = new Pusher(
                    $pusherAppKey,
                    $pusherAppSecret,
                    $pusherAppId,
                    [
                        'cluster' => $pusherAppCluster,
                        'useTLS' => true
                    ]
                );

                $pusher->trigger('presence-chat', 'user-offline', [
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                    ]
                ]);
            } catch (\Exception $e) {
                Log::error('Pusher initialization or trigger failed in AuthController@logout: ' . $e->getMessage());
            }
        } else {
            Log::warning('Pusher environment variables are not fully set in AuthController@logout. Skipping Pusher trigger.');
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}