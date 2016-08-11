<?php

namespace App\Http\Controllers\Admin\Auth\Duty;

use Ext\Controller\Pivot\Admin as PivotController;
use Duty as ParentModel;

/**
 * 多对多关联操作 => 职务&&权限
 */
class AuthorityController extends PivotController
{
    /**
     * 外键
     * @var string
     */
    protected $foreignKey = 'duty_id';
    protected $otherKey   = 'authority_id';
    
    /**
     * 获取关联对象
     * @param  integer $parentId 父对象id
     * @return object
     */
    protected function relationObject($parentId)
    {
        return ParentModel::find($parentId)->authorities();
    }


}
