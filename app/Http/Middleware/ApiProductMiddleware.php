<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiProductMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->bearerToken()) {
            return $next($request);
        }
        $user = $request->user();

        if ($user) {
            $userProducts = $user->products()->pluck('id')->toArray();
            $request->merge(['user_products' => $userProducts]);
        }

        return $next($request);
    }
}
