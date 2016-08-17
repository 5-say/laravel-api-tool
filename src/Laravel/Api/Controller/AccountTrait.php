<?php

namespace FiveSay\Laravel\Api\Controller;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use FiveSay\Laravel\Api\Exception\CheckPasswordFail;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * 特性：认证控制器
 */
trait AccountTrait
{
    use ResourceTrait;

    // 请在控制器中补充定义
    // /**
    //  * 资源模型名称
    //  */
    // const ThisModel = 'AccountModelName';

    /**
     * 获取表单认证信息
     * @return mixed
     */
    protected function getCredentials()
    {
        $account = request('account');
        return ['account' => $account];
    }

    /**
     * 获取表单密码
     * @return mixed
     */
    protected function getFormPassword()
    {
        return request('password');
    }

    /**
     * 认证
     */
    public function login()
    {
        try {
            // 从请求中获取凭证数据
            $credentials = $this->getCredentials();
            $password    = $this->getFormPassword();
            
            // 查找用户
            $authUser = self::ThisModel()->where($credentials)->firstOrFail();

            // 验证密码
            $authUser->checkPassword($password);

            // 验证通过则生成 token
            $token        = JWTAuth::fromUser($authUser, $customClaims);
            $customClaims = [
                'modelName'  => get_class($authUser),
                'moduleName' => env('MODULE_NAME'),
            ];

            return response()->json(compact('token'));
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => '验证信息有误'], 422);
        } catch (CheckPasswordFail $e) {
            return response()->json(['error' => '验证信息有误'], 422);
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
    }

    /**
     * 获取当前登录用户的信息
     */
    public function myself()
    {
        return $this->authUser;
    }


}
