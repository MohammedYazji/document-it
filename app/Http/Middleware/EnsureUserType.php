<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserType
{
    public function handle(Request $request, Closure $next, string ...$types): Response
    {
        if (! $request->user()) {
            abort(403);
        }

        if (! in_array($request->user()->type, $types)) {
            abort(403);
        }

        return $next($request);
    }
}
