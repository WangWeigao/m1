<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Order;
use App\Module;

class UserController extends Controller
{

    /**
     * 模糊查询用户信息
     * @method queryUserInfo
     * @param  Request       $request 用户请求携带的数据
     * @return Json          $users   数据传递给视图
     */
    public function queryUsers(Request $request)
    {
        //取得要查询的用户名
        $nickname = $request->get('nickname');

        //模糊匹配, 查询结果为分页做准备
        $users = User::where('nickname', 'like', $nickname)->paginate(10);

        //将结果传递给 home 视图
        return view('user')->with('users', $users);
    }


    /**
     * 查询用户详细信息
     * @method userDetailInfo
     * @param  number           $id 用户ID
     * @return Json             包含用户详情, 订单信息, 登录信息
     */
    public function userDetailInfo($id)
    {
        //通过用户ID查询详细信息
        $userInfo = User::where('uid', $id)->first();
        // return ($userInfo);

        //用户的订单信息
        // $orderInfo = $userInfo->orders()->get();
        // $orders = User::where('uid', $id)->first()->orders()->where('oid', '<>', 0)->get();
        //
        // foreach ($orders as $key => $order) {
        //     dd($order);
        // }

        $info = Module::where('id', 1);
        dd($info);
        //用户的登录信息
        $loginInfo = '';
        //
        // $data['userInfo'] = $userInfo;
        // $data['orderInfo'] = $orderInfo->get();
        // $data['loginInfo'] = $loginInfo;
        //
        // return $data;

    }
}
