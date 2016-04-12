<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\StudentUser;
use App\Lesson;
use DB;
use Carbon\Carbon;
use App\Order;
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
     * 模糊查询用户信息
     * @method queryUserInfo
     * @param  Request       $request 用户请求携带的数据
     * @return Json          $users   数据传递给视图
     */
    public function index(Request $request)
    {
        //取得要查询的用户名
        $name = $request->get('name') ? $request->get('name') : '';

        /**
         * 用来排序的字段
         */
        // $field = $request->get('field');
        // $order = $request->get('order');

        //模糊匹配, 查询结果为分页做准备

        /**
         * 如果查询字段$name为空，则不进行查询
         */
        if (empty($name)) {
            return view('user');
        }

        /**
         * 同时模糊匹配"用户名"和"电话号码"
         * @var Object
         */
        $users = StudentUser::where('usertype', 1);
                                // ->orwhere('cellphone', 'like', "%$name%")
                                // ->orwhere('nickname', 'like', "%$name%");
                                // ->where('nickname', 'like', "%$name%");

        if (is_numeric($name)) {
            $users->where('cellphone', 'like', "%$name%");
        }else {
            $users->where('nickname', 'like', "%$name%");
        }

        $users = $users
                ->leftjoin('orders', 'users.uid', '=', 'orders.student_uid')
                ->select('users.uid', 'users.nickname', 'users.cellphone', 'users.email', 'users.regdate', 'users.lastlogin', 'users.isactive', DB::raw('count(orders.student_uid) as order_num'))
                ->groupby('users.uid')
                // ->orderby($field, $order)
                // ->get();
                    //  由前端分页, 此处暂时用不到
                ->paginate(15);

        /**
         * 由于laravel不支持在分页结果
         */

        //将结果传递给视图
        return view('user')->with(['users' => $users, 'name' => $name]);

    }

    /**
     * 查询用户详细信息
     * @method show
     * @param  number           $id 用户ID
     * @return Json             包含用户详情, 订单信息, 登录信息
     */
    public function show($id)
    {
        // //通过用户ID查询详细信息, 且包含订单信息(usertype=1的为学生)
        // $userInfo = StudentUser::where('uid', $id)->where('usertype', 1)->with('orders')->first();
        //
        // /**
        // * 对查出来的结果添加 teacher_uid 和 teacher_nickname 两个字段
        // * 以便在表格显示时, 显示出课程中教师相关的信息
        // */
        // foreach ($userInfo['orders'] as $order) {
        //     /**
        //      * 通过课程lid查询用户信息
        //      */
        //     $user = Lesson::find($order->lid)->user()->select('uid as teacher_uid', 'nickname as teacher_nickname')->first();
        //
        //     /**
        //      * 给 $userInfo 数组添加教师信息
        //      */
        //     $order->teacher_uid = $user->teacher_uid;
        //     $order->teacher_nickname = $user->teacher_nickname;
        // }
        //
        // /**
        //  * 用户登录信息
        //  * 因表结构中只有用户最后一次登录的数据, 只能提供这个
        //  * @var string
        //  */
        // $loginInfo = $userInfo->lastlogin;
        //
        // /**
        //  * 用户投诉历史
        //  * 因没有相关数据表结构, 暂时无法提供这个数据.
        //  */
        //
        // /**
        //  * 将用户详情, 订单信息, 登录信息组合为同一个数组
        //  */
        // $data['userInfo'] = $userInfo;
        // $data['loginInfo'] = $loginInfo;
        //
        // //以Json形式返回
        // return view('userdetail')->with('data', $data);
    }

    /**
     * 锁定或解锁用户
     * @method lockUser
     * @param  integer   $id 用户ID
     * @return Json          操作是否成功
     */
    // public function lockUser($id)
    // {
    //     //获取用户激活状态
    //     $active = StudentUser::where('uid', $id)->first()->isactive;
    //
    //     /**
    //      * 判断用户是否锁定, 以执行相反操作
    //      */
    //     if ($active) {
    //         //取消激活状态(锁定)
    //         $result = StudentUser::where('uid', $id)->update(['isactive'=>0]);
    //     }else {
    //         //激活(解锁)
    //         $result = StudentUser::where('uid', $id)->update(['isactive'=>1]);
    //     }
    //
    //     return $active;
    // }

    /**
     * 学生使用情况统计
     * @method usageStatistics
     * @return [json]          [description]
     */
    public function usageStatistics()
    {
        /**
         * 今日的统计结果
         */
        $today_carbon_start = Carbon::now()->startOfDay();
        $today_carbon_end =  Carbon::now()->endOfDay();
        $data['countStudents'] = StudentUser::count();  // 用户数
        $data['todayCountAdd'] = StudentUser::whereBetween('regdate', [$today_carbon_start, $today_carbon_end])->count();   // 今日增加用户数
        $data['todayCountUsed'] = StudentUser::whereBetween('lastlogin', [$today_carbon_start, $today_carbon_end])->count(); // 今日使用用户数
        $data['todayCountOrder'] = Order::whereBetween('submit_time', [$today_carbon_start, $today_carbon_end])->count();    // 今日订单数

        $today_request = new Request(['duration' => 30, 'date' => 'today']);
        $data['todayCountActive'] = self::activeUser($today_request);    // 今日活跃用户数(机器人使用时长30分钟以上)

        /**
         * 本月的统计结果
         */
         $month_carbon_start = Carbon::now()->startOfMonth();
         $month_carbon_end =  Carbon::now()->endOfMonth();
        //  $data['countStudents'] = StudentUser::count();  // 用户数
         $data['monthCountAdd'] = StudentUser::whereBetween('regdate', [$month_carbon_start, $month_carbon_end])->count();   // 今日增加用户数
         $data['monthCountUsed'] = StudentUser::whereBetween('lastlogin', [$month_carbon_start, $month_carbon_end])->count(); // 今日使用用户数
         $data['monthCountOrder'] = Order::whereBetween('submit_time', [$month_carbon_start, $month_carbon_end])->count();    // 今日订单数

         $month_request = new Request(['duration' => 1800, 'date' => 'month']);
         $data['monthCountActive'] = self::activeUser($month_request);    // 今日活跃用户数(机器人使用时长30小时以上)
        //  $data['monthDayth'] = Carbon::now()->day;
        $data['monthValue'] = Carbon::now()->day;
        //  $data['monthArray'] = self::calEveryPeriodAddUsers('month', Carbon::now()->day);

        /**
         * 本季度的统计结果
         */
         $quarter_carbon_start = Carbon::now()->firstOfQuarter();
         $quarter_carbon_end =  Carbon::now()->lastOfQuarter();
        //  return $quarter_carbon_start . '/' . $quarter_carbon_end;
        //  $data['countStudents'] = StudentUser::count();  // 用户数
         $data['quarterCountAdd'] = StudentUser::whereBetween('regdate', [$quarter_carbon_start, $quarter_carbon_end])->count();   // 今日增加用户数
         $data['quarterCountUsed'] = StudentUser::whereBetween('lastlogin', [$quarter_carbon_start, $quarter_carbon_end])->count(); // 今日使用用户数
         $data['quarterCountOrder'] = Order::whereBetween('submit_time', [$quarter_carbon_start, $quarter_carbon_end])->count();    // 今日订单数

         $quarter_request = new Request(['duration' => 1800, 'date' => 'quarter']);
         $data['quarterCountActive'] = self::activeUser($quarter_request);    // 今日活跃用户数(机器人使用时长30小时以上)
        //  $data['QuarterMonth'] = Carbon::now()->nthOfQuarter();

        /**
         * 本年的统计结果
         */
         $year_carbon_start = Carbon::now()->firstOfQuarter();
         $year_carbon_end =  Carbon::now()->lastOfQuarter();
        //  return $year_carbon_start . '/' . $year_carbon_end;
        //  $data['countStudents'] = StudentUser::count();  // 用户数
         $data['yearCountAdd'] = StudentUser::whereBetween('regdate', [$year_carbon_start, $year_carbon_end])->count();   // 今日增加用户数
         $data['yearCountUsed'] = StudentUser::whereBetween('lastlogin', [$year_carbon_start, $year_carbon_end])->count(); // 今日使用用户数
         $data['yearCountOrder'] = Order::whereBetween('submit_time', [$year_carbon_start, $year_carbon_end])->count();    // 今日订单数

         $year_request = new Request(['duration' => 1800, 'date' => 'year']);
         $data['yearCountActive'] = self::activeUser($year_request);    // 今日活跃用户数(机器人使用时长30小时以上)
        return view('usageStatistics')->with('data', $data);
    }

    /**
     * 活跃用户数
     * @method activeUser
     * @param  Request    $request [其中含有,今日,本月,本季度,本年的标识 以及 是否产生订单的标识]
     * @return [type]              [活跃的用户数]
     */
    public function activeUser(Request $request)
    {
        switch ($request->date) {
            case 'today':
                $date_start = Carbon::now()->startOfDay();
                $date_end = Carbon::now()->endOfDay();
                break;
            case 'month':
                $date_start = Carbon::now()->startOfMonth();
                $date_end = Carbon::now()->endOfMonth();
                break;
            case 'quarter':
                $date_start = Carbon::now()->firstOfQuarter();
                $date_end = Carbon::now()->lastOfQuarter();
                break;
            case 'year':
                $date_start = Carbon::now()->startOfYear();
                $date_end = Carbon::now()->endOfYear();
                break;
            default:
                # code...
                break;
        }
        $duration = $request->get('duration');
        $order  = $request->get('order');
        $countTodayActive = StudentUser::whereHas('robot_durations', function ($query) use ($duration, $date_start, $date_end)  {
            $query->whereBetween('created_at', [$date_start, $date_end])->groupby('user_id')->havingRaw("SUM(duration) > $duration");
        });
            if ($order) {
                $countTodayActive = $countTodayActive->has('orders');
            }
                $countTodayActive = $countTodayActive->count();    // 机器人使用时长30分钟以上
        return $countTodayActive;
    }

    public function calEveryPeriodAddUsers(Request $request)
    {
        $period = $request->get('period');
        $length = $request->get('length');

        for ($i=1; $i <= $length; $i++) {
            $today_carbon_start = Carbon::now()->day($i)->startOfDay();
            $today_carbon_end =  Carbon::now()->day($i)->endOfDay();
            $data[] = StudentUser::whereBetween('regdate', [$today_carbon_start, $today_carbon_end])->count();   // 今日增加用户数
        }
        return $data;
    }

    /**
     * 取得当前月份的活跃用户
     * @method getActiveUserOfMonth
     * @return [type]               [description]
     */
    public function getActiveUserOfMonth()
    {
        $practice_duration = Request::get('practice_duration');
        $account_type      = Request::get('account_type');
        // $data = StudentUser::where('')
    }

    /**
     * 获取所有省份
     * @method getProvinces
     * @return [type]       [description]
     */
    public function getProvinces()
    {
        $data = \App\Province::where('pid', '>', 0)->get();
        return $data;
    }

    public function getCities($id)
    {
        $cities = \App\City::where('pid', $id)->get();
        return $cities;
    }

    /**
     * 获取弹奏记录
     * @method playRecords
     * @return [type]      [description]
     */
    public function playRecords()
    {
        /**
         * 获取所有弹奏记录
         */
        $play_records = \App\Play_record::with(['music' => function ($query) {
            $query->withTrashed();
        }])->get();

        /**
         * 将记录中的midi_path字符串, 分隔成数组
         */
        foreach ($play_records as $key => $value) {
            $value->midi_path = explode(',', $value->midi_path);
        }

        foreach ($play_records as $value) {
            $temp_value = $value->midi_path;
            foreach ($temp_value as $v) {
                $temp = explode('public', $v);
                $v = $temp[1];
            }
            // dd($temp_value);
            $value->midi_path = $temp_value;
        }
// return $play_records;
        return view('playRecords')->with('play_records', $play_records);
    }

    /**
     * 下载midi文件
     * @method downloadMusic
     * @param  Request       $request [原文件, 新文件名]
     * @return [?]                 [请求的下载文件]
     */
    // public function downloadSectionMidi(Request $request)
    // {
    //     // 真实文件所在的位置
    //     $path = public_path('midis') ;
    //     // 第一个参数: 原始文件
    //     $filename = $path . '/' . $request->get('name');
    //     // 第二个参数: 新文件名
    //     $newfilename = $request->get('newname') . '.mid';
    //     // 第三个参数: 响应头
    //     $headers = array(
    //       'Content-Type: audio/mid',
    //     );
    //
    //     return Response::download($filename, $newfilename, $headers);
    // }
}
