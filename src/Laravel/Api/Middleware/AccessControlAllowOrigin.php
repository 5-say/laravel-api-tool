<?php

namespace FiveSay\Laravel\Api\Middleware;

use Closure;

class AccessControlAllowOrigin
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
        $clientOrigin = $request->header('host');
        $allowOrigin  = config('ext.allowClientOrigin');

        if (in_array($clientOrigin, $allowOrigin)) {
            $response = $next($request);
            $response->headers->add([
                'Access-Control-Allow-Origin' => $clientOrigin, // 允许跨域 api 调用
            ]);
        }

        return $response;
    }

}
