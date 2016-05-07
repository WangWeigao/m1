<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Redis;
use DB;

class test001Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // /**
        //  * 将practice表中需要的数据写入Redis
        //  */
        // // 取出数据
        // $play_records = DB::table('practice')
        //                     ->select('uid', 'practice_time', 'practice_date')
        //                     ->get();
        // // 格式化数据
        // foreach ($play_records as $v ) {
        //     Redis::incrby(
        //         $v->uid . '.' . Carbon::parse($v->practice_date)->year . '.' . Carbon::parse($v->practice_date)->month,
        //         $v->practice_time
        //     );
        // }
        // 取得当前年月，便于设置redis的key
        $year  = Carbon::now()->year;
        $month = Carbon::now()->month;

        /**
         * 取出所有当前月份的key
         */
        $month_arr = Redis::keys("*.$year.$month");
        foreach ($month_arr as $v) {
            $month_arr_id[] = explode('.', $v)[0];
        }


        $month_pre_arr = Redis::keys("*.$year." . $month-1);
        foreach ($month_pre_arr as $v) {
            $month_pre_arr_id[] = explode('.', $v)[0];
        }

        $month_all = array_unique(array_merge($month_arr_id, $month_pre_arr_id));
        foreach ($month_all as $v) {
            if (Redis::get("$v.$year.$month") > Redis::get("$v.$year." . $month-1)) {
                $result[] = $v;
            }
        }
        return $result;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
