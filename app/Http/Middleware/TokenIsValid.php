<?php

namespace App\Http\Middleware;

use App\Models\Session;
use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;

class TokenIsValid
{
    public function handle($request, Closure $next)
    {
        if (!$token = JWTAuth::getToken()) {
            return response()->json(['error' => 'Token not provided'], 401);
        }

        $session = Session::where('token', $token)->first();
        if (!$session) {
            return response()->json(['message' => 'Oturumunuz sonlandırıldı.'], 401);
        }

        $session->update(['last_activity' => now()]);
        return $next($request);
    }
}
