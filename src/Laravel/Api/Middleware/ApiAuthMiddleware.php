<?php

namespace FiveSay\Laravel\Api\Middleware;

use Closure;
use FiveSay\Laravel\Api\Exception\DataAuthException;
use Route;

class ApiAuthMiddleware
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
        try {
            // 校验当前用户是否具有路由访问权限
            $methodName = env('MODULE_NAME').'ModuleHasDataAuth';
            if (method_exists($this, $methodName)) {
                $this->$methodName(Route::currentRouteName());
            }

            return $next($request);
        } catch (DataAuthException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getStatusCode());
        }
    }

    /**
     * 获取当前登录用户的模型实例
     * @return Model|null
     */
    protected function getAuthUser()
    {
        $authUserId    = $this->authUserId;
        $authUserModel = $this->authUserModel;

        if ($authUserId && $authUserModel) {
            return $authUserModel::find($authUserId);
        }
    }

    /**
     * 魔术方法
     * @param  string $name 属性名称
     * @return mixed
     */
    public function __get($name)
    {
        switch ($name) {
            case 'authUser':
                return $this->getAuthUser();

            case 'authUserId':
                return env('AUTH_USER_ID');

            case 'authUserModel':
                return env('AUTH_USER_MODEL');
        }
    }

}
