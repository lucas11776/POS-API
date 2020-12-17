<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class Administrator
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
        if(! auth()->user()->roles()->where(['name' => 'administrator'])->exists()) {
            return response()
                ->json(['message' => 'Unauthorized Access'], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
