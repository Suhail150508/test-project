<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class UserActivity
{
    public function handle(Request $request, Closure $next)
    {
        if (auth('sanctum')->check()) {
            $expiresAt = now()->addMinutes(2); /* keep online for 2 min */
            Cache::put('user-is-online-' . auth('sanctum')->user()->id, true, $expiresAt);

            /* last seen */
            User::where('id', auth('sanctum')->user()->id)->update(['last_seen' => now()]);
        }

        return $next($request);
    }
}
