<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class UpdateLastSeen
{
    public function handle(Request $request, Closure $next)
    {

        
        if (Auth::check()) {
            /** @var \App\Models\User $user */
            $user = Auth::user();

            Log::info('User masuk middleware:', ['id' => $user->id, 'last_seen' => $user->last_seen]);

            if (!$user->last_seen || $user->last_seen->diffInSeconds(now()) > 60) {
                $user->last_seen = now();
                $user->save();
                Log::info('last_seen diupdate:', ['id' => $user->id]);
            }
        }

        return $next($request);
    }
}
