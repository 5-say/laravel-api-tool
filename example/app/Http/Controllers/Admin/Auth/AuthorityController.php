<?php

namespace App\Http\Controllers\Admin\Auth;

use Ext\Controller\Module\Admin as Controller;

use FiveSay\Laravel\Api\Controller\AuthorityTrait;

/**
 * 权限
 */
class AuthorityController extends Controller
{
    use AuthorityTrait;

    /**
     * 资源模型名称
     */
    const ThisModel = 'Authority';

    /**
     * 职务模型名称
     */
    const DutyModel = 'DutyModelName';
    

}
