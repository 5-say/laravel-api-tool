<?php

namespace App\Http\Controllers\Admin\Auth;

use Ext\Controller\Module\Admin as Controller;

use FiveSay\Laravel\Api\Controller\AccountTrait;

/**
 * 账号
 */
class AccountController extends Controller
{
    use AccountTrait;

    /**
     * 资源模型名称
     */
    const ThisModel = 'AdminAccount';

}
