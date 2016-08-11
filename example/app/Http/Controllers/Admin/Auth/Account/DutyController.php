<?php

namespace App\Http\Controllers\Admin\Auth\Account;

use Ext\Controller\Pivot\Admin as PivotController;
use Account as ParentModel;

/**
 * 多对多关联操作 => 职务&&权限
 */
class DutyController extends PivotController
{
    /**
     * 外键
     * @var string
     */
    protected $foreignKey = 'account_id';
    protected $otherKey   = 'duty_id';
    
    /**
     * 获取关联对象
     * @param  integer $parentId 父对象id
     * @return object
     */
    protected function relationObject($parentId)
    {
        return ParentModel::find($parentId)->duties();
    }


}
