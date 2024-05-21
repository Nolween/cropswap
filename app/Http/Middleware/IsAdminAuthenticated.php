<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdminAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (!auth()->check() || !auth()->user()->isAdmin()) {
        //    403 Forbidden
            return response()->json([
                'message' => 'Forbidden',
                'success' => false,
            ], 403);
        }
        return $next($request);
    }
}
