<?php
/**
 * 核心函数库，最高优先级
 * 
 * 主要用于变更后续载入的系统函数库
 * 
 * 后续载入的系统函数库
 * Illuminate/Foundation/helpers.php
 * Illuminate/Support/helpers.php
 * 
 * 后续载入的自定义函数库
 * functions.php
 */

// http_build_query

use Illuminate\Support\Str;
use Illuminate\Support\Debug\Dumper;

if (! function_exists('d')) {
    /**
     * 调试函数（不中断）
     *
     * @param  mixed
     * @return void
     */
    function d()
    {
        $Dumper = new Dumper;

        // 回溯
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        $content   = $backtrace[0]['file'].':'.$backtrace[0]['line'];
        $Dumper->dump($content);

        // 目标参数输出
        array_map(function ($val) use ($Dumper) {
            $Dumper->dump($val);
        }, func_get_args());
    }
}

if (! function_exists('dd')) {
    /**
     * 调试函数（中断）
     *
     * @param  mixed
     * @return void
     */
    function dd()
    {
        $Dumper = new Dumper;

        // 回溯
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        $content   = $backtrace[0]['file'].':'.$backtrace[0]['line'];
        $Dumper->dump($content);

        // 目标参数输出
        array_map(function ($val) use ($Dumper) {
            $Dumper->dump($val);
        }, func_get_args());

        die;
    }
}

if (! function_exists('d_')) {
    /**
     * 调试函数（仅回溯信息，不中断）
     *
     * @param  mixed
     * @return void
     */
    function d_()
    {
        $Dumper = new Dumper;

        // 回溯
        $content = [];
        foreach (debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS) as $value) {
            if (isset($value['file'])) {
                $content[] = $value['file'].':'.$value['line'];
            }
            else {
                $content[] = $value;
            }
        }

        $Dumper->dump($content);
    }
}

if (! function_exists('dd_')) {
    /**
     * 调试函数（仅回溯信息，中断）
     *
     * @param  mixed
     * @return void
     */
    function dd_()
    {
        $Dumper = new Dumper;

        // 回溯
        $content = [];
        foreach (debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS) as $value) {
            if (isset($value['file'])) {
                $content[] = $value['file'].':'.$value['line'];
            }
            else {
                $content[] = $value;
            }
        }

        $Dumper->dump($content);

        die;
    }
}

if (! function_exists('logs')) {
    function logs()
    {
        $file = storage_path('logs/debug.log');
        $dir  = dirname($file);
        is_dir($dir) OR mkdir($dir, 0777, true);

        // 被调用记录
        $backtrace = debug_backtrace();
        $content   = '['.date('Y-m-d H:i:s').']'.PHP_EOL;
        $content  .= '断点位置 => '.$backtrace[0]['file'].':'.$backtrace[0]['line'].PHP_EOL;

        if (! empty($backtrace[0]['args'])) {
            $content .= '调试内容 => '.var_export($backtrace[0]['args'], true).PHP_EOL.PHP_EOL.PHP_EOL;
        }

        // 写入日志
        file_put_contents($file, $content, FILE_APPEND);
    }
}

if (! function_exists('response')) {
    /**
     * Return a new response from the application.
     *
     * @param  string  $content
     * @param  int     $status
     * @param  array   $headers
     * @return \Symfony\Component\HttpFoundation\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    function response($content = '', $status = 200, array $headers = [])
    {
        $factory = app(Ext\Core\Response::class);

        if (func_num_args() === 0) {
            return $factory;
        }

        return $factory->make($content, $status, $headers);
    }
}
