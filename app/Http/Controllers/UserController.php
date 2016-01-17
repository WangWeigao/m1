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

        //通过用户ID查询详细信息, 且包含订单信息(usertype=1的为学生)
        $userInfo = User::where('uid', $id)->where('usertype', 1)->first();

        //用户的订单信息
        $orderInfo = $userInfo->orders;

        /**
         * 用户登录信息
         * 因表结构中只有用户最后一次登录的数据, 只能提供这个
         * @var string
         */
        $loginInfo = $userInfo->lastlogin;

        /**
         * 用户投诉历史
         * 因没有相关数据表结构, 暂时无法提供这个数据.
         */


        //将用户详情, 订单信息, 登录信息组合为同一个数组
        $data['userInfo'] = $userInfo;
        $data['orderInfo'] = $orderInfo;
        $data['loginInfo'] = $loginInfo;

        //以Json形式返回
        return $data;
    }


    /**
     * 锁定或解锁用户
     * @method lockUser
     * @param  integer   $id 用户ID
     * @return Json          操作是否成功
     */
    public function lockUser($id)
    {
        //获取用户激活状态
        $active = User::where('uid', $id)->first()->isactive;

        /**
         * 判断用户是否锁定, 以执行相反操作
         */
        if ($active) {
            //取消激活状态(锁定)
            $result = User::where('uid', $id)->update(['isactive'=>0]);

        }else {
            //激活(解锁)
            $result = User::where('uid', $id)->update(['isactive'=>1]);
        }

        return $result;
    }


}
