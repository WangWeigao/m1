<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\StudentUser;
use App\RobotOrder;
use Carbon\Carbon;
use DB;
class InviteNewUserController extends Controller
{
    public function getUserList(Request $request)
    {
        DB::connection()->enableQueryLog();
        $keyword = trim($request->get('keyword', ''));
        $province = $request->get('province', 0);
        $thirty_days_duration = $request->get('thirty_days_duration', '');
        $payment_status = $request->get('payment_status', '');

        $orders = RobotOrder::select('id', DB::raw('robot_orders.user_id'), 'paid', 'price');

         // 按用户名关键字查询
        if (!empty($keyword)) {
            $orders->whereHas('user', function($query) use ($keyword) {
                $query->where('nickname', 'like', "%$keyword%");
            });
        }

        // 附加用户表
        $orders->with(['user' => function($query) {
            // $query->select('id', 'user_id', 'type', 'price', 'paid');
            $query->select('uid', 'cellphone', 'nickname', 'regdate', 'province_id', 'boot_times');
        }]);

        // 按近30天使用时间查询
        if ($payment_status == 'all') {
            if ($thirty_days_duration == 'large30min') {
                $orders->leftjoin('practice', function($join) {
                    $join->on('robot_orders.user_id', '=', 'practice.uid')
                         ->where('practice_date', '<', 'users.regdate + 30*24*60*60');
                })
                       ->groupBy('robot_orders.user_id')
                       ->havingRaw('SUM(practice_time) >= ' . 30*60);    // 30分钟及以上
            } elseif ($thirty_days_duration == 'less30min') {
                $orders->leftjoin('practice', 'robot_orders.user_id', '=', 'practice.uid')
                       ->groupBy('robot_orders.user_id')
                       ->havingRaw('SUM(practice_time) <' . 30*60);    // 30分钟及以下
            } else {
                # code...                                                // 不限
            }
        }

        // 按结算状态查询
        if (!empty($payment_status)) {
            switch ($payment_status) {
                case 'non-payment':
                    $orders->where('boot_times', '>', 2)->whereHas('orders', function($query) {
                            $query->where('paid', 0);
                        })->join('practice', 'orders.uid', '=', 'practice.uid')
                          ->groupBy('orders.uid')
                          ->havingRaw('SUM(practice_date) >' . 30*60);
                    break;

                case 'paid':
                    $orders->whereHas('orders', function($query) {
                        $query->where('paid', 1);
                    });
                    break;

                case 'do_not_pay':
                    $orders->where('boot_times', '<=', 2)->orWhere(function($query) {
                        $query->join('practice', 'orders.uid', '=', 'practice.uid')
                              ->groupBy('orders.uid')
                              ->havingRaw('SUM(practice_date) <=' . 30*60);
                    });

                    break;

                default:
                    # code...
                    break;
            }
        }

        $orders = $orders->paginate(10);
        return view('invite_new_users')->with('orders', $orders)->withInput($request->all());
    }
}
