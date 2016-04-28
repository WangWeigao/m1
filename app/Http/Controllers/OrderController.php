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
         * 查询从这个时间开始查询订单
         * 以订单提交时间为准(submit_time字段)
         */
        $from_time = $request->get('from_time');

        /**
         * 查询到这个时间截止的订单
         * 以订单提交时间为止(submit_time字段)
         */
        $to_time = $request->get('to_time');

        /**
         * 按时间跨度查询订单
         */
        $orders = RobotOrder::with('user')->whereBetween('pay_time', [$from_time, $to_time])->paginate();
                    //    ->paginate(10);

// return $orders;
        /**
         * 携带 from_time 和 to_time 以便进行分页, 点击其它页娄时将数据带到跳转的页面
         */
        return view('order')->with(['orders' => $orders, 'from_time' => $from_time, 'to_time' => $to_time]);
        // return view('order')->withInput();
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
                            ->where('type', 4)
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
        $length = ($dt->month)%3;
        for ($i=(floor(($dt->month)/3)*3+1); $i <=$dt->month ; $i++) {
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
