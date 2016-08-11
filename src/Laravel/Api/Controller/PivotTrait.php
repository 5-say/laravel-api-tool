<?php

namespace FiveSay\Laravel\Api\Controller;

use Carbon\Carbon;

/**
 * 特性：多对多关联关系控制器
 */
trait PivotTrait
{
    // 请在控制器中补充定义
    // /**
    //  * 外键
    //  * @var string
    //  */
    // protected $foreignKey = '';
    // protected $otherKey   = '';

    /**
     * 获取关联对象
     * @param  integer $parentId 父对象id
     * @return object
     */
    protected function relationObject($parentId)
    {
        die('请复写 relationObject 方法');
        // return ParentModel::find($parentId)->relationMethod();
    }

    /**
     * 更新单个“多对多关系”前，进行数据处理
     * 注意：当存在返回值时，此返回值将被作为响应直接返回给客户端
     * 
     * @param  integer $parentId   父对象id
     * @param  integer $id         子对象id
     * @param  array   $attributes 待处理的用户数据
     * @return void|mixed
     */
    protected function updating($parentId, $id, & $attributes)
    {}

    /**
     * 同步多个“多对多关系”前，进行数据处理
     * 注意：当存在返回值时，此返回值将被作为响应直接返回给客户端
     * 
     * @param  integer $parentId 父对象id
     * @param  array   $ids      待处理的用户数据（子对象id 数组）
     * @return void|mixed
     */
    protected function syncing($parentId, & $ids)
    {}

    /**
     * 增加单个“多对多关系”前，进行数据处理
     * 注意：当存在返回值时，此返回值将被作为响应直接返回给客户端
     * 
     * @param  integer $parentId   父对象id
     * @param  integer $id         子对象id
     * @param  array   $attributes 待处理的用户数据
     * @return void|mixed
     */
    protected function attaching($parentId, $id, & $attributes)
    {}

    /**
     * 移除“多对多关系”前，进行其它操作
     * 注意：当存在返回值时，此返回值将被作为响应直接返回给客户端
     * 
     * @param  integer $parentId 父对象id
     * @return void|mixed
     */
    protected function detaching($parentId)
    {}

    /**
     * 更新单个“多对多关系”，允许存储额外的参数
     * 
     * 更新单个 PUT parent/{parentId}/self/{id}?other=value&other2=value2
     * 
     * @param  integer $parentId 父对象id
     * @param  integer $id       子对象id
     */
    public function update($parentId, $id)
    {
        $attributes = request()->except($this->foreignKey, $this->otherKey, 'created_at', 'updated_at');

        $result = $this->updating($parentId, $id, $attributes);
        
        // 注意：当存在返回值时，此返回值将被作为响应直接返回给客户端
        if ($result) {
            return $result;
        }

        return $this->relationObject($parentId)
            ->newPivotStatementForId($id)
            ->update($attributes);
    }

    /**
     * 同步多个“多对多关系”，不处理额外的参数
     * 
     * 同步多个 POST parent/{parentId}/self/sync?ids[]=1&ids[]=2&ids[]=3
     * 
     * @param  integer $parentId 父对象id
     */
    public function sync($parentId)
    {
        $ids = request('ids');
        if (! is_array($ids)) {
            return response()->json(['error' => '参数错误'], 400);
        }
        else {
            $result = $this->syncing($parentId, $ids);

            // 注意：当存在返回值时，此返回值将被作为响应直接返回给客户端
            if ($result) {
                return $result;
            }
            return $this->relationObject($parentId)->sync($ids);
        }
    }

    /**
     * 增加单个“多对多关系”，允许存储额外的参数
     * 
     * 增加单个 POST parent/{parentId}/self/attach?id=1&other=value
     * 
     * @param  integer $parentId 父对象id
     */
    public function attach($parentId)
    {
        $id = request('id');
        if (is_null($id) || is_array($id)) {
            return response()->json(['error' => '参数错误'], 400);
        }
        else {
            $attributes = request()->except('id', $this->foreignKey, $this->otherKey, 'created_at', 'updated_at');
            $result = $this->attaching($parentId, $id, $attributes);

            // 注意：当存在返回值时，此返回值将被作为响应直接返回给客户端
            if ($result) {
                return $result;
            }
            return $this->relationObject($parentId)->attach($id, $attributes);
        }
    }

    /**
     * 移除“多对多关系”，不处理额外的参数
     * 
     * 移除单个 DELETE parent/{parentId}/self/detach?id=1
     * 移除多个 DELETE parent/{parentId}/self/detach?ids[]=1&ids[]=2&ids[]=3
     * 移除全部 DELETE parent/{parentId}/self/detach?ids=all
     * 
     * @param  integer $parentId 父对象id
     */
    public function detach($parentId)
    {
        $result = $this->detaching($parentId);

        // 注意：当存在返回值时，此返回值将被作为响应直接返回给客户端
        if ($result) {
            return $result;
        }

        $id = request('id');
        if (! is_array($id)) {
            return $this->relationObject($parentId)->detach($id);
        }
        else {
            $ids = request('ids');
            if ($ids === 'all') {
                return $this->relationObject($parentId)->detach();
            }
            else if (is_array($ids)) {
                return $this->relationObject($parentId)->detach($ids);
            }
            else {
                return response()->json(['error' => '参数错误'], 400);
            }
        }
    }

}
