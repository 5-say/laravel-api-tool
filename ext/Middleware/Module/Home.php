<?php

namespace FiveSay\Laravel\Middleware\Module;

use Closure;

class Home
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  int  $maxAttempts
     * @param  int  $decayMinutes
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        putenv('MODULE_NAME=home');
        return $next($request);
    }

}
