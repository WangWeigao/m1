<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

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

Route::group(['middleware' => ['web']], function () {
    //
});


/**
 * 获取所有用户信息
 */
Route::get('home', 'UserController@getUsers');
Route::get('teachers', 'TeacherController@getTeachers');
/**
 * 测试路由
 */
Route::get('test', function () {
    return 'm1 test!';
});

/**
 * 测试 jquery 使用
 */
Route::get('jquery', function () {
    return view('jquery');
});
