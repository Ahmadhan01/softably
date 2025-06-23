<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request; // Tambahkan ini
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response; // Tambahkan ini

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles // Menggunakan variadic argument untuk multiple roles
     * @return \Symfony\Component\HttpFoundation\Response   
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {   
        // 1. Cek apakah pengguna sudah login
        if (!Auth::check()) {
            // Jika belum login, arahkan ke halaman login
            // Anda bisa juga menggunakan abort(401) untuk Unauthorized
            return redirect()->route('login');
        }

        $user = Auth::user();

        // 2. Cek apakah pengguna memiliki salah satu dari peran yang diizinkan
        //    menggunakan in_array untuk memeriksa multiple roles
        if (!in_array($user->role, $roles)) {
            // Jika peran tidak cocok, arahkan ke halaman error atau berikan respons 403
            // Anda bisa memberikan pesan kustom juga
            abort(403, 'Unauthorized action. You do not have the necessary role to access this page.');
        }

        // 3. Lanjutkan request jika otorisasi berhasil
        return $next($request);
    }
}