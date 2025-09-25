<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        $user = Auth::user();

        if (!$user || $user->role !== $role) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized: role tidak sesuai'
            ], 403);
        }

        return $next($request);
    }
}
