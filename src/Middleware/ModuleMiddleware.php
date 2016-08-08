<?php

namespace FiveSay\Laravel\Api\Middleware;

use Closure;

class ModuleMiddleware
{
    /**
     * 模块名称
     * @var string
     */
    protected $moduleName;

    /**
     * 初始化
     * @param string $moduleName 模块名称（英文小写，例如：home）
     */
    public function __construct($moduleName)
    {
        $this->moduleName = $moduleName;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  int  $maxAttempts
     * @param  int  $decayMinutes
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        putenv('MODULE_NAME='.$this->moduleName);
        return $next($request);
    }

}
