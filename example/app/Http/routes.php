<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/


Route::group([
	  'middleware' => ['module:home'],
	  'prefix'     => 'home',
	  'namespace'  => 'Home',
], function () {
    require __DIR__.'/routes-home.php';
});


Route::group([
	  'middleware' => ['module:admin'],
	  'prefix'     => 'admin',
	  'namespace'  => 'Admin',
], function () {
    require __DIR__.'/routes-admin.php';
});

