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
    /**
     * 给已经添加的midi文件添加播放时长(duration字段)
     */
    public function getTrackCount()
    {
        $midis = range(199, 245);
        foreach ($midis as $v) {
            $file = public_path() . DIRECTORY_SEPARATOR . 'midis' . DIRECTORY_SEPARATOR . $v . '.mid';
            if (file_exists($file)) {
                $music = Music::find($v);
                if (!is_null($music)) {
                    $midi = new MidiDuration();
                    $midi->importMid($file);
                    $music->getNoteList[] = $midi->getNoteList();
                    echo $music->id . '-' . count($music->getNoteList);
                    // echo $music->id . '-' . $music->track;
                    echo "\n";
                    // $music->save();
                }
            }
        }
    }

    public function test()
    {
        return view('test');
    }


    public function getPic(Request $request)
    {
        $id = 468;
        // $id = $request->get('id');
        $user = \App\StudentUser::findOrFail($id);


        /**
         * 今日练习的所有曲目
         */
        $start_time = Carbon::now('Asia/ShangHai')->subYear();
        $end_time   = Carbon::now('Asia/ShangHai');
        $musics     = \App\Practice::with(['music' => function($query) {
                                    $query->select('id', 'name');
                                }])
                                ->select(DB::raw('SUM(practice_time) as sum_time'), 'music_id')
                                ->where('uid', $id)
                                ->whereBetween('practice_date', [$start_time, $end_time])
                                ->groupBy('music_id')
                                ->get();
        foreach ($musics as $v) {
            $data_arr[] = $v->sum_time;
            $lab_arr[]  = $v->music->name;
        }
        $pic_name = $id . '-' . time() . '-' .mt_rand() . '.png';
        return $this->drawChart($data_arr, $lab_arr, $pic_name);
    }


    /**
     * 绘制图表并生成图片
     * @method drawChart
     * @return [type]    [description]
     */
    protected function drawChart($data_arr, $lab_arr, $pic_name)
    {
        /* pChart library inclusions */
        include("libs/pChart2.1.4/class/pData.class.php");
        include("libs/pChart2.1.4/class/pDraw.class.php");
        include("libs/pChart2.1.4/class/pPie.class.php");
        include("libs/pChart2.1.4/class/pImage.class.php");

        /* pData object creation */
        $MyData = new \pData();

        /* Data definition */
        $MyData->addPoints($data_arr,"Value");

        /* Labels definition */
        $MyData->addPoints($lab_arr,"Legend");
        $MyData->setAbscissa("Legend");

        /* Create the pChart object */
        $myPicture = new \pImage(500,150,$MyData);

        /* Draw a gradient background */
        $myPicture->drawGradientArea(0,0,500,150,DIRECTION_HORIZONTAL,array("StartR"=>220,"StartG"=>220,"StartB"=>220,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>100));

        /* Add a border to the picture */
        // $myPicture->drawRectangle(0,0,399,149,array("R"=>0,"G"=>0,"B"=>0));

        /* Create the pPie object */
        $PieChart = new \pPie($myPicture,$MyData);

        /* Enable shadow computing */
        $myPicture->setShadow(FALSE);

        /* Set the default font properties */
        $myPicture->setFontProperties(array("FontName"=>__DIR__ . "/libs/pChart2.1.4/fonts/msyh.ttf","FontSize"=>10,"R"=>80,"G"=>80,"B"=>80));

        /* Draw a splitted pie chart */
        $PieChart->draw3DPie(250,100,array("Radius"=>80,"DrawLabels"=>TRUE,"DataGapAngle"=>10,"DataGapRadius"=>6,"Border"=>FALSE));

        /* Render the picture (choose the best way) */
        $myPicture->autoOutput(public_path() . '/pictures/' . $pic_name);
    }

}
