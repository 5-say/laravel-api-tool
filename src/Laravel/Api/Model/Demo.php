<?php

use Illuminate\Database\Eloquent\Model;
use FiveSay\Laravel\Api\Model\BaseTrait as ExtTrait;

class Demo extends Model
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
            'unique:users' => 'email 已被占用',
        ],
    ];

    /**
     * The accessors to append to the model's array form.
     * 虚拟字段
     * @var array
     */
    protected $appends = [];
    
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
    /**
     * 开始时间(start_ad)
     * @param  mixed $value 原始数据
     * @return mixed
     */
    public function setStartAtAttribute($value)
    {
        if (strlen($value) > 7) {
            $arr = explode('-', $value);
            $value = $arr[0].'-'.$arr[1];
        }
        $this->attributes['start_at'] = Carbon::createFromFormat('Y-m', $value);
    }

/*
|--------------------------------------------------------------------------
| 模型对象关系
|--------------------------------------------------------------------------
*/
    /**
     * 一对一
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function phone()
    {
        return $this->hasOne('App\Phone', 'foreign_key', 'local_key');
    }

    /**
     * 一对多
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Comment', 'foreign_key', 'local_key');
    }

    /**
     * 从属于
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'foreign_key');
    }

    /**
     * 多对多
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

/*
|--------------------------------------------------------------------------
| 模型方法扩展
|--------------------------------------------------------------------------
*/
    
}
