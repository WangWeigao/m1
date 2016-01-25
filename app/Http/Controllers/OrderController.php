<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Order;
use DB;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * 显示订单查询界面
     * @method index
     * @return [type] [description]
     */
    public function index()
    {
        return view('order');
    }


    /**
     * 按时间跨度查询订单
     * @method getOrders
     * @param  Request          $request 用户提交的数据
     * @return Array(Json)               订单信息
     */
    public function getOrders(Request $request)
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
        $orders = Order::whereBetween('submit_time', [$from_time, $to_time])
                       ->paginate(10);
        /**
         * 携带 from_time 和 to_time 以便进行分页, 点击其它页娄时将数据带到跳转的页面
         */
        return view('getorders')->with(['orders' => $orders, 'from_time' => $from_time, 'to_time' => $to_time]);
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
        return 1;
    }


    /**
     * 订单详细信息
     * @method orderDetailInfo
     * @param  [integer]          $id [订单ID]
     * @return [Json]                 [单个订单的详细信息]
     */
    public function orderDetailInfo($id)
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
        return view('orderdetail')->with('orderInfo', $orderInfo);
    }
}
