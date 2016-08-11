<?php

namespace App\Http\Controllers\Admin\Auth;

use Ext\Controller\Module\Admin as Controller;

use FiveSay\Laravel\Api\Controller\AuthTrait;

/**
 * 认证
 */
class AuthenticateController extends Controller
{
    use AuthTrait;

    /**
     * 账户模型名称
     */
    const AccountModel = 'AccountModelName';

}
