<?php

namespace FiveSay\Laravel\Middleware;

use FiveSay\Laravel\Api\Middleware\DataAuthMiddleware as BaseDataAuthMiddleware;
use FiveSay\Laravel\Api\Exception\DataAuthException;
use AdminAuthority;

class DataAuthMiddleware extends BaseDataAuthMiddleware
{
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

}
