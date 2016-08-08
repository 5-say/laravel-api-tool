<?php

namespace FiveSay\Laravel\Api\Controller;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as LaravelController;
use Illuminate\Foundation\Validation\ValidatesRequests;

/**
 * 基础控制器
 */
class BaseController extends LaravelController
{
    use DispatchesJobs, ValidatesRequests;


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
