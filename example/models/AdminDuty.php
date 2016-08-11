<?php

use Illuminate\Database\Eloquent\Model;
use FiveSay\Laravel\Api\Model\BaseTrait as ExtTrait;

/**
 * 职务
 */
class AdminDuty extends Model
{
    use ExtTrait;

/*
|--------------------------------------------------------------------------
| 访问器
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| 调整器
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| 模型对象关系
|--------------------------------------------------------------------------
*/
    /**
     * 权限
     * 多对多
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function authorities()
    {
        return $this->belongsToMany('AdminAuthority', 'admin_authority_duty', 'authority_id', 'duty_id');
    }

    /**
     * 帐号
     * 多对多
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function accounts()
    {
        return $this->belongsToMany('AdminAccount', 'admin_account_duty', 'account_id', 'duty_id');
    }

/*
|--------------------------------------------------------------------------
| 模型方法扩展
|--------------------------------------------------------------------------
*/

}
