<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class User
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(! auth()->check()) {
            return response()
                ->json(['message' => 'Unauthorized Access.'], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
