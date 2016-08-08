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
        $file = '../storage/logs/debug.log';
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

if (! function_exists('env')) {
    /**
     * Gets the value of an environment variable. Supports boolean, empty and null.
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    function env($key, $default = null)
    {
        $value = getenv($key);

        // 修正密集异步请求下 env 配置丢失的问题。
        // http://stackoverflow.com/questions/31295126/laravel-5-losing-sessions-and-env-configuration-values-in-ajax-intensive-applic

        // getenv() might not work as expected, especially on Windows machines, see
        // https://github.com/laravel/framework/pull/8187
        // and
        // https://github.com/vlucas/phpdotenv/issues/76

        // getenv returns strict false on failure
        if ($value === false) {
            // try extracting from $_ENV or $_SERVER and give up finally
            $value = array_key_exists($key, $_ENV) ? $_ENV[$key] :
                (array_key_exists($key, $_SERVER) ? $_SERVER[$key] : false);
        }
        // 以上解决方案，在极端情况下仍有可能出错
        // 建议采用 php artisan config:cache 生成配置缓存，以减少 env 调用。
        // 缓存位置：/bootstrap/cache/config.php


        if ($value === false) {
            return value($default);
        }

        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;

            case 'false':
            case '(false)':
                return false;

            case 'empty':
            case '(empty)':
                return '';

            case 'null':
            case '(null)':
                return;
        }

        if (strlen($value) > 1 && Str::startsWith($value, '"') && Str::endsWith($value, '"')) {
            return substr($value, 1, -1);
        }

        return $value;
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
