<?php


// 开放访问
Route::group([], function () {});


// 登录可用
Route::group(['middleware' => ['jwt.auth', 'api.auth']], function () {});


// 针对是否登陆进行不同处理
Route::group(['middleware' => 'jwt.both'], function () {});



/**
 * 权限相关
 */
Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {

    // 登录
    Route::post('login', 'AccountController@login');


    Route::group(['middleware' => ['jwt.auth', 'api.auth']], function () {

        // 账号
        Route::resource( 'account'                       , 'AccountController'                  );
        // 获取当前登录的用户信息
        Route::get(      'account/myself'                , 'AccountController@myself'           );
        // 修改指定用户密码
        Route::put(      'account/{account_id}/password' , 'AccountController@changePassword'   );


        // 职务
        Route::resource( 'duty'                          , 'DutyController'                     );
        // 获取指定账户拥有的职务列表
        Route::get(      'account/{account_id}/duty'     , 'DutyController@indexByAccountId'    );


        // 获取当前账户拥有的权限列表
        Route::get(      'authority/myself'              , 'AuthorityController@indexForMyself' );
        // 获取指定职务拥有的权限列表
        Route::get(      'duty/{duty_id}/authority'      , 'AuthorityController@indexByDutyId'  );


        // 多对多关联操作 => 职务 && 权限
        Route::group(['prefix' => 'duty/{parentId}/authority', 'namespace' => 'Duty'], function () {
            Route::put(    '{id}'   , 'AuthorityController@update' );
            Route::post(   'sync'   , 'AuthorityController@sync'   );
            Route::post(   'attach' , 'AuthorityController@attach' );
            Route::delete( 'detach' , 'AuthorityController@detach' );
        });


        // 多对多关联操作 => 账号 && 职务
        Route::group(['prefix' => 'account/{parentId}/duty', 'namespace' => 'Account'], function () {
            Route::put(    '{id}'   , 'DutyController@update' );
            Route::post(   'sync'   , 'DutyController@sync'   );
            Route::post(   'attach' , 'DutyController@attach' );
            Route::delete( 'detach' , 'DutyController@detach' );
        });


    });
});
