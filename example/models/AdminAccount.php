<?php

use Illuminate\Database\Eloquent\Model;
use FiveSay\Laravel\Api\Model\BaseTrait as ExtTrait;

/**
 * 账号
 */
class AdminAccount extends Model
{
    use ExtTrait;

    /**
     * 数据校验规则
     * @var array
     */
    public $rules = [
        'name' => [
            'required' => '请填写用户名',
        ],
        'email' => [
            'required'     => '请填写 email',
            'email'        => 'email 格式不正确',
            'unique:admins' => 'email 已被占用',
        ],
    ];

/*
|--------------------------------------------------------------------------
| 访问器
|--------------------------------------------------------------------------
*/
    /**
     * 状态
     * status
     * @return mixed
     */
    public function getStatusObjAttribute()
    {
        $statusArray = [
            1  =>  '启用',
            2  =>  '禁用',
        ];
        return ['key' => $this->status, 'name' => $statusArray[$this->status]];
    }

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
     * 职务
     * 多对多
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function duties()
    {
        return $this->belongsToMany('AdminDuty', 'admin_account_duty', 'duty_id', 'account_id');
    }

/*
|--------------------------------------------------------------------------
| 模型方法扩展
|--------------------------------------------------------------------------
*/

    /**
     * 检查密码
     * @param  string $password 待检查的明文密码
     * @return void
     */
    public function checkPassword($password)
    {
        $hashedPassword = $this->password;
        if (! Hash::check($password, $hashedPassword)) {
            throw new CheckPasswordFail;
        }

        // Hash::needsRehash('111111');
        // $2y$10$Wj/vhDNM0xl/SaX13cUUS.tdJf95Se/2h5SCnd9Q/AQRlw.l3R29y

        // if (Hash::needsRehash($hashed)) {
        //     $hashed = Hash::make('plain-text');
        // }
    }
    
}
