<?php

namespace FiveSay\Laravel\Middleware;

use Closure;

use Ext\Exception\DataAuthException;
use Route;

use AdminAuthority;

class DataAuthMiddleware
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
     * admin模块 校验当前用户是否具有路由访问权限
     * @param  string $currentRouteName 当前路由名称
     * @throws Ext\Exception\DataAuthException
     */
    protected function adminModuleHasDataAuth($currentRouteName)
    {
        if (is_null($currentRouteName)) {
            return;
        }
        // logs($currentRouteName);

        // 查询此路由是否需要授权（同一个路由只能赋予一个权限节点）
        $auth = AdminAuthority::where('route_name', 'like', '%|'.$currentRouteName.'|%')->first();
        if ($auth) {
            // 获取访问此路由需要授权的角色
            $needDutiesIdArr = $auth->duties()->lists('id')->toArray();
        
            // 获取当前用户已授权的角色
            $hasDutiesIdArr = $this->authUser->duties()->lists('id')->toArray();

            // 判断当前用户是否属于已授权角色
            if (empty(array_intersect($needDutiesIdArr, $hasDutiesIdArr))) {
                throw new DataAuthException;
            }
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
