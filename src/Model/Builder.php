<?php

namespace FiveSay\Laravel\Api\Model;

use Illuminate\Database\Eloquent\Builder as BaseBuilder;

/**
 * 配合 BaseTrait 进行深度定制
 */
class Builder extends BaseBuilder
{

    // 请在模型中补充定义
    // /**
    //  * 关联索引
    //  * @var array
    //  * 关联名称 => 关联外键
    //  */
    // public $withMap = [
    //     'child'    => 'id',
    //     'children' => 'id',
    //     'parent'   => 'parent_id',
    //     'parents'  => 'id',
    // ];
    
    /**
     * 是否需要解析 URL 'columns' 参数
     * @var boolean
     */
    public $needParseUrlColumns = false;
    
    /**
     * 是否需要全字段输出
     * @var boolean
     */
    public $needAllColumns = false;
    
    /**
     * url 中请求的常规虚拟字段
     * @var array
     */
    public $normalAppends = [];

    /**
     * 解析 URL 'columns' 参数
     * @param  boolean $needAllColumns 是否需要全字段输出
     * @return $this
     */
    public function parseUrlColumns($needAllColumns = false)
    {
        $this->needParseUrlColumns = true;
        $this->needAllColumns      = $needAllColumns;
        return $this;
    }

    /**
     * Execute the query and get the first result.
     *
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Model|static|null
     */
    public function first($columns = ['*'])
    {
        if ($this->needParseUrlColumns) {
            $withMap = $this->getModel()->withMap ?: [];
            if ($this->needAllColumns) {
                $with = array_keys($withMap);
                $columns = ['*'];
            }
            else {
                list($with, $columns) = $this->generatorWithAndColumns($withMap);
            }
            $this->with($with);
        }
        return parent::first($columns);
    }

    /**
     * Execute the query as a "select" statement.
     *
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function get($columns = ['*'])
    {
        if ($this->needParseUrlColumns) {
            $withMap = $this->getModel()->withMap ?: [];
            if ($this->needAllColumns) {
                $with = array_keys($withMap);
                $columns = ['*'];
            }
            else {
                list($with, $columns) = $this->generatorWithAndColumns($withMap);
            }
            $this->with($with);
        }
        return parent::get($columns);
    }

    /**
     * 根据请求参数，构造 关联查询列表 以及 字段列表
     * @param  array  $withMap     关联索引
     * @param  string $columnsName 用户请求中的字段列表键名
     * @return array
     *
     * 调用方式：
     * list($with, $columns) = $this->generatorWithAndColumns($withMap);
     */
    public function generatorWithAndColumns($withMap = [], $columnsName = 'columns')
    {
        // 获取用户参数
        $columns = request($columnsName, []);
        is_array($columns) OR $columns = [];

        // 构造
        $with = $otherColumns = [];
        foreach ($columns as $column) {
            if (array_key_exists($column, $withMap)) {
                $with[]         = $column;
                $otherColumns[] = $withMap[$column];
            }
            else {
                $otherColumns[] = $column;
            }
        }

        // 特殊字符过滤
        $otherColumns = array_filter($otherColumns, function ($var) {
            $var = trim($var);
            return (!empty($var) && $var !== '*');
        });

        // 虚拟字段过滤
        $otherColumns = array_diff($otherColumns, $this->getModel()->getAppends());

        // 存储 url 中请求的常规虚拟字段
        $this->normalAppends = array_intersect($columns, $this->getModel()->getAppends());

        // 至少保持请求有一个 id 字段
        ! empty($otherColumns) OR $otherColumns = ['id'];

        return [$with, $otherColumns];
    }

}