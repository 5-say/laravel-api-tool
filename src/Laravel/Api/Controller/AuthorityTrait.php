<?php

namespace FiveSay\Laravel\Api\Controller;

/**
 * 特性：资源控制器：权限
 */
trait AuthorityTrait
{
    use ResourceTrait;

    // 请在控制器中补充定义
    // /**
    //  * 资源模型名称
    //  */
    // const ThisModel = 'AuthorityModelName';

    // 请在控制器中补充定义
    // /**
    //  * 职务模型名称
    //  */
    // const DutyModel = 'DutyModelName';
    
    /**
     * 获取职务模型实例
     */
    static function DutyModel()
    {
        $Model = self::DutyModel;
        return new $Model;
    }

    /**
     * 获取当前账户拥有的权限列表
     */
    public function indexForMyself()
    {
        $authoritiesIdArr = [0];
        foreach ($this->authUser->duties as $duty) {
            $authoritiesIdArr = array_merge($authoritiesIdArr, $duty->authorities()->lists('id')->toArray());
        }

        $model = self::ThisModel()->parseUrlColumns();

        // 限制
        $model->whereIn('id', $authoritiesIdArr);

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
     * 获取指定角色拥有的权限列表
     */
    public function indexByDutyId($dutyId)
    {
        $authoritiesIdArr = self::DutyModel()->findOrFail($dutyId)->authorities()->lists('id')->toArray();

        $model = self::ThisModel()->parseUrlColumns();

        $model->whereIn('id', $authoritiesIdArr);

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

}
