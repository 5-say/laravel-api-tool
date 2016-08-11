<?php

namespace FiveSay\Laravel\Api\Controller;

/**
 * 特性：资源控制器
 */
trait ResourceTrait
{
    // 请在控制器中补充定义
    // /**
    //  * 资源模型名称
    //  */
    // const ThisModel = 'ThisResourceModelName';
    
    /**
     * 获取当前资源模型实例
     */
    static function ThisModel()
    {
        $Model = self::ThisModel;
        return new $Model;
    }

    /**
     * 索引
     */
    public function index()
    {
        $model = self::ThisModel()->parseUrlColumns();

        // 索引过程补充
        $result = $this->indexing($model);
        if ($result) return $result;

        // 排序
        if (request('order_column') && request('order_sort')) {
            $model->orderBy(request('order_column'), request('order_sort'));
        }

        // 复杂排序
        if (is_array(request('order_by'))) {
            foreach (request('order_by') as $item) {
                $model->orderBy($item['column'], $item['direction']);
            }
        }

        // 强制分页
        return $model->paginate(request('per_page'));
    }

    /**
     * 索引过程补充
     * 注意：当存在返回值时，此返回值将被作为响应直接返回给客户端
     * 
     * @param  object $model 当前资源模型实例
     * @return void|mixed
     */
    protected function indexing(& $model)
    {
        // // 筛选
        // request('check_status')
        //     && $model->where('check_status', request('check_status'));
    }
    
    /**
     * 存储
     */
    public function store()
    {
        $data = request()->all();

        // 存储过程补充
        $result = $this->storing($data);
        if ($result) return $result;
        
        return self::ThisModel()->forceCreate($data);
    }

    /**
     * 存储过程补充
     * 注意：当存在返回值时，此返回值将被作为响应直接返回给客户端
     * 
     * @param  array $data 需要存储的数据
     * @return void|mixed
     */
    protected function storing(& $data)
    {}

    /**
     * 查询
     * @param  integer $id 主键
     */
    public function show($id)
    {
        return self::ThisModel()->parseUrlColumns()->findOrFail($id);    
    }

    /**
     * 更新
     * @param  integer $id 主键
     */
    public function update($id)
    {
        $data  = request()->except('id');
        $model = self::ThisModel()->find($id);
        // if(!request('last_logged_at')){
        //     $data['last_logged_at'] = date('y-m-d h:i:s',time());
        // }
        $model->fill($data)->save();

        return $model;
    }

    /**
     * 删除
     * @param  integer $id 主键
     */
    public function destroy($id)
    {
        return self::ThisModel()->where('id', $id)->firstOrFail()->delete() ? 1: 0; 
    }

}
