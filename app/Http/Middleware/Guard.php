<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Guard
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if(in_array($guard, $this->guards())) {
            Auth::shouldUse($guard);
        }

        return $next($request);
    }

    /**
     * Application authentication guards.
     *
     * @return array
     */
    protected function guards(): array
    {
        return array_keys(config('auth.guards'));
    }
}
