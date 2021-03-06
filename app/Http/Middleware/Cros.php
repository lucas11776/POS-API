<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cros
{
    /**
     * Allowed request methods for api request
     *
     * @var array
     */
    protected const METHODS = ['GET', 'POST', 'UPDATE', 'PATCH', 'PUT', 'DELETE', 'OPTIONS'];

    /**
     * Time taken for request to be cached (1 day)
     *
     * @var integer
     */
    protected const MAX_AGE = 86400;

    /**
     * Allow credentials headers
     *
     * @var bool
     */
    protected const CREDENTIALS = true;

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request)
            ->header('Access-Control-Allow-Origin', $_SERVER["HTTP_ORIGIN"] ?? '')
            ->header('Access-Control-Allow-Credentials', self::CREDENTIALS ? 'true' : 'false')
            ->header('Access-Control-Max-Age', self::MAX_AGE)
            ->header('Access-Control-Allow-Methods', implode(', ', self::METHODS))
            ->header('Access-Control-Allow-Headers', $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'] ?? '');
    }
}
