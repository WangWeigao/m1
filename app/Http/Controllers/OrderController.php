<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Order;

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
        $orders = Order::where('submit_time', '>=', $from_time)
                       ->where('submit_time', '<=', $to_time)
                       ->get();

        return $orders;
    }
}
