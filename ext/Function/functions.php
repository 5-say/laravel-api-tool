<?php
/**
 * 自定义函数库，需检测函数名是否被占用
 * 
 * 在此之前载入的核心函数库
 * bootstrap/changeCoreHelpers.php
 * 
 * 在此之前载入的系统函数库
 * Illuminate/Foundation/helpers.php
 * Illuminate/Support/helpers.php
 * 
 */

if (! function_exists('demo')) {
    /**
     * 示例函数
     *
     * @param  mixed
     * @return void
     */
    function demo()
    {
        dd('this is demo functions');
    }
}

