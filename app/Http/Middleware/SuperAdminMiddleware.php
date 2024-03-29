<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->user()->superadmin == 1 && $request->user()->is_admin==1){
            return $next($request);
        }
        return response()->json([
            'error' => 'Unauthorized. Superadmin access required.'
        ], 403);
    }
}
