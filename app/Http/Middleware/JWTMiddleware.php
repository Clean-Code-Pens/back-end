<?php

namespace App\Http\Middleware;

use Tymon\JWTAuth\Facades\JWTAuth;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

     public function handle(Request $request, Closure $next, ...$roles)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException) {
                return $this->sendErrorToken('Token is Invalid');
            } else if ($e instanceof \PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException) {
                try {
                    if ($request->is('api/auth/refresh')) {
                        return $next($request);
                    } else {
                        $user = JWTAuth::parseToken()->authenticate();
                    }
                } catch (Exception $e) {
                    return $this->sendErrorToken('Token is Expired');
                }
            } else {
                return $this->sendErrorToken('Authorization Token not found');
            }
        }

        if (!$roles) {
            return $next($request);
        }

        if ($user && in_array($user->role_id, $roles)) {
            return $next($request);
        }
        return $this->unauthorized("You don't have permission to this route");
    }
    

    protected function unauthorized($message)
    {
        return response()->json([
            'success' => false,
            'refresh' => false,
            'message' => $message
        ], Response::HTTP_UNAUTHORIZED);
    }

    protected function sendErrorToken($message)
    {
        return response()->json([
            'success' => false,
            'refresh' => false,
            'message' => $message
        ], Response::HTTP_BAD_REQUEST);
    }
}
