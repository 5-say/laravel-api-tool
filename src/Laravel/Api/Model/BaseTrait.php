<?php

namespace FiveSay\Laravel\Api\Model;

use Illuminate\Support\Str;
use FiveSay\Laravel\Model\ExtTrait;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Jenssegers\Agent\Agent;

/**
 * 特性：模型拓展
 */
trait BaseTrait
{
    use ExtTrait;

    /**
     * 存储 Builder 实例
     * @var Ext\Model\Builder
     */
    protected static $_builder;
    
    /**
     * boot this trait
     *
     * @return void
     */
    public static function bootBaseTrait()
    {
        // 强制解除批量赋值限制
        static::unguard();
    }

    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function newEloquentBuilder($query)
    {
        $this::$_builder = new Builder($query);
        return $this::$_builder;
    }

    /**
     * Convert the model instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        // 提取常规的虚拟字段
        $normalAppends = array_filter($this->appends, function ($var) {
            return ! preg_match('/_obj$/', $var);
        });
        if ($this::$_builder->needParseUrlColumns === true && $this::$_builder->needAllColumns === false) {
            $normalAppends = $this::$_builder->normalAppends;
        }

        // 支持拓展原字段为复杂对象，虚拟字段名为原字段名加 _obj 后缀
        $objAppends = [];
        foreach ($this->attributes as $column => $value) {
            if (in_array($column.'_obj', $this->appends)) {
                $objAppends[] = $column.'_obj';
            }
        }

        // 确保常规的虚拟字段仍然可以正常使用
        $this->appends = array_merge($normalAppends, $objAppends);

        // 保持原始方法调用
        $result = parent::toArray();
        
        // 强制字段类型
        foreach ($this->casts as $key => $value) {
            if (is_null($value)) {
                switch ($this->getCastType($key)) {
                    case 'object':
                        $result[$key] = (object) null;
                        break;
                    case 'array':
                        $result[$key] = [];
                        break;
                }
            }
        }
        return $result;
    }

    /**
     * Create the response for when a request fails validation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $errors
     * @return \Illuminate\Http\Response
     */
    protected function buildFailedValidationResponse(Request $request, array $errors)
    {
        // 安卓
        $agent = new Agent;
        // 自定义请求头 Need_Special_Error_Message: true
        if ($agent->getHttpHeader('need-special-error-message')) {
            $errorStr = '';
            foreach ($errors as $error) {
                $errorStr .= implode(PHP_EOL, $error).PHP_EOL;
            }
            return new JsonResponse(['error' => $errorStr], 422);
        }
        
        // 异步
        if (($request->ajax() && ! $request->pjax()) || $request->wantsJson()) {
            return new JsonResponse($errors, 422);
        }

        // 常规页面
        return redirect()
            ->to($this->getRedirectUrl())
            ->withInput($request->input())
            ->withErrors($errors, $this->errorBag());
    }

    /**
     * 获取虚拟字段定义
     * @return array
     */
    public function getAppends()
    {
        return $this->appends;
    }

    /**
     * Get the attributes that have been changed since last sync.
     *
     * @return array
     */
    public function getDirty()
    {
        $dirty = parent::getDirty();

        // 排除虚拟字段
        $dirty = array_diff_key($dirty, array_flip($this->appends));

        return $dirty;
    }

}
