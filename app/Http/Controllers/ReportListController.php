<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;
use App\Http\Models\TMEmail;
use App\Practice;
use Carbon\Carbon;
use DB;
/**
 * 定时推送成绩报告
 */
class ReportListController extends Controller
{
    /**
     * 认证用户
     * @method __construct
     */
    function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 发送成绩报告
     * @method sendReport
     * @return [type]     [description]
     */
    public function sendReport()
    {
        $id = 468;
        $user = \App\StudentUser::findOrFail($id);
        $job = (new \App\Jobs\SendReminderEmail($user));
        $this->dispatch($job);
        //
        // /**
        //  * 今日累计练习时长
        //  */
        // //  DB::connection()->enableQueryLog();
        // $start_time = Carbon::now('Asia/ShangHai')->startOfDay()->toDateTimeString();
        // $end_time   = Carbon::now('Asia/ShangHai')->endOfDay()->toDateTimeString();
        // $duration_today =  Practice::select(DB::raw('SUM(practice_time) as value'))
        //                     ->whereBetween('practice_date', [$start_time, $end_time])
        //                     ->where('uid', $id)
        //                     ->groupBy('uid')
        //                     ->first();
        // // var_dump(DB::getQueryLog());
        // // 格式化成 HH:MM:SS
        // if (!empty($duration_today)) {
        //     $duration_today = gmstrftime('%H:%M:%S', $duration_today->value);
        // }else {
        //     $duration_today = 0;
        // }
        //
        // /**
        //  * 今日累计练习曲目数量
        //  */
        //  $count_today =  Practice::select('music_id')
        //                     ->whereBetween('practice_date', [$start_time, $end_time])
        //                     ->where('uid', $id)
        //                     ->groupBy('music_id')
        //                     ->distinct()
        //                     ->get();
        // $count_today = count($count_today);
        //
        // /**
        //  * 日期字符串
        //  */
        // $date_string = Carbon::now('Asia/ShangHai')->toDateString();
        //
        // /**
        //  * 弹奏记录列表
        //  */
        //  $records = Practice::with('music')
        //                     ->whereBetween('practice_date', [$start_time, $end_time])
        //                     ->where('uid', $id)
        //                     ->get();
        //
        // /**
        //  * 绘制图表所需数据
        //  */
        // $text_data = Practice::with('music')
        //                     ->select('music_id', DB::raw('SUM(practice_time) as one_music_duration'))
        //                     ->whereBetween('practice_date', [$start_time, $end_time])
        //                     ->where('uid', $id)
        //                     ->groupBy('music_id')
        //                     ->get();
        //
        // $colors = ['#E76543', '#4A8EB6', '#8B3A8B', '#53B657', '#FDBD1A', '#FD341C'];
        // foreach ($text_data as $v) {
        //     $temp['value'] = $v->one_music_duration;
        //     $temp['color'] = array_shift($colors);
        //     $v->hex = $temp['color'];
        //     $char_data[] = $temp;
        // }
        //
        // $rating_data = Practice::select('rating', DB::raw('COUNT(*) as count'))
        //                         ->whereBetween('practice_date', [$start_time, $end_time])
        //                         ->where('uid', $id)
        //                         ->whereNotNull('rating')
        //                         ->groupBy('rating')
        //                         ->orderBy('rating')
        //                         ->get();
        // $colors1 = ['#E76543', '#4A8EB6', '#8B3A8B', '#53B657', '#FDBD1A', '#FD341C'];
        // $chart_rating = [];
        // foreach ($rating_data as $v) {
        //     $temp1['value'] = $v->rating;
        //     $temp1['color'] = $colors1[(ceil($v->rating)/2)];
        //     $chart_rating[] = $temp1;
        // }
        // $result['duration_today'] = $duration_today;
        // $result['count_today'] = $count_today;
        // $result['date_string'] = $date_string;
        // $result['records'] = $records;
        // $result['text_data'] = $text_data;
        // $result['id'] = $id;
        // $result['chart_rating'] = $chart_rating;
        //
        //
        // $tm_email = new TMEmail;
        // $tm_email->from = 'emailuser001@163.com';
        // $tm_email->to = 'emailuser001@163.com';
        // $tm_email->subject = '测试邮件' . mt_rand();
        // Mail::send('emails.recordReport', $result, function ($m) use ($tm_email) {
        //     $m->from($tm_email->from, '音熊');
        //     $m->to($tm_email->to);
        //     $m->subject($tm_email->subject);
        // });
    }
}
