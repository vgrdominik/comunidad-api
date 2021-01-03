<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Validation\UnauthorizedException;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (! $request->user()->hasRole($role)) {
            throw new UnauthorizedException();
        }

        return $next($request);
    }
}
