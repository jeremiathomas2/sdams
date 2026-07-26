<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!$request->user()) {
            return redirect('/');
        }

        if (!empty($roles) && !in_array($request->user()->role, $roles)) {
            abort(403, 'Unauthorized. You do not have the required role to access this page.');
        }

        return $next($request);
    }
}
