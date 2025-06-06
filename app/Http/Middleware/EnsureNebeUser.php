<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureNebeUser
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user() || !$request->user()->isNebe()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
}