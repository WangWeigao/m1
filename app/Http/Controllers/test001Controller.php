<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Redis;
use DB;
use App\Music;
use App\Http\Models\Midi\MidiDuration;

class test001Controller extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /**
         * 将practice表中需要的数据写入Redis
         */
        // 取出数据
        $play_records = DB::table('practice')
                            ->select('uid', 'practice_time', 'practice_date')
                            ->get();
        // 格式化数据
        foreach ($play_records as $v ) {
            Redis::incrby(
                $v->uid . '.' . Carbon::parse($v->practice_date)->year . '.' . Carbon::parse($v->practice_date)->month,
                $v->practice_time
            );
        }

    }


    /**
     * 给已经添加的midi文件添加播放时长(duration字段)
     */
    public function addDuration()
    {
        $midis = range(199, 245);
        foreach ($midis as $v) {
            $file = public_path() . DIRECTORY_SEPARATOR . 'midis' . DIRECTORY_SEPARATOR . $v . '.mid';
            if (file_exists($file)) {
                $music = Music::find($v);
                if (!is_null($music)) {
                    $midi = new MidiDuration();
                    $midi->importMid($file);
                    $music->duration = (int)ceil($midi->getDuration());
                    $music->save();
                }
            }
        }
    }

    public function test()
    {
        return view('test');
    }
}
