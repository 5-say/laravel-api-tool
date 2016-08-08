<?php

namespace FiveSay\Laravel\Api\Middleware;

use Closure;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class JwtBothMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function normalHandle($request, Closure $next)
    {
        try {
            $token      = JWTAuth::getToken();
            $payload    = JWTAuth::getPayload($token);

            $moduleName = $payload->get('moduleName');
            if ($moduleName != env('MODULE_NAME')) {
                throw new JWTException;
            }

            $id         = $payload->get('sub');
            $modelName  = $payload->get('modelName');

            $user       = $modelName::findOrFail($id);

            putenv('AUTH_USER_ID='.$id);
            putenv('AUTH_USER_MODEL='.$modelName);

            return $next($request);
        } catch (TokenExpiredException $e) {
        } catch (JWTException $e) {
        } catch (ModelNotFoundException $e) {
        }

        return $next($request);
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function apiDebugHandle($request, Closure $next)
    {
        $moduleName    = env('MODULE_NAME');
        $authUserId    = config('ext.api.'.$moduleName.'.auth_user_id');
        $authUserModel = config('ext.api.'.$moduleName.'.auth_user_model');

        putenv('AUTH_USER_ID='.$authUserId);
        putenv('AUTH_USER_MODEL='.$authUserModel);
        
        return $next($request);
    }

    /**
     * 魔术方法
     * @param  string $name      方法名称
     * @param  array  $arguments 参数数组
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        if ($name === 'handle') {
            if (config('ext.api.debug')) {
                return call_user_func_array([&$this, 'apiDebugHandle'], $arguments);
            }
            else {
                return call_user_func_array([&$this, 'normalHandle'], $arguments);
            }
        }
    }

}
