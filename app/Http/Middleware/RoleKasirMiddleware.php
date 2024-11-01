<?php

namespace App\Http\Middleware;

use App\Traits\JsonResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleKasirMiddleware
{
    use JsonResponse;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            if (auth()->user()->status !== 'active') {
                return $this->errorResponse('Akun tidak aktif', 401);
            }
            if (auth()->user()->as !== 'kasir') {
                return $this->errorResponse('Anda tidak punya akses', 403);
            }
        }
        return $next($request);
    }
}
