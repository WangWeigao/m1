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
    // --------------------------------------用户路由----------------------------------------------

     /**
     * 锁定或者解锁用户
     */
     Route::get('/lockuser/{id}', 'UserController@lockUser');

     /**
      * 使用资源路由
      */
     Route::resource('/user', 'UserController');

    // --------------------------------------教师路由----------------------------------------------

    /**
     * 锁定或解锁教师
     */
     Route::get('/lockteacher/{id}', 'TeacherController@lockTeacher');

    /**
    * 使用资源路由
    */
    Route::resource('/teacher', 'TeacherController');
    // --------------------------------------订单路由-------------------------------------------------
    /**
     * 使用资源路由
     */
    Route::resource('/order', 'OrderController');
    /**
     * 按时间查询订单, 显示视图
     */
    // Route::get('/order', 'OrderController@index');

    /**
    * 按时间查询订单, 显示查询结果
    */
    // Route::any('/getorders', 'OrderController@getOrders');

    /**
     * 锁定或解锁订单
     */
    Route::get('/lockorder/{id}', 'OrderController@lockOrder');

    /**
     * 获取单个订单的详细信息
     */
    // Route::get('/orderdetail/{id}', 'OrderController@orderDetailInfo');


});
// 测试路由
Route::any('/test', function() {
    return view('test');
});
