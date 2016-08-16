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

    // Root directory of Web
    Route::get('/', 'HomeController@index');

    // --------------------------------------乐曲路由----------------------------------------------
    // 通过csv文件批量添加数据
    Route::post('/music/storecsv', 'MusicController@storeCsv');

    // 获取不同筛选条件中的值
    Route::get('/music/condations', 'MusicController@getCondations');

    // 乐曲上架
    Route::get('/music/putaway/{id}', 'MusicController@putaway');

    // 批量乐曲上架
    Route::put('/music/putawayMany', 'MusicController@putawayMany');

    // 批量乐曲下架
    Route::delete('/music/offshelfMany', 'MusicController@offshelfMany');

    // 曲库统计
    Route::get('/music/musicStatistics', 'MusicController@musicStatistics');

    // 按乐器种类取得曲库统计数据
    Route::get('/music/musicStatisticsByInstrument', 'MusicController@musicStatisticsByInstrument');

    // 下载乐曲
    Route::get('/music/downloadMusic', 'MusicController@downloadMusic');

    // 曲库resource路由
    Route::resource('/music', 'MusicController');


    // Default Route, useless.
    Route::get('/home', 'HomeController@index');
    // 添加乐器的UI界面
    Route::resource('instrument', 'InstrumentController');
    // --------------------------------------用户路由----------------------------------------------

    // 学生使用情况统计
    Route::get('/user/usageStatistics', 'UserController@usageStatistics');

    // 活跃用户数
    Route::get('/user/activeUser', 'UserController@activeUser');

    // 取得一个时期内从开始到当前，每个单位时间增加的用户数
    Route::get('/user/calEveryPeriodAddUsers', 'UserController@calEveryPeriodAddUsers');

    // 锁定或者解锁用户
    Route::get('/user/lockuser/{id}', 'UserController@lockUser');

    // 获取所有省份
    Route::get('/user/provinces', 'UserController@getProvinces');

    // 根据省份获取城市列表
    Route::get('/user/cities/{id}', 'UserController@getCities');

    // 播放记录
    Route::get('/user/playRecords', 'UserController@playRecords');

    // 锁定选中的用户
    Route::put('/user/lockUsers', 'UserController@lockUsers');

    // 解锁选中的用户
    Route::put('/user/unlockUsers', 'UserController@unlockUsers');

    // 通知选中的用户
    Route::post('/user/notifyUsers', 'UserController@notifyUsers');

    // 单个用户的“基本信息”
    Route::get('/user/basicinfo/{id}', 'UserController@showBasicInfo');

    // 单个用户的“活动历史”
    Route::get('/user/actionhistory/{id}', 'UserController@showActionHistory');

    // 单个用户的“成绩历史”
    Route::get('/user/recordhistory/{id}', 'UserController@showRecordHistory');

    // 单个用户的“订单历史”
    Route::get('/user/orderhistory/{id}', 'UserController@showOrderHistory');

    // 单个用户的“社交历史”
    Route::get('/user/socialhistory/{id}', 'UserController@showSocialHistory');

    // 成绩报告
    Route::get('/user/recordReport/{id}', 'UserController@recordReport');

    // 获取绘图所用的数据
     Route::get('/user/recordReportChart/{id}', 'UserController@recordReportChart');

    // 使用资源路由
    Route::resource('/user', 'UserController');

    // --------------------------------------教师路由----------------------------------------------

    // /**
    //  * 锁定或解锁教师
    //  */
    //  Route::get('/lockteacher/{id}', 'TeacherController@lockTeacher');
    //
    // /**
    // * 使用资源路由
    // */
    // Route::resource('/teacher', 'TeacherController');
    // --------------------------------------订单路由-------------------------------------------------

    // 订单统计
    Route::get('/order/statistics', 'OrderController@statistics');

    // 锁定或解锁订单
    Route::get('/lockorder/{id}', 'OrderController@lockOrder');

    // 订单趋势
    Route::get('/order/tendency', 'OrderController@tendency');

    // 使用资源路由
    Route::resource('/order', 'OrderController');
    // --------------------------------------财务路由-------------------------------------------------
    Route::resource('/finance', 'FinanceController');
    // --------------------------------------RBAC-------------------------------------------------
    Route::resource('rbac', 'RbacController');

    // --------------------------------------机构邀请码路由--------------------------------------
    // 查询结果界面
    Route::get('/org_invite_codes', 'OrgInvitationController@getRsearchResult');
    // 取得所有机构的名称
    Route::get('/institutions/name', 'OrgInvitationController@getInstitutionsName');
    // 获取邀请码
    Route::get('/getInviteCode', 'OrgInvitationController@getInviteCode');
    // 添加机构
    Route::post('/institution', 'OrgInvitationController@postInstitution');
    // 批量更新邀请码状态
    Route::put('/institutions/invite_code', 'OrgInvitationController@updateInvitecodeStatus');
    // 更新单个邀请码状态
    Route::put('/institution/{id}/invite_code', 'OrgInvitationController@updateOneInviteCodeStatus');
    // 获取单个机构信息
    Route::get('/institution/{id}', 'OrgInvitationController@getInsInfo');
    // 更新单个机构信息
    Route::put('/institution/{id}', 'OrgInvitationController@updateInsInfo');
    // --------------------------------------教师邀请码路由--------------------------------------
    // 查询结果界面
    Route::get('/teach_invite_codes', 'TeacherInvitationController@getRsearchResult');
    // 取得所有教师的名称
    Route::get('/teachers/name', 'TeacherInvitationController@getTeachersName');
    // 添加机构
    Route::post('/teacher', 'TeacherInvitationController@postTeacher');
    // 批量更新邀请码状态
    Route::put('/teachers/invite_code', 'TeacherInvitationController@updateInvitecodeStatus');
    // 更新单个邀请码状态
    Route::put('/teacher/{id}/invite_code', 'TeacherInvitationController@updateOneInviteCodeStatus');
    // 获取单个机构信息
    Route::get('/teacher/{id}', 'TeacherInvitationController@getInsInfo');
    // 更新单个机构信息
    Route::put('/teacher/{id}', 'TeacherInvitationController@updateInsInfo');
    // --------------------------------------邀请新用户--------------------------------------
    // 查询结果界面
    Route::get('/invite_new_users', 'InviteNewUserController@getUserList');
    // 更新用户标识为已经结算
    Route::put('/invite_new_user/{id}', 'InviteNewUserController@updateNewUserPaid');
    // 批量更新用户标识为已经结算
    Route::put('/invite_new_users', 'InviteNewUserController@updateMultiNewUserPaid');

    // --------------------------------------邀请充值用户--------------------------------------
    Route::get('/invite_recharge_users', 'InvitRechargeUserController@getUserList');
    // 更新用户标识为已经结算
    Route::put('/invite_recharge_user/{id}', 'InvitRechargeUserController@updateUserPaid');
    // 批量更新用户标识为已经结算
    Route::put('/invite_recharge_users', 'InvitRechargeUserController@updateMultiUserPaid');
    // --------------------------------------反馈管理--------------------------------------
    // 管理用户反馈信息
    Route::resource('/manage_feedback', 'ManageFeedbackController');

    // --------------------------------------管理升级版本号--------------------------------------
    // 获取所有平台版本信息
    Route::get('/manage_update_version', 'ManageUpdateVersionController@getVersions');
    // 获取某一个平台的版本信息
    Route::get('/app_version/{id}', 'ManageUpdateVersionController@getVersion');
    // 更新某一个平台的版本信息
    Route::put('/app_version/{id}', 'ManageUpdateVersionController@updateVersion');

    // --------------------------------------WAV自动化匹配测试--------------------------------------
    // 匹配midi
    Route::post('/auto_test_wav/generateAndMatchMidi', 'AutoTestController@generateAndMatchMidi');
    // resource路由
    Route::resource('auto_test_wav', 'AutoTestController');

    // 测试路由
    Route::get('/getPic', 'test001Controller@getPic');
    // Email发送成绩报告
    Route::get('/report', 'ReportListController@sendReport');
    // Route::get('/reportView', function() {return view('emails.test');});
    // 添加midi文件播放时长
    Route::get('/addMidiDuration', 'test001Controller@addDuration');
    // 获得midi文件的轨道数
    Route::get('/getTrackCount', 'test001Controller@getTrackCount');

    // 苗鹏测试通过URL生成图片
    // Route::get('/getchart', function() {
    //     return view('index');
    // });

    // 测试 取得"上个月练习时间之和"
    Route::get('/getTable', 'test001Controller@getTable');
});
