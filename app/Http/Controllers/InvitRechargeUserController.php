<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\RobotOrder;

class InvitRechargeUserController extends Controller
{
    public function getUserList(Request $request)
    {
        $keyword        = $request->get('keyword', '');
        $province       = $request->get('province', '');
        $payment_status = $request->get('payment_status', 'all');

        $orders = RobotOrder::select('id', 'user_id', 'price', 'paid', 'pay_time')
                            ->with(['user' => function ($query) use ($keyword) {
                                $query->select('uid', 'nickname', 'cellphone');
                            }])
                            ->whereHas('user', function ($query) use ($keyword, $province) {
                                // 按用户名查询
                                if (!empty($keyword)) {
                                    $query->where('nickname', 'like', "%$keyword%");
                                }
                                // 按省份查询
                                if (!empty($province)) {
                                    $query->where('province_id', $province);
                                }
                            });


        // 按支付状态查询
        if (!empty($payment_status)) {
            switch ($payment_status) {
                case 'non-payment':
                    $orders->where('paid', 0);
                    break;
                case 'paid':
                    $orders->where('paid', 1);
                    break;

                default:
                    # code...
                    break;
            }
        }

        $orders = $orders->paginate(10)->appends($request->all());
        return view('invite_recharge_users')->with('orders', $orders);
    }


    public function updateUserPaid(RobotOrder $id)
    {
        $id->paid = 1;
        if ($id->save()) {
            $data['status'] = 0;
        } else {
            $data['status'] = 10000;
            $data['msg'] = '结算失败';
        }
        return $data;
    }


    public function updateMultiUserPaid(Request $request)
    {
        $ids = $request->get('ids', []);
        foreach ($ids as $id) {
            $order = RobotOrder::find($id);
            $order->paid = 1;
            $order->save();
            if (!($order->save())) {
                $data['status'] = 10000;
                $data['msg'] = '结算失败';
                return $data;
            }
        }
        $data['status'] = 0;
        return $data;
    }
}
