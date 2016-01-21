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


Route::group(['middleware' => 'web'], function () {
    /**
     * Default Route for Login and Register and ForgetPassword
     */
    Route::auth();

    /**
     * Root directory of Web
     */
    Route::get('/', function () {
        return redirect('home');
    });

    /**
     * Default Route, useless.
     */
    Route::get('/home', 'HomeController@index');

    /**
     * display users of the conditions
     */
    Route::get('/user', 'UserController@index');

    /**
     * get the Users queried
     */
     Route::any('/getusers', 'UserController@getUsers');

    /**
    * 获取单个用户的详细信息
    */
    Route::get('/userdetail/{id}', 'UserController@userDetailInfo');

    /**
     * 按时间查询订单, 显示视图
     */
    Route::get('/order', 'OrderController@index');

    /**
     * 按时间查询订单, 显示查询结果
     */
    Route::any('/getorders', 'OrderController@getOrders');
});
