<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class LogVisitTest
{
    public function handle($request, Closure $next)
    {
        Log::info('✅ LogVisitTest middleware aktif di: ' . $request->path());
        return $next($request);
    }
}
