<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\Pageview;

class TrackPageView

{
    public function handle($request, Closure $next)
    {
        // Daftar path yang ingin dilacak (bisa ditambah)
        $trackablePaths = [
            'admin/dashboard',
            'seller/dashboard',
            'customer/produks',
        ];

        $key = 'viewed:' . $request->path() . ':' . $request->ip();

        if (!cache()->has($key)) {
            Pageview::create([
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'user_id' => Auth::id(),
                'path' => $request->path(),
                'viewed_at' => now(),
            ]);

            // Simpan cache supaya tidak dicatat lagi selama 5 menit
            cache()->put($key, true, now()->addMinutes(5));
        }


        return $next($request);
    }
}
