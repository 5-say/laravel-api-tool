<?php

use Illuminate\Database\Eloquent\Model;
use FiveSay\Laravel\Api\Model\BaseTrait as ExtTrait;
use FiveSay\Laravel\Api\Exception\CheckPasswordFail;

/**
 * 账号
 */
class AdminAccount extends Model
{
    use ExtTrait;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    /**
     * 数据校验规则
     * @var array
     */
    public $rules = [
        'name' => [
            'required' => '请填写用户名',
        ],
        'password' => [
            'between:6,30' => '密码长度请保持在 :min 到 :max 之间',
        ],
        'email' => [
            'required'      => '请填写 email',
            'email'         => 'email 格式不正确',
            'unique:admins' => 'email 已被占用',
        ],
    ];

    /**
     * The accessors to append to the model's array form.
     * 虚拟字段
     * @var array
     */
    protected $appends = [
        'duties_name_str',
        'duties_id',
    ];

/*
|--------------------------------------------------------------------------
| 访问器
|--------------------------------------------------------------------------
*/
    /**
     * 职务
     * 虚拟字段，拼接字符串
     * duties_name_str
     * @return mixed
     */
    public function getDutiesNameStrAttribute()
    {
        $dutiesNameArr = $this->duties()->lists('name')->toArray();
        return implode(',', $dutiesNameArr);
    }

    /**
     * 职务
     * 虚拟字段，ID数组
     * duties_id
     * @return mixed
     */
    public function getDutiesIdAttribute()
    {
        return $this->duties()->lists('id')->toArray();
    }
    
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
    /**
     * 职务
     * 虚拟字段，关联存储
     * @param  mixed $value 原始数据
     * @return mixed
     */
    public function setDutiesIdAttribute($value)
    {
        $dutiesId = is_array($value) ? $value: [$value];
        $this->duties()->sync($dutiesId);
    }

    /**
     * 密码
     * @param  mixed $value 原始数据
     * @return mixed
     */
    public function setPasswordAttribute($value)
    {
        $result = self::encryption($value);
        $this->attributes['password'] = $result;
    }

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
     * 密码加密
     * @param  string $password 明文密码
     * @return string 加密后的密码
     */
    public static function encryption($password)
    {
        return Hash::make($password);
    }

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

    /**
     * 修改密码
     * @param  string $password 新的密码
     */
    public function changePassword($password)
    {
        $this->fill(['password' => $password])->save();
        return $this;
    }
    
}
