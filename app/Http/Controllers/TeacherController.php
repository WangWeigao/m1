<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\StudentUser;
use DB;

class TeacherController extends Controller
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
     * Display a seaching input.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('teacher');
    }


    /**
     * 模糊查询用户信息
     * @method queryUserInfo
     * @param  Request       $request 用户请求携带的数据
     * @return Json          $teachers   数据传递给视图
     */
    public function getTeachers(Request $request)
    {
        //取得要查询的用户名
        $name = $request->get('name');

        //模糊匹配, 查询结果为分页做准备
        $teachers = StudentUser::where('usertype', '<>', '1')
                     ->where('nickname', 'like', "%$name%")
                     ->leftjoin('orders', 'users.uid', '=', 'orders.student_uid')
                     ->select('users.uid', 'users.nickname', 'users.cellphone', 'users.email', 'users.regdate', 'users.lastlogin', 'users.isactive', DB::raw('count(orders.student_uid) as order_num'))
                     ->groupby('users.uid')
                     ->paginate(3);

        //将结果传递给视图
        return view('getteachers')->with(['teachers' => $teachers, 'name' => $name]);

    }


    /**
     * 查询用户详细信息
     * @method userDetailInfo
     * @param  number           $id 用户ID
     * @return Json             包含用户详情, 订单信息, 登录信息
     */
    public function teacherDetailInfo($id)
    {
        //通过用户ID查询详细信息, 且包含订单信息(usertype=1的为学生)
        $teacherInfo = StudentUser::where('uid', $id)->with('orders')->first();

        /**
        * 对查出来的结果添加 teacher_uid 和 teacher_nickname 两个字段
        * 以便在表格显示时, 显示出课程中教师相关的信息
        */
        foreach ($teacherInfo['orders'] as $order) {
            /**
             * 通过课程lid查询用户信息
             */
            $user = Lesson::find($order->lid)->user()->select('uid as teacher_uid', 'nickname as teacher_nickname')->first();

            /**
             * 给 $teacherInfo 数组添加教师信息
             */
            $order->teacher_uid = $user->teacher_uid;
            $order->teacher_nickname = $user->teacher_nickname;
        }

        /**
         * 用户登录信息
         * 因表结构中只有用户最后一次登录的数据, 只能提供这个
         * @var string
         */
        $loginInfo = $teacherInfo->lastlogin;

        /**
         * 用户投诉历史
         * 因没有相关数据表结构, 暂时无法提供这个数据.
         */

        /**
         * 将用户详情, 订单信息, 登录信息组合为同一个数组
         */
        $data['teacherInfo'] = $teacherInfo;
        $data['loginInfo'] = $loginInfo;

        //以Json形式返回
        return view('teacherdetail')->with('data', $data);
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
        $active = StudentUser::where('uid', $id)->first()->isactive;

        /**
         * 判断用户是否锁定, 以执行相反操作
         */
        if ($active) {
            //取消激活状态(锁定)
            $result = StudentUser::where('uid', $id)->update(['isactive'=>0]);
        }else {
            //激活(解锁)
            $result = StudentUser::where('uid', $id)->update(['isactive'=>1]);
        }

        return $active;
    }
}
