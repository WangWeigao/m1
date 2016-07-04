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
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function getUserList(Request $request)
    {
        DB::connection()->enableQueryLog();
        $keyword                = trim($request->get('keyword', ''));
        $province               = $request->get('province', 0);
        $thirty_days_duration   = $request->get('thirty_days_duration', '');
        $payment_status         = $request->get('payment_status', '');
        $thirty_days_boot_times = $request->get('thirty_days_boot_times', '');


        $users = StudentUser::select('users.uid', 'cellphone', 'nickname', 'regdate', 'province_id', 'boot_times', 'paid', 'payable');

         // 按用户名关键字查询
        if (!empty($keyword)) {
            $users->where('nickname', 'like', "%$keyword%");
        }


        // 按"地域"查询用户
        if (!empty($province)) {
            $users->where('province_id', $province);
        }

        // 按"总练习时间"分组
        $users->leftjoin('practice', function($join) use ($thirty_days_duration, $payment_status) {
                    $join->on('users.uid', '=', 'practice.uid');
                    if ($thirty_days_duration == 'large30min' || $thirty_days_duration == 'less30min'
                          || $payment_status == 'non-payment' || $payment_status == 'do_not_pay') {     // 下面相关变量的判断都需要记录在30天以内
                        $join->where('practice_date', '<', 'users.regdate + 30*24*60*60');              // 只保留30之内的练习记录
                    }
                })
              ->groupBy('users.uid')
              ->addSelect(DB::raw('SUM(practice.practice_time) as practice_time_sum'));


        // 按"近30天使用时间"查询
        if ($thirty_days_duration == 'large30min') {
            $users->havingRaw('SUM(practice_time) >= 30*60');     // 总练习时间>=30分钟
        } elseif ($thirty_days_duration == 'less30min') {
            $users->havingRaw('SUM(practice_time) < 30*60');      // 总练习时间<30分钟
        }

        // 按结算状态查询
        if (!empty($payment_status)) {
            switch ($payment_status) {
                case 'non-payment': // 未支付且满足支付的条件
                    $users->where('paid', 0)    // 未支付
                          ->where('boot_times', '>=', 2)    // 启动次数 > 2
                          ->havingRaw('SUM(practice_time) >=' . 30*60); // 练习时间 > 30min
                    break;

                case 'paid':
                    $users->where('paid', 1);
                    break;

                case 'do_not_pay':  // 不满足可支付的条件
                    $users->where('paid', 0)->where(function ($query) {
                        $query->havingRaw('SUM(practice.practice_time)<' . 30*60)
                              ->orWhere('boot_times', '<', 2);
                    });

                    break;

                default:
                    # code...
                    break;
            }
        }

        // 按"近30天启动次数"查询
        if (!empty($thirty_days_boot_times)) {
            switch ($thirty_days_boot_times) {
                case 'more2times':
                    $users->where('boot_times', '>', 2);
                    break;
                case 'less2times':
                    $users->where('boot_times', '<=', 2);
                    break;
                default:
                    # code...
                    break;
            }
        }
        // $users = $users->get();
        // var_dump(DB::getQueryLog());
        // return $users;
        $users = $users->paginate(10)->appends($request->all());
        return view('invite_new_users')->with('users', $users)->withInput($request->all());
    }


    public function updateNewUserPaid(StudentUser $id)
    {
        $id->paid = 1;
        $status   = $id->save();

        if ($status) {
            $data['status'] = 0;
        } else {
            $data['status'] = 10000;
            $data['msg'] = '结算失败';
        }

        return $data;
    }


    public function updateMultiNewUserPaid(Request $request)
    {
        $ids = $request->get('ids', []);
        foreach ($ids as $id) {
            $user = StudentUser::find($id);
            if (!($user->save())) {
                $data['status'] = 10000;
                $data['msg'] = '结算失败';
                return $data;
            }
        }
        $data['status'] = 0;
        return $data;
    }
}
