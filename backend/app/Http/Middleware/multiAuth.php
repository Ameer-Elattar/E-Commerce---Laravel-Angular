<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class MultiAuth extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        $authenticated = false;
        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                $authenticated = true;
                break;
            }
        }

        if (!$authenticated) {
            return $this->unauthenticated($request, $guards);
        }

        return $next($request);
    }
}
