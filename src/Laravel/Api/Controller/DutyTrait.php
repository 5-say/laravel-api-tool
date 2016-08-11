<?php

namespace FiveSay\Laravel\Api\Controller;

/**
 * 特性：资源控制器：职务
 */
trait DutyTrait
{
    use ResourceTrait;

    // 请在控制器中补充定义
    // /**
    //  * 资源模型名称
    //  */
    // const ThisModel = 'DutyModelName';

    // 请在控制器中补充定义
    // /**
    //  * 账号模型名称
    //  */
    // const AccountModel = 'AccountModelName';
    
    /**
     * 获取当前资源模型实例
     */
    static function AccountModel()
    {
        $Model = self::AccountModel;
        return new $Model;
    }

    /**
     * 获取指定账户拥有的职务列表
     */
    public function indexByAccountId($accountId)
    {
        $dutiesIdArr = self::AccountModel()->findOrFail($accountId)->duties()->lists('id')->toArray();

        $model = self::ThisModel()->parseUrlColumns();
        $model->whereIn('id', $dutiesIdArr);

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
