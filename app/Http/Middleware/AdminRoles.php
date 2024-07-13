<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdminRoles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  array  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // JWT içinden kullanıcının token'ını al
        $user = JWTAuth::parseToken()->authenticate();

        // Kullanıcının rolleri
        $userRoles = $user->roles()->pluck('name')->toArray();
        // İstenen rollerden herhangi biri varsa izin ver
        foreach ($roles as $role) {
            if (in_array($role, $userRoles)) {
                return $next($request);
            }
        }

        // Eğer rol yoksa hata döndür
        return response()->json([
            'message' => 'Yetkisiz erişim. Gerekli role sahip değilsiniz.'
        ], Response::HTTP_FORBIDDEN);
    }
}
