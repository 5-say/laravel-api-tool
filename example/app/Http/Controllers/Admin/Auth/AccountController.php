<?php

namespace App\Http\Controllers\Admin\Auth;

use Ext\Controller\Module\Admin as Controller;

use FiveSay\Laravel\Api\Controller\AccountTrait;
use FiveSay\Laravel\Api\Controller\UploadFileTrait;

/**
 * 账号
 */
class AccountController extends Controller
{
    use AccountTrait;
    use UploadFileTrait;

    /**
     * 资源模型名称
     */
    const ThisModel = 'AdminAccount';


    public function aaa()
    {
        return $this->saveUploadFile();
    }



}
