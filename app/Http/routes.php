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
    // 认证路由...
    Route::get('auth/login', 'Auth\AuthController@getLogin');
    Route::post('auth/login', 'Auth\AuthController@postLogin');
    Route::get('auth/logout', 'Auth\AuthController@getLogout');
    // 注册路由...
    Route::get('auth/register', 'Auth\AuthController@getRegister');
    Route::post('auth/register', 'Auth\AuthController@postRegister');
    // 登录后的跳转路由
    Route::get('profile','UserController@profile');

    Route::get('/', 'TeacherController@getTeachers');
    /**
    * 获取用户信息
    */
    Route::post('users', 'UserController@queryUsers');

    /**
    * 获取教师信息
    */
    Route::post('teachers', 'TeacherController@getTeachers');

    /**
    * 获取单个用户的详细信息
    */
    Route::get('userinfo/{id}', 'UserController@userDetailInfo');

    /**
    * 对用户进行锁定或解锁
    */
    Route::get('lockuser/{id}', 'UserController@lockUser');

    /**
    * 按查询时间取得订单
    */
    Route::post('getorders', 'OrderController@getOrders');

    /**
    * 取得所有未审批的课程
    */
    Route::get('lessons', 'ReleaseAccreditController@lessons');

    /**
    * 对教师发布的课程进行审批
    */
    Route::post('accredit/{id}', 'ReleaseAccreditController@accredit');
});


/**
 * 测试路由
 */
Route::get('test', function () {
    return 'm1 test!';
});
