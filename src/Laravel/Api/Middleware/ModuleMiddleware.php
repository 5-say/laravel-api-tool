<?php

namespace FiveSay\Laravel\Api\Middleware;

use Closure;

class ModuleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure                  $next
     * @param  string                    $moduleName 模块名称
     * @return mixed
     */
    public function handle($request, Closure $next, $moduleName)
    {
        putenv('MODULE_NAME='.$moduleName);
        return $next($request);
    }

}
