<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ValidateToken {
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (empty($request->bearerToken()))
            return response()->json(['message' => 'Token invalid'], Response::HTTP_UNAUTHORIZED);
        $user = User::where('name', base64_decode($request->bearerToken()))->first();
        if (empty($user))
            return response()->json(['message' => 'User not registered'], Response::HTTP_UNAUTHORIZED);
        Auth::login($user);
        return $next($request);
    }
}
