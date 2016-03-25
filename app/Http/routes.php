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

    // --------------------------------------乐曲路由----------------------------------------------
    /**
     * 通过csv文件批量添加数据
     */
    Route::post('/music/storecsv', 'MusicController@storeCsv');

    /**
    * 获取不同筛选条件中的值
    */
    Route::get('/music/condations', 'MusicController@getCondations');

    /**
     * 乐曲上架
     */
    Route::get('/music/putaway/{id}', 'MusicController@putaway');

    /**
     * 批量乐曲上架
     */
    Route::put('/music/putawayMany', 'MusicController@putawayMany');

    /**
     * 批量乐曲下架
     */
    Route::delete('/music/offshelfMany', 'MusicController@offshelfMany');

    /**
     * 曲库统计
     */
    Route::get('/music/musicStatistics', 'MusicController@musicStatistics');

    /**
     * 按乐器种类取得曲库统计数据
     */
    Route::get('/music/musicStatisticsByInstrument', 'MusicController@musicStatisticsByInstrument');

    /**
     * 曲库resource路由
     */
    Route::resource('/music', 'MusicController');


    /**
     * Default Route, useless.
     */
    Route::get('/home', 'HomeController@index');
    // --------------------------------------用户路由----------------------------------------------

    /**
     * 学生使用情况统计
     */
    Route::get('/user/usageStatistics', 'UserController@usageStatistics');

    /**
     * 活跃用户数
     */
    Route::get('/user/activeUser', 'UserController@activeUser');

    /**
     * 取得一个时期内从开始到当前，每个单位时间增加的用户数
     */
    Route::get('/user/calEveryPeriodAddUsers', 'UserController@calEveryPeriodAddUsers');
    
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
     * 锁定或解锁订单
     */
    Route::get('/lockorder/{id}', 'OrderController@lockOrder');
    // --------------------------------------财务路由-------------------------------------------------
    Route::resource('/finance', 'FinanceController');
    // --------------------------------------RBAC-------------------------------------------------
    Route::resource('rbac', 'RbacController');
});
// 测试路由
Route::get('/test', function() {
    return view('auth.passwords.reset')->with('token', '123456');
});
