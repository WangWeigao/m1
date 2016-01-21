<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\OldUser;
use App\Lesson;
use DB;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
     public function __construct()
     {
         $this->middleware('auth');
     }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user');
    }


    /**
     * 模糊查询用户信息
     * @method queryUserInfo
     * @param  Request       $request 用户请求携带的数据
     * @return Json          $users   数据传递给视图
     */
    public function getUsers(Request $request)
    {
        //取得要查询的用户名
        $name = $request->get('name');

        //模糊匹配, 查询结果为分页做准备
        $users = OldUser::where('usertype', 1)
                     ->where('nickname', 'like', "%$name%")
                     ->join('orders', 'users.uid', '=', 'orders.student_uid')
                     ->select('users.uid', 'users.nickname', 'users.cellphone', 'users.email', 'users.regdate', 'users.lastlogin', DB::raw('count(orders.student_uid) as order_num'))
                     ->groupby('users.uid')
                     ->paginate(10);

        //将结果传递给视图
        return view('getusers')->with('users', $users);

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
        $userInfo = OldUser::where('uid', $id)->where('usertype', 1)->with('orders')->first();


        /**
        * 对查出来的结果添加 teacher_uid 和 teacher_nickname 两个字段
        * 以便在表格显示时, 显示出课程中教师相关的信息
        */
        foreach ($userInfo['orders'] as $order) {
            /**
             * 通过课程lid查询用户信息
             */
            $user = Lesson::find($order->lid)->user()->select('uid as teacher_uid', 'nickname as teacher_nickname')->first();

            $order->teacher_uid = $user->teacher_uid;
            $order->teacher_nickname = $user->teacher_nickname;
        }

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
        $data['loginInfo'] = $loginInfo;
        
        //以Json形式返回
        return view('userdetail')->with('data', $data);
    }
}
