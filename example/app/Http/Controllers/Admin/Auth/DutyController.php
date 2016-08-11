<?php

namespace App\Http\Controllers\Admin\Auth;

use Ext\Controller\Module\Admin as Controller;

use FiveSay\Laravel\Api\Controller\DutyTrait;

/**
 * 职务
 */
class DutyController extends Controller
{
    use DutyTrait;

    /**
     * 资源模型名称
     */
    const ThisModel = 'AdminDuty';

    /**
     * 账号模型名称
     */
    const AccountModel = 'AdminAccount';
    

}
