<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPermission
{
    public function handle(Request $request, Closure $next, ...$permissions)
    {
        if (!$request->user()) {
            return redirect('/');
        }

        if (!empty($permissions) && !$request->user()->hasAnyPermission($permissions)) {
            abort(403, 'Unauthorized. You do not have the required permission to access this page.');
        }

        return $next($request);
    }
}
