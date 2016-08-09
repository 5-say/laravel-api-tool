<?php


// 开放访问
Route::group([], function () {});


// 登录可用
Route::group(['middleware' => ['jwt.auth', 'api.auth']], function () {});


// 针对是否登陆进行不同处理
Route::group(['middleware' => 'jwt.both'], function () {});

