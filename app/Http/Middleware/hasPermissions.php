<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class hasPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$permissions): Response
    {
        if ($request->user()->hasPermissions($permissions)) {
            return $next($request);
        }
        return response()->json(['error' => 'Unauthorized'], 403);

    }
}
