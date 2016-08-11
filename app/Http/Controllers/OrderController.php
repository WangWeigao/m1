<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Order;
use App\RobotOrder;
use DB;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 按时间跨度查询订单
     * @method getOrders
     * @param  Request          $request 用户提交的数据
     * @return Array(Json)               订单信息
     */
    public function index(Request $request)
    {
        /**
         * 视图中用于分页链接的参数数组
         * @var [type]
         */
        $order_num_or_username = $request->get('order_num_or_username');
        // $order_type            = $request->get('order_type');
        // $vendor                = $request->get('vendor');
        // $order_status          = $request->get('order_status');


        /**
         * 按 订单号/用户名 进行查询
         */
         if (isset($order_num_or_username)) {
             if (empty($order_num_or_username)) {

                 return view('order')->with(['orders' => [],
                                             'order_num_or_username' => '']);
             }else {
                 $orders =  DB::table('robot_orders')
                 ->join('users', 'robot_orders.user_id', '=', 'users.uid')
                 ->where('robot_orders.id', '=', $order_num_or_username)
                 ->orWhere('users.nickname', 'like', "%$order_num_or_username%")
                 ->paginate(10);

                 return view('order')->with('orders', $orders)
                                     ->withInput($request->all());
             }
        }

        /**
         * 订单类型
         * @var int
         */
        $order_type = $request->get('order_type', '');

        /**
         * 发货商
         * @var int
         */
        $vendor = $request->get('vendor', '');

        /**
         * 订单状态
         * @var int
         */
        $order_status = $request->get('order_status', '');

        /**
         * 查询从这个时间开始查询订单
         * 以订单提交时间为准(pay_time字段)
         */
        $from_time = $request->get('from_time', '');

        /**
         * 查询到这个时间截止的订单
         * 以订单提交时间为止(pay_time字段)
         */
        $to_time = $request->get('to_time', '');

        /**
         * 如果没有查询条件，返回空array
         */
        // if (empty($order_num_or_username) && empty($order_type)
        //     && empty($vendor) && empty($order_status)
        //     && empty($from_time)) {
        //     return view('order')->with(['orders' => array(),
        //                                 'is_start' => true]);
        // }


        $orders = DB::table('robot_orders')
                    ->join('users', 'robot_orders.user_id', '=', 'users.uid')
                    ->select('robot_orders.*', 'users.nickname',
                             'users.account_grade', 'account_end_at');

        /**
         * 按时间跨度查询订单
         */
        if (!empty($from_time) && !empty($to_time)) {
            $orders->whereBetween('robot_orders.pay_time', [$from_time, $to_time]);
        }

        /**
         * 按订单类型查询
         * 存储变量作为view中分页链接的参数
         */
        if (!empty($order_type)) {
            $query_string = array_merge(['order_type' => $order_type]);
            $orders->where('users.account_grade', $order_type);
        }

        /**
         * 按供货商查询
         * 存储变量作为view中分页链接的参数
         */
        if (!empty($vendor)) {
            $query_string = array_merge(['vendor' => $vendor]);
            $orders->where('robot_orders.channel', $vendor);
        }

        /**
         * 按订单状态查询
         * 存储变量作为view中分页链接的参数
         */
        if (!empty($order_status)) {
            $orders->where('robot_orders.status', $order_status);
        }

        $orders = $orders->orderBy('pay_time', 'desc')
                         ->paginate(10)
                         ->appends($request->all());

        return view('order')->with('orders', $orders)
                            ->withInput($request->all());
    }


    /**
     * 锁定订单
     * 由于数据库表设计时没有考虑此种情况, 暂时无法实现锁定订单功能
     * @method lockOrder
     * @param  [type]    $id [description]
     * @return [type]        [description]
     */
    public function lockOrder($id)
    {
        //获取用户激活状态
        $active = Order::where('oid', $id)->first()->isactive;

        /**
         * 判断用户是否锁定, 以执行相反操作
         */
        if ($active) {
            //取消激活状态(锁定)
            $result = Order::where('oid', $id)->update(['isactive'=>0]);
        }else {
            //激活(解锁)
            $result = Order::where('oid', $id)->update(['isactive'=>1]);
        }

        return $active;
    }


    /**
     * 订单详细信息
     * @method show
     * @param  [integer]          $id [订单ID]
     * @return [Json]                 [单个订单的详细信息]
     */
    public function show($id)
    {
        $orderInfo = Order::find($id);

        // 将"上门方式"字段值替换成可识别的内容
        switch ($orderInfo->method) {
            case '1':
                $vlaue->method = '老师上门';
                break;
            case '2':
                $orderInfo->method = '学生上门';
                break;
            case '3':
                $orderInfo->method = '可协商';
                break;
            default:
                $orderInfo->method = '数据错误';
                break;
        }

        // 将订单状态替换成可识别的内容
        switch ($orderInfo->status) {
            case '0':
                $orderInfo->status = '未支付';
                break;
            case '1':
                $orderInfo->status = '待上课';
                break;
            case '2':
                $orderInfo->status = '已完成';
                break;
            case '3':
                $orderInfo->status = '已评价';
                break;
            default:
                $orderInfo->status = '数据错误';
                break;
        }
        // return view('orderdetail')->with('orderInfo', $orderInfo);
        return $orderInfo;
    }

    /**
     * 订单统计
     * @method statistics
     * @return [type]     [description]
     */
    public function statistics()
    {
        $nums = RobotOrder::select(DB::raw('COUNT(*) as counts'))
                            ->get()[0];
        $pay_nums = RobotOrder::select(DB::raw('COUNT(*) as counts'))
                            ->where('status', 3)
                            ->get()[0];
        return view('orderStatistics')->with(['nums' => $nums,
                                              'pay_nums' => $pay_nums]);
    }

    /**
     * 获取按 日/月/季度/年 的统计结果数组
     * @method tendency
     * @param  Request  $request [description]
     * @return [type]            [description]
     */
    public function tendency(Request $request)
    {
        $period = $request->get('period');
        switch ($period) {
            case 'today':
                $dataValue = $this->getDayTendency();
                break;
            case 'month':
                $dataValue = $this->getMonthTendency();
                break;
            case 'quarter':
                $dataValue = $this->getQuarterTendency();
                break;
            case 'year':
                $dataValue = $this->getYearTendency();
                break;

            default:
                # code...
                break;
        }
        return $dataValue;

    }

    /**
     * 获取按天的统计结果
     * @method getDayTendency
     * @param  Carbon         $carbon [description]
     * @return [type]                 [description]
     */
    public function getDayTendency()
    {
        $dt = Carbon::now('Asia/ShangHai');
        $length = $dt->hour;
        for ($i=0; $i <= $length; $i++) {
            $start       = $dt->hour($i)->minute(0)->second(1)->toDateTimeString();
            $end         = $dt->hour($i)->minute(59)->second(59)->toDateTimeString();
            $dataValue[] = RobotOrder::whereBetween('pay_time', [$start, $end])->count();
        }
        return $dataValue;
    }

    /**
     * 获取按月的统计结果
     * @method getMonthTendency
     * @return [type]           [description]
     */
    public function getMonthTendency()
    {
        $dt = Carbon::now('Asia/ShangHai');
        $length = $dt->day;
        for ($i=1; $i <= $length; $i++) {
            $start       = $dt->day($i)->startOfDay()->toDateTimeString();
            $end         = $dt->day($i)->endOfDay()->toDateTimeString();
            $dataValue[] = RobotOrder::whereBetween('pay_time', [$start, $end])->count();
        }
        return $dataValue;
    }

    /**
     * 按季度取得统计结果
     * @method getQuarterTendency
     * @return [type]             [description]
     */
    public function getQuarterTendency()
    {
        $dt     = Carbon::now('Asia/ShangHai');
        $length = ($dt->month)%3 ? ($dt->month)%3 : 3;
        // return $length;
        $dataValue = [];
        for ($i=$dt->quarter + 1; $i <=$dt->month ; $i++) {
            $start       = Carbon::now('Asia/ShangHai')->month($i)->startOfMonth();
            $end         = Carbon::now('Asia/ShangHai')->month($i)->endOfMonth();
            $dataValue[] = RobotOrder::whereBetween('pay_time', [$start, $end])->count();
        }
        return $dataValue;
    }

    /**
     * 按年取得统计结果
     * @method getYearTendency
     * @return [type]          [description]
     */
    public function getYearTendency()
    {
        $dt     = Carbon::now('Asia/ShangHai');
        $length = $dt->month;
        DB::connection()->enableQueryLog();
        for ($i=1; $i<=$length; $i++) {
            $start       = Carbon::now('Asia/ShangHai')->month($i)->startOfMonth()->toDateTimeString();
            $end         = Carbon::now('Asia/ShangHai')->month($i)->endOfMonth()->toDateTimeString();
            $dataValue[] = RobotOrder::whereBetween('pay_time', [$start, $end])->count();
        }
        return $dataValue;
    }

}
