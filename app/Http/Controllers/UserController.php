<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\StudentUser;
use App\Lesson;
use App\Notification;
use DB;
use Carbon\Carbon;
use App\Order;
use App\RobotDuration;
use App\Practice;
use App\RobotOrder;
use App\UserAction;
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
        // DB::connection()->enableQueryLog();

        $user_cellphone_email = $request->get('user_cellphone_email', '');  // 用户名|手机号|邮箱
        $city_id              = $request->get('area', '');                  // 地域(城市ID)
        $user_grade           = $request->get('user_grade', '');            // 水平等级
        $reg_time             = $request->get('reg_time', '');              // 注册时间
        $account_grade        = $request->get('account_grade', '');         // 帐号级别
        $account_end_at       = $request->get('account_end_at', '');        // 帐号截止日期
        $month_duration       = $request->get('month_duration', '');        // 本月使用时长
        $account_status       = $request->get('account_status', '');        // 帐号状态
        $change_duration      = $request->get('change_duration', '');       // 本月用时大幅变化
        $liveness             = $request->get('liveness', '');              // 活跃度
        $reg_start_time       = $request->get('reg_start_time', '');        // 注册时间段 > 开始时间
        $reg_end_time         = $request->get('reg_end_time', '');          // 注册时间段 > 结束时间
        $field                = $request->get('field');                     // 排序字段
        $order                = $request->get('order');                     // 排序方式

        /**
         * 用来排序的字段
         */
        // $field = $request->get('field');
        // $order = $request->get('order');

        /**
         * 如果查询字段$name为空，则不进行查询
         */
        if (empty($user_cellphone_email)
            && empty($city_id)
            && empty($user_grade)
            && empty($reg_time)
            && empty($account_grade)
            && empty($account_end_at)
            && empty($month_duration)
            && empty($account_status)
            && empty($change_duration)
            && empty($liveness)
            && empty($reg_start_time)
            && empty($reg_end_time)) {
                return view('user');
        }

        /**
         * 按字段不为这的情况，进行SQL语句拼接
         * "用户名"不为空
         */
        $users = StudentUser::where(function ($query) {
            $query->where('usertype', '=', 1)
                  ->orWhere('usertype', '<>', 1);
        });
        if (!empty($user_cellphone_email)) {
            $users->where(function  ($query) use ($user_cellphone_email) {
                $query->where('nickname', 'like', "%{$user_cellphone_email}%")
                        ->orWhere('cellphone', 'like', "%{$user_cellphone_email}%")
                        ->orWhere('email', 'like', "%{$user_cellphone_email}%");
            });
        }

        /**
         * "地域"不为空
         */
        if (!empty($city_id)) {
            $users->where('city_id', $city_id);
        }

        /**
         * "水平等级"不为空
         */
        if (!empty($user_grade)) {
            $users->where('user_grade', $user_grade);
        }

        /**
         * "注册时间"不为空
         */
        if (!empty($reg_time)) {
            switch ($reg_time) {
                case 'day':
                    $start_time = Carbon::now()->startOfDay();
                    $end_time   = Carbon::now()->endOfDay();
                    break;
                case 'week':
                    $start_time = Carbon::now()->subWeek();
                    $end_time   = Carbon::now()->endOfDay();
                    break;
                case 'month':
                    $start_time = Carbon::now()->subMonth();
                    $end_time   = Carbon::now()->endOfDay();
                    break;
                case 'half_year':
                    $start_time = Carbon::now()->subMonths(6);
                    $end_time   = Carbon::now()->endOfDay();
                    break;
                case 'year':
                    $start_time = Carbon::now()->subyear();
                    $end_time   = Carbon::now()->endOfDay();
                    break;
                case 'one_more_year':
                    $start_time = Carbon::minValue();
                    $end_time   = Carbon::now()->endOfDay();
                    break;
                default:
                    $start_time = Carbon::minValue();
                    $end_time   = Carbon::maxValue();
                    break;
            }

            $users->whereBetween('regdate', [$start_time, $end_time]);
        }

        /**
         * "帐号级别"不为空
         */
        if (!empty($account_grade)) {
            switch ($account_grade) {
                case 'free':
                    $account_grade = 0;
                    break;
                case 'vip1':
                    $account_grade = 1;
                    break;
                case 'vip2':
                    $account_grade = 2;
                    break;
                default:
                    $account_grade = 0;
                    break;
            }
            if ($account_grade == '0'
             || $account_grade == '1'
             || $account_grade == '2') {
                $users->where('account_grade', $account_grade);
            }
        }

        /**
         * "帐号截止日期"不为空
         */
        if (!empty($account_end_at)) {
            switch ($account_end_at) {
                case 'week':
                    $start_time = Carbon::now()->subWeek();
                    $end_time   = Carbon::now()->endOfDay();
                    break;
                case 'month':
                    $start_time = Carbon::now()->subMonth();
                    $end_time   = Carbon::now()->endOfDay();
                    break;
                case 'two_months':
                    $start_time = Carbon::now()->subMonths(2);
                    $end_time   = Carbon::now()->endOfDay();
                    break;

                default:
                    # code...
                    break;
            }
            $users->whereBetween('account_end_at', [$start_time, $end_time]);
        }

        /**
         * "本月使用时长"不为空
         */
        if (!empty($month_duration)) {
            switch ($month_duration) {
                case '1h':
                    $duration = 1*60;   // 1小时以内
                    break;
                case '5h':
                    $duration = 5*60;   // 5小时以内
                    break;
                case '10h':
                    $duration = 10*60;   // 10小时以内
                    break;
                case '30h':
                    $duration = 30*60;   // 30小时以内
                    break;
                case '60h':
                    $duration = 60*60;   // 60小时以内
                    break;
                case '60h_more':
                    $duration = 60*60+1; // 60小时以上
                    break;
                case '0h':
                    $duration = 0;       // 未使用
                    break;
                default:
                    $duration = -1;      //
                    break;
            }
            if ($duration > 0 && $duration < 10*60+1) {     // 60小时以内的所有
                $users->whereHas('robot_durations', function ($query) use ($duration) {
                    $query->havingRaw("SUM(robot_durations.duration) <= $duration")
                            ->groupBy('robot_durations.user_id');
                });
            } elseif ($duration == 0) {     // 未使用
                $users->whereNotExists(function ($query) use ($duration) {
                    $query->select(DB::raw(1))
                          ->from('robot_durations')
                          ->whereRaw('robot_durations.user_id = users.uid');
                });
            } elseif ($duration == 60*60+1) {   // 60小时以上
                $users->whereHas('robot_durations', function ($query) use ($duration) {
                    $query->groupBy('robot_durations.user_id')
                          ->havingRaw("SUM(robot_durations.duration) > $duration");
                });
            } else {
                $users->has('robot_durations'); // 如果出现其它情况，则显示所有"使用过的用户"
            }
        }

        /**
         * "帐号状态"不为空
         */
        if (!empty($account_status)) {
            switch ($account_status) {
                case 'near_expire': // 到期
                    $start_time = Carbon::now()->SubWeek();
                    $end_time   = Carbon::now()->endOfDay();
                    $users->whereIn('account_grade', [1,2])
                          ->whereBetween('account_end_at', [$start_time, $end_time]);
                    break;
                case 'lock':    //锁定
                    $users->where('isactive', 0);
                    break;
                case 'normal':                                                      // 正常[确保为“免费用户”，或“到期时间大于一周”的vip用户]
                    $users->where('isactive', 1)                                    // 用户未锁定
                          ->where(function ($query) {
                              $query->where('account_grade', 0)                     // 免费用户
                                    ->orwhere(function ($query_1) {
                                        $query_1->whereIn('account_grade', [1,2])   // 到期时间大于一周的收费用户
                                                ->where('account_end_at', '>', Carbon::now()->addWeek());
                                    });
                          });
                    break;
                case 'expire':  // 未续费
                    $users->whereIn('account_grade', [1,2])
                          ->whereBetween('account_end_at', '<', Carbon::now());
                      break;
                default:
                    # code...
                    break;
            }
        }

        /**
         * "本月用户大幅变化"不为空
         */
        if (!empty($change_duration)) {
            switch ($change_duration) {
                case 'up20h':
                // $start_time = Carbon::now()->subMonth();
                // $end_time   = Carbon::now()->endOfDay();
                //     $users->whereHas('robot_durations', function ($query) {
                //         $query->groupBy('robot_durations.user_id')
                //               ->havingRaw("select SUM(robot_durations.duration) as duration_sum_now where ");
                //     });
                    break;
                case 'up30h':
                    break;
                case 'up50h':
                    break;
                case 'down20h':
                    break;
                case 'down30h':
                    break;
                case 'down50h':
                    break;
                default:
                    # code...
                    break;
            }
        }
        /**
         * "活跃度"不为空
         */
        if (!empty($liveness)) {
            # 具体细节待研究
        }

        /**
         * "注册时间段"不为空
         */
        if (!empty($reg_start_time)) {
            $start_time = Carbon::parse($reg_start_time)->startOfDay();
            $end_time   = Carbon::parse($reg_end_time)->endOfDay();
            $users->whereBetween('regdate', [$start_time, $end_time]);
        }


        /**
         * 同时模糊匹配"用户名"和"电话号码"
         * @var Object
         */
        // $users = StudentUser::where('usertype', 1);
        //                         // ->orwhere('cellphone', 'like', "%$name%")
        //                         // ->orwhere('nickname', 'like', "%$name%");
        //                         // ->where('nickname', 'like', "%$name%");
        //
        // if (is_numeric($name)) {
        //     $users->where('cellphone', 'like', "%$name%");
        // }else {
        //     $users->where('nickname', 'like', "%$name%");
        // }
        //
        // $users = $users
        //         ->leftjoin('orders', 'users.uid', '=', 'orders.student_uid')
        //         ->select('users.uid', 'users.nickname', 'users.cellphone', 'users.email', 'users.regdate', 'users.lastlogin', 'users.isactive', DB::raw('count(orders.student_uid) as order_num'))
        //         ->groupby('users.uid')
        //         // ->orderby($field, $order)
        //         // ->get();
        //             //  由前端分页, 此处暂时用不到
        //         ->paginate(15);
            $start_time = Carbon::now()->subMonth();
            $end_time   = Carbon::now()->endOfDay();
            $preMonth_start_time = Carbon::now()->subMonth(2);
            $preMonth_end_time   = Carbon::now()->subMonth()->endOfDay();

            // $users->select('*');
            $users->orderBy($field, $order);
            $users = $users->paginate(10)->appends([
            'user_cellphone_email' => $user_cellphone_email,
            'city_id'              => $city_id,
            'user_grade'           => $user_grade,
            'reg_time'             => $reg_time,
            'account_grade'        => $account_grade,
            'account_end_at'       => $account_end_at,
            'month_duration'      => $month_duration,
            'account_status'      => $account_status,
            'change_duration'     => $change_duration,
            'liveness'            => $liveness,
            'reg_start_time'      => $reg_start_time,
            'reg_end_time'        => $reg_end_time
        ]);
        // return $users;
        foreach ($users as $key => $v) {
            if (!$v->isactive) {
                $v->status = '锁定';
            } else {
                if ($v->account_grade == 0) {
                    $v->status = '正常';
                } elseif ($v->account_grade == 1) {     // 如果为vip1用户
                    if (Carbon::now() < Carbon::parse($v->account_end_at)                  // 还在有效期
                        && Carbon::now()->addMonth() > Carbon::parse($v->account_end_at)   // 有效期不足一个月
                        ) {
                        $v->status = '未续费';
                    } elseif (Carbon::now() > Carbon::parse($v->account_end_at)) {
                        $v->status = 'vip已过期';
                    } else {
                        $v->status = '正常';
                    }
                } elseif ($v->account_grade == 2) {
                    if (Carbon::now() < Carbon::parse($v->account_end_at)                  // 还在有效期
                        && Carbon::now()->addWeek() > Carbon::parse($v->account_end_at)   // 有效期不足一个周
                        ) {
                        $v->status = '未续费';
                    } elseif (Carbon::now() > Carbon::parse($v->account_end_at)) {
                        $v->status = 'vip已过期';
                    } else {
                        $v->status = '正常';
                    }
                } else {
                    $v->status = '正常';
                }
            }
        }
        return view('user')->with('users', $users);
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
     * 单个用户的“基本信息”
     * @method showBasicInfo
     * @return [type]        [description]
     */
    public function showBasicInfo($id)
    {
        $user       = StudentUser::find($id);
        // 本月使用时长
        $start_time = Carbon::now()->startOfMonth();
        $end_time   = Carbon::now()->endOfDay();
        $user['duration_month'] = RobotDuration::select(DB::raw('SUM(duration) as sum_duration'))
                                                ->where('user_id', $id)
                                                ->whereBetween('created_at', [$start_time, $end_time])
                                                ->groupBy('user_id')
                                                ->get();
        if (!$user->isactive) {
            $user->status = '锁定';
        } else {
            if ($user->account_grade == 0) {
                $user->status = '正常';
            } elseif ($user->account_grade == 1) {     // 如果为vip1用户
                if (Carbon::now() < Carbon::parse($user->account_end_at)                  // 还在有效期
                    && Carbon::now()->addMonth() > Carbon::parse($user->account_end_at)   // 有效期不足一个月
                    ) {
                    $user->status = '未续费';
                } elseif (Carbon::now() > Carbon::parse($user->account_end_at)) {
                    $user->status = 'vip已过期';
                } else {
                    $user->status = '正常';
                }
            } elseif ($user->account_grade == 2) {
                if (Carbon::now() < Carbon::parse($user->account_end_at)                  // 还在有效期
                    && Carbon::now()->addWeek() > Carbon::parse($user->account_end_at)   // 有效期不足一个周
                    ) {
                    $user->status = '未续费';
                } elseif (Carbon::now() > Carbon::parse($user->account_end_at)) {
                    $user->status = 'vip已过期';
                } else {
                    $user->status = '正常';
                }
            } else {
                $user->status = '正常';
            }
        }
        // return $user;
        return view('userbasicinfo')->with('user', $user);
    }

    /**
     * 单个用户的“活动历史”
     * @method showActionHistory
     * @return Response            [description]
     */
    public function showActionHistory($id)
    {
        $actions = UserAction::where('user_id', $id)->paginate(10);

        return view('useractionhistory')->with(['actions' => $actions,
                                                'user_id' => $id]);
    }

    /**
     * 单个用户的“成绩历史”
     * @method showRecordHistory
     * @param  string            $value [description]
     * @return Response                   [description]
     */
    public function showRecordHistory($id)
    {
        $records = Practice::where('uid', $id)->paginate(10);

        return view('userrecordhistory')
                ->with(['records' => $records, 'user_id' => $id]);
    }

    /**
     * 单个用户的“订单历史”
     * @method showOrderHistory
     * @return Response           [description]
     */
    public function showOrderHistory($id)
    {
        $start_time  = Carbon::now()->startOfMonth();
        $end_time    = Carbon::now()->endOfDay();
        $orders      = RobotOrder::where('user_id', $id)->paginate(10);
        $consume_all = RobotOrder::select(DB::raw('SUM(price) as value'))
                            ->where('user_id', $id)
                            ->get();

        $consume_month = RobotOrder::select(DB::raw('SUM(price) as value'))
                            ->where('user_id', $id)
                            ->whereBetween('pay_time', [$start_time, $end_time])
                            ->get();

        return view('userorderhistory')
                ->with(['orders' => $orders,
                        'user_id' => $id,
                        'consume_all' => $consume_all,
                        'consume_month' => $consume_month
                    ]);
    }

    /**
     * 单个用户的社交历史
     * @method showSocialHistory
     * @return [type]            [description]
     */
    public function showSocialHistory()
    {
        # code...
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

        return $active ? 0 : 1;
    }

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
        $data['todayCountOrder'] = RobotOrder::whereBetween('pay_time', [$today_carbon_start, $today_carbon_end])->count();    // 今日订单数

        $today_request = new Request(['practice_time' => 30*60, 'date' => 'today']);
        $data['todayCountActive'] = self::activeUser($today_request);    // 今日活跃用户数(机器人使用时长30分钟以上)

        /**
         * 本月的统计结果
         */
         $month_carbon_start = Carbon::now()->startOfMonth();
         $month_carbon_end =  Carbon::now()->endOfMonth();
        //  $data['countStudents'] = StudentUser::count();  // 用户数
         $data['monthCountAdd'] = StudentUser::whereBetween('regdate', [$month_carbon_start, $month_carbon_end])->count();   // 今日增加用户数
         $data['monthCountUsed'] = StudentUser::whereBetween('lastlogin', [$month_carbon_start, $month_carbon_end])->count(); // 今日使用用户数
         $data['monthCountOrder'] = RobotOrder::whereBetween('pay_time', [$month_carbon_start, $month_carbon_end])->count();    // 今日订单数

         $month_request = new Request(['practice_time' => 30*60*60, 'date' => 'month']);
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
         $data['quarterCountOrder'] = RobotOrder::whereBetween('pay_time', [$quarter_carbon_start, $quarter_carbon_end])->count();    // 今日订单数

         $quarter_request = new Request(['practice_time' => 30*60*60, 'date' => 'quarter']);
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
         $data['yearCountOrder'] = RobotOrder::whereBetween('pay_time', [$year_carbon_start, $year_carbon_end])->count();    // 今日订单数

         $year_request = new Request(['practice_time' => 30*60*60, 'date' => 'year']);
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
        $practice = $request->get('practice_time');
        $order  = $request->get('order');
        $countTodayActive = StudentUser::whereHas('practice', function ($query) use ($practice, $date_start, $date_end)  {
            $query->whereBetween('practice_date', [$date_start, $date_end])
                    ->groupby('practice.uid')
                    ->havingRaw("SUM(practice_time) > $practice");
        });
            if ($order) {
                $countTodayActive = $countTodayActive->has('robot_orders');
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
        $practice_time = Request::get('practice_time');
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
        $play_records = \App\Practice::with(['music' => function ($query) {
            $query->withTrashed();
        }])->get();

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

    /**
     * 锁定选中的用户
     * @method lockUsers
     * @param  Request   $request [description]
     * @return [type]             [description]
     */
    public function lockUsers(Request $request)
    {
        $ids =  $request->get('ids');
        foreach ($ids as $id) {
            $user = StudentUser::find($id);
            $user->isactive = 0;
            $result[] = $user->save();
        }
        // 合并数组中的重复值
        $unique_result = array_unique($result);

        // 如果数组中有且只有true,则操作全部成功
        if (in_array('true', $unique_result) && count($unique_result) == 1) {
            $data['status'] = true;
        } else {
            $data['status'] = false;
        }
        return $data;
    }

    /**
     * 解锁选中的用户
     * @method unlockUsers
     * @param  Request   $request [description]
     * @return [type]             [description]
     */
    public function unlockUsers(Request $request)
    {
        $ids =  $request->get('ids');
        foreach ($ids as $id) {
            $user = StudentUser::find($id);
            $user->isactive = 1;
            $result[] = $user->save();
        }
        // 合并数组中的重复值
        $unique_result = array_unique($result);

        // 如果数组中有且只有true,则操作全部成功
        if (in_array('true', $unique_result) && count($unique_result) == 1) {
            $data['status'] = true;
        } else {
            $data['status'] = false;
        }
        return $data;
    }

    /**
     * 通知选中的用户
     * @method notifyUsers
     * @param  Request     $request [description]
     * @return Json                 [description]
     */
    public function notifyUsers(Request $request)
    {
        $message = $request->get('message');
        $ids = $request->get('user_id');
        foreach ($ids as $id) {
            $notification = new Notification();
            $notification->user_id = $id;
            $notification->message = $message;
            $result[] = $notification->save();
        }
        $unique_result = array_unique($result);
        if (in_array('false', $unique_result)) {
            $data['status'] = false;
            $data['errMsg'] = '通知失败';
        } else {
            $data['status'] = true;
        }
        return $data;
    }

    /**
     * 成绩报告
     * @method recordReport
     * @param  integer       $id [description]
     * @return [type]           [description]
     */
    public function recordReport($id)
    {
        /**
         * 今日累计练习时长
         */
        //  DB::connection()->enableQueryLog();
        $start_time = Carbon::now('Asia/ShangHai')->startOfDay()->toDateTimeString();
        $end_time   = Carbon::now('Asia/ShangHai')->endOfDay()->toDateTimeString();
        $duration_today =  Practice::select(DB::raw('SUM(practice_time) as value'))
                            ->whereBetween('practice_date', [$start_time, $end_time])
                            ->where('uid', $id)
                            ->groupBy('uid')
                            ->first();
        // var_dump(DB::getQueryLog());
        // 格式化成 HH:MM:SS
        if (!empty($duration_today)) {
            $duration_today = gmstrftime('%H:%M:%S', $duration_today->value);
        }else {
            $duration_today = 0;
        }

        /**
         * 今日累计练习曲目数量
         */
         $count_today =  Practice::select('music_id')
                            ->whereBetween('practice_date', [$start_time, $end_time])
                            ->where('uid', $id)
                            ->groupBy('music_id')
                            ->distinct()
                            ->get();
        $count_today = count($count_today);

        /**
         * 日期字符串
         */
        $date_string = Carbon::now()->toDateString();

        /**
         * 弹奏记录列表
         */
         $records = Practice::with('music')
                            ->whereBetween('practice_date', [$start_time, $end_time])
                            ->where('uid', $id)
                            ->get();

        /**
         * 绘制图表所需数据
         */
        $text_data = Practice::with('music')
                            ->select('music_id', DB::raw('SUM(practice_time) as one_music_duration'))
                            ->whereBetween('practice_date', [$start_time, $end_time])
                            ->where('uid', $id)
                            ->groupBy('music_id')
                            ->get();

        $colors = ['#E76543', '#4A8EB6', '#8B3A8B', '#53B657', '#FDBD1A', '#FD341C'];
        foreach ($text_data as $v) {
            $temp['value'] = $v->one_music_duration;
            $temp['color'] = array_shift($colors);
            $v->hex = $temp['color'];
            $char_data[] = $temp;
        }

        $rating_data = Practice::select('rating', DB::raw('COUNT(*) as count'))
                                ->whereBetween('practice_date', [$start_time, $end_time])
                                ->where('uid', $id)
                                ->whereNotNull('rating')
                                ->groupBy('rating')
                                ->orderBy('rating')
                                ->get();
        $colors1 = ['#E76543', '#4A8EB6', '#8B3A8B', '#53B657', '#FDBD1A', '#FD341C'];
        $chart_rating = [];
        foreach ($rating_data as $v) {
            $temp1['value'] = $v->rating;
            $temp1['color'] = $colors1[$v->rating];
            $chart_rating[] = $temp1;
        }
        // return $duration_today;
        return view('recordReport')->with(['duration_today' => $duration_today,
                                            'count_today' => $count_today,
                                            'date_string' => $date_string,
                                            'records' => $records,
                                            'text_data' => $text_data,
                                            'id' => $id,
                                            'chart_rating' => $chart_rating]);
    }


    public function recordReportChart($id)
    {
        /**
         * 绘制图表所需数据
         */
         $start_time = Carbon::now('Asia/ShangHai')->startOfDay()->toDateTimeString();
         $end_time   = Carbon::now('Asia/ShangHai')->endOfDay()->toDateTimeString();
         $text_data = Practice::with('music')
                            ->select('music_id', 'rating', DB::raw('SUM(practice_time) as one_music_duration'))
                            ->whereBetween('practice_date', [$start_time, $end_time])
                            ->where('uid', $id)
                            ->groupBy('music_id')
                            ->get();

        $rating_data = Practice::select('rating', DB::raw('COUNT(*) as count'))
                                ->whereBetween('practice_date', [$start_time, $end_time])
                                ->where('uid', $id)
                                ->whereNotNull('rating')
                                ->groupBy('rating')
                                ->orderBy('rating')
                                ->get();

         $colors = ['#E76543', '#4A8EB6', '#8B3A8B', '#53B657', '#FDBD1A'];
         foreach ($text_data as $k => $v) {
            $temp['value'] = $v->one_music_duration;
            $temp['color'] = $colors[$k];
            $data[] = $temp;
         }

         $colors1 = ['#E76543', '#4A8EB6', '#8B3A8B', '#53B657', '#FDBD1A', '#FD341C'];
         foreach ($rating_data as $v) {
             $temp1['value'] = $v->count;
             $temp1['color'] = $colors1[$v->rating];
             $data1[] = $temp1;
         }
         $all_data['data'] = $data;
         $all_data['data1'] = $data1;
         return $all_data;
    }
}
