<?php

namespace App\Http\Middleware;

use App\Data\Auth\AuthUser;
use App\Enums\UserRole;
use App\Util\ApiResponse;
use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return ApiResponse::send(
                code: Response::HTTP_UNAUTHORIZED,
                message: 'Unauthorized'
            );
        }

        try {
            $secretKey = config('app.jwt_secret');

            $decoded = JWT::decode($token, new Key($secretKey, 'HS256'));

            $request->attributes->set('user', $decoded);

            app()->instance(AuthUser::class,
                new AuthUser(
                    id: $decoded->ID,
                    name: $decoded->Name,
                    email: $decoded->Email,
                    role: UserRole::from($decoded->Role)
                )
            );

            return $next($request);
        } catch (\Exception $e) {
            return ApiResponse::send(
                code: Response::HTTP_UNAUTHORIZED,
                message: $e->getMessage()
            );
        }
    }
}
