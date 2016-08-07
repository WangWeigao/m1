<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Music;
use DB;
use App\Instrument;
use App\Press;
use App\Organizer;
use Carbon\Carbon;
use Response;

use \App\Http\Models\Midi\MidiDuration;
class MusicController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /**
         * 取得GET方法传过来的参数
         * @var [type]
         */
        $name       = $request->get('name') or "";
        $instrument = $request->get('instrument') or "";
        $press      = $request->get('press') or 0;
        $category   = $request->get('category') or "";
        $onshelf    = $request->get('onshelf') or "";
        $organizer  = $request->get('organizer') or "";
        $operator   = $request->get('operator') or "";
        $date       = $request->get('date') or "";
        $version    = $request->get('version') or "";
        $level      = $request->get('level') or "";

        // if (empty($name) && empty($instrument) && empty($press)
        //     && empty($category) && empty($onshelf) && empty($organizer)
        //     && empty($operator) && empty($date)) {
        //     return view('music');
        // }
        /**
         * 按传过来的参数不同，组合不同的查询语句
         * @var Music
         */
        $musics = Music::with('instrument')
                        ->with('organizer')
                        ->with('tags')
                        ->with('press')
                        ->with('user')
                        ->with('editor');

        if (!empty($name)) {
            $musics->where('name', 'like', "%$name%")
                   ->orWhere('composer', 'like', "%$name%");
        }
        if (!empty($instrument)) {
            $musics->where('instrument_id', '=', "$instrument");
        }
        if (!empty($press)) {
            $musics->where('press_id', '=', "$press");
        }
        if (!empty($category)) {
            $musics->whereHas('tags', function ($query) use ($category) {
                $query->where('id',"=", "$category");
            });
        }
        if (!empty($onshelf)) {
            $musics->where('onshelf', '=', "$onshelf");
        }
        if (!empty($organizer)) {
            $musics->where('organizer_id', '=', "$organizer");
        }
        if (!empty($operator)) {
            $musics->where('operator', '=', "$operator");
        }
        if (!empty($date)) {
            $date_start = $date . " 00:00:00";
            $date_end = $date . " 23:23:59";
            $musics->whereBetween('created_at', ["$date_start", "$date_end"]);
        }
        if (!empty($version)) {
            $musics->where('version', $version);
        }
        if (!empty($level)) {
            $musics->where('level', $level);
        }

        // $musics = $musics->paginate(10)->appends(
        //                                             ['name'      => $name,
        //                                             'instrument' => $instrument,
        //                                             'press'      => $press,
        //                                             'category'   => $category,
        //                                             'onshelf'    => $onshelf,
        //                                             'organizer'  => $organizer,
        //                                             'operator'   => $operator,
        //                                             'date'       => $date]
        //                                         );
        // $name       = $request->get('name') or "";
        // $instrument = $request->get('instrument') or "";
        // $press      = $request->get('press') or 0;
        // $category   = $request->get('category') or "";
        // $onshelf    = $request->get('onshelf') or "";
        // $organizer  = $request->get('organizer') or "";
        // $operator   = $request->get('operator') or "";
        // $date       = $request->get('date') or "";
        $musics   = $musics->paginate(10)->appends($request->all());
        $versions = Music::select('version')->where('version', '<>', '')->distinct()->get();
        $data_condition = $this->getCondations();
        // return $request->all();
        /**
         * 将结果返回给视图
         */
        return view('music')->with(['musics' => $musics, 'versions' => $versions, 'data_condition' => $data_condition])
                            ->withInput($request->all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('musicadd');
    }

    /**
     * 上传单个midi文件和相关属性
     * @method store
     * @param  Request $request [description]
     * @return [json]           [是否成功]
     */
    public function store(Request $request)
    {
        // return $request->all();
        // return $request->file('midi_file')->getClientOriginalName();
        /**
         * 取得表单中各个项的值
         */
        $name             = $request->get('name') or '';
        $composer         = $request->get('composer') or '';
        $instrument_id    = $request->get('instrument');
        $version          = $request->get('version') or '';
        $press_id         = $request->get('press');
        $operator         = $request->user()->id;
        $organizer_id     = $request->get('organizer') or 0;
        $note_content     = $request->get('note_content') or '';
        $note_operator    = $request->user()->id;
        // $category         = $request->get('category');
        $category         = 2;
        $level            = $request->get('level');
        $section_duration = $request->get('section_duration');
        $track            = $request->get('track');

        // 如果文件存在且上传成功
        if (!($request->hasFile('midi_file') && $request->file('midi_file')->isValid())) {
            $data['status'] = false;
            // 文件上传失败
            $data['errCode'] = 10002;
            return $data;
        }
        if (!empty($name) && !empty($composer)) {
            /**
             * 插入数据
             */
            $music                   = new Music;
            $music->name             = $name;
            $music->composer         = $composer;
            $music->instrument_id    = $instrument_id;
            $music->version          = $version;
            $music->press_id         = $press_id;
            $music->operator         = $operator;
            $music->organizer_id     = $organizer_id;
            $music->note_content     = $note_content;
            $music->note_operator    = $note_operator;
            $music->section_duration = $section_duration;
            $music->track            = $track;
            $music->level            = $level;
            $result                  = $music->save();
            /**
             * 插入乐曲分类标签
             */
            $music->tags()->attach($category);

            /**
             * 保存midi文件
             */
            $id = $music->id;
            // $source_name = $request->get('midi_file');
            // return $source_name;
            $path = public_path() . DIRECTORY_SEPARATOR . 'midis' . DIRECTORY_SEPARATOR;
            $name = $id . '.mid';
            $music->filename = $name;
            $request->file('midi_file')->move($path, $name);
            // 将文件名保存到DB
            $file = $path . $name;
            $midi = new MidiDuration();
            $midi->importMid($file);
            $music->duration = (int)ceil($midi->getDuration());
            $music->save();
            if ($result) {
                $data['status'] = true;
                return $data;
            }
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeCsv(Request $request)
    {
        /**
         * 验证文件是否存在
         */
        if (!$request->hasFile('csv')) {
            // 返回状态
            $data['status'] = 0;

            // 没有上传文件
            $data['errorCode'] = 1001;
            return $data;
        }

        /**
         * 验证文件是否上传成功
         */
        if (!$request->file('csv')->isValid()) {
            // 返回状态
            $data['status'] = 0;

            // 文件上传失败
            $data['errorCode'] = 1002;
            return $data;
        }

        // 取得上传文件
        $upload_file = $request->file('csv');
        // 设置文件名称
        $filename = time() . '-' . mt_rand() . '.csv';
        // 设置存在路径
        $path = public_path() . '/CsvFileForImport/';
        // 将文件存放到指定目录
        $upload_file->move($path, $filename);

        /**
         * 调用函数将数据存入数据库
         * @var boolean
         */
        $request->path = $path;
        $request->filename = $filename;
        $data = $this->music_import_csv($request);
// return $data;
        return view('importcsv')->with('data', $data);

    }

    protected function music_import_csv(Request $request)
    {
        $path = $request->path;
        $filename = $request->filename;
        $file = $path . '/' . $filename;
        $fp = fopen($file, 'r');
        $i = 0;
        // 定义空数组，方便下面使用
        $isUsed_arr = [];
        // 判断文件名是否有重复
        while ($arr = fgetcsv($fp)) {
            $isFree = self::isNoUsedFileName(mb_convert_encoding($arr[7], 'UTF-8', 'GB2312'));

            // 将重复的文件名放入一个数组中
            if (!$isFree) {
                $isUsed_arr[] = mb_convert_encoding($arr[7], 'UTF-8', 'GB2312');
            }
        }
        // 如果存在重复的文件名，则返回
        if (count($isUsed_arr) > 0) {
            $data['status'] = false;
            $data['errMsg'] = $isUsed_arr;
            return $data;
        }

        // 重置文件指针
        rewind($fp);

        while($arr = fgetcsv($fp)) {
            $i++;
            if ($i == 1) {
                continue;
            }
            // 方便后面判断读取了几行

            $music = new Music;
            $music->name = mb_convert_encoding($arr[0], 'UTF-8', 'GB2312');
            // 查询乐曲id
            $instrument = mb_convert_encoding($arr[1], 'UTF-8', 'GB2312');
            $instrument_in_db = Instrument::where('name', '=', $instrument)->first();
            // 如果这个乐器不存在，则先创建
            if (empty($instrument_in_db)) {
                $new_instrument = new Instrument;
                $new_instrument->name = $instrument;
                $new_instrument->save();
                $music->instrument_id = $new_instrument->id;
            }else {
                $music->instrument_id = $instrument_in_db->id;
            }
            // 作曲人
            $music->composer = mb_convert_encoding($arr[2], 'UTF-8', 'GB2312');
            // 版本
            $music->version = mb_convert_encoding($arr[3], 'UTF-8', 'GB2312');
            // 出版社
            $press = mb_convert_encoding($arr[4], 'UTF-8', 'GB2312');
            $press_in_db = Press::where('name', $press)->first();
            // 如果这个出版社不存在，则先创建
            if (empty($press_in_db)) {
                $new_press = new Press;
                $new_press->name = $press;
                $new_press->save();
                $music->press_id = $new_press->id;
            }else {
                $music->press_id = $press_in_db->id;
            }
            // 主办单位
            $organizer = mb_convert_encoding($arr[5], 'UTF-8', 'GB2312');
            $organizer_in_db = Organizer::where('name', $organizer)->first();
            // 如果这个主办机构不存在，则先创建
            if (empty($organizer_in_db)) {
                $new_organizer = new Organizer;
                $new_organizer->name = $organizer;
                $new_organizer->save();
                $music->organizer_id = $new_organizer->id;
            }else {
                $music->organizer_id = $organizer_in_db->id;
            }
            // 操作人
            $music->operator = $request->user()->id;
            // 评论内容
            $note_content = mb_convert_encoding($arr[6], 'UTF-8', 'GB2312');
            if (!empty($note_content)) {
                $music->note_content = $note_content;
                $music->note_operator = $request->user()->id;
            }
            $music->filename = mb_convert_encoding($arr[7], 'UTF-8', 'GB2312');
            $result[] = $music->save();
        }

        if ( $i == 0 || $i == 1 || in_array(false, $result)) {
            $data['status'] = false;
            $data['errMsg'] = '表格中没有有效数据';
        }else {
            $data['status'] = true;
        }
        return $data;
    }

    // 校验文件名是否已被使用
    public function isNoUsedFileName($filename)
    {
        $result = Music::where('filename', '=', $filename)->first();
        return $result ? false : true;
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
        // return $request->all();
        $name             = $request->get('name') or '';
        $composer         = $request->get('composer') or '';
        $instrument_id    = $request->get('instrument');
        $version          = $request->get('version') or '';
        $press_id         = $request->get('press');
        $organizer_id     = $request->get('organizer') or 0;
        $section_duration = $request->get('section_duration');
        $track            = $request->get('track');
        $note_content     = $request->get('notes') or '';
        $note_operator    = $request->user()->id;
        $level            = $request->get('level');
        // return $request->all();
        $music            = Music::find($id);
        if (!empty($name)) {
            $music->name = $name;
        }
        if (!empty($composer)) {
            $music->composer = $composer;
        }
        if (!empty($instrument_id)) {
            $music->instrument_id = $instrument_id;
        }
        if (!empty($version)) {
            $music->version = $version;
        }
        if (!empty($press_id)) {
            $music->press_id = $press_id;
        }
        if (!empty($organizer_id)) {
            $music->organizer_id  = $organizer_id;
        }
        if (!empty($section_duration)) {
            $music->section_duration = $section_duration;
        }
        if (!empty($track)) {
            $music->track = $track;
        }
        if (!empty($note_content)) {
            $music->note_content = $note_content;
            $music->note_operator = $note_operator;
        }
        $category             = $request->get('category');
        $category_old         = $request->get('category_old');
        // if(!empty($category_old)) {
        //     $music->tags()->updateExistingPivot($category_old, ['tag_id' => $category]);
        // }else {
        //     $music->tags()->attach($category);
        // }
        if (!empty($level)) {
            $music->level = $level;
        }
        $music->onshelf = 1;
        $result = $music->save();
        if ($result) {
            $data['status'] = true;
        }else {
            $data['status']  = false;
            $data['errCode'] = 10013;
            $data['errMsg']  = '数据更新失败, 稍候再试吧';
        }
        return $data;
    }

    /**
     * 将"乐曲"上架
     */
    public function putaway($id)
    {
        $music = Music::find($id);
        $music->onshelf = 2;
        $result = $music->save();
        if ($result) {
            $data['status'] = true;
        }else {
            $data['status'] = false;
        }
        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // 删除模型
        $music = Music::find($id);
        $result = $music->delete();
        if ($result) {
            $data['status'] = true;
        }else {
            $data['status'] = false;
        }
        return $data;
    }

    /**
     * 批量乐曲上架
     * @method putawayMany
     * @param  Request     $request [description]
     * @return json                 [description]
     */
    public function putawayMany(Request $request)
    {
        $ids = $request->get('ids');
        foreach ($ids as $id) {
            // echo $id;
            $music = Music::find($id);
            $music->onshelf = 2;
            $result[] = $music->save();
        }
        /**
         * 合并数组中的重复值
         */
        $result_unique = array_unique($result);

        /**
         * 如果合并后的数组中有'true', 并且数组的元素个数为1, 则返回TRUE
         */
        if(in_array(true, $result_unique) && count($result_unique) == 1) {
            $data['status'] = true;
        }else {
            $data['status'] = false;
        }

        return $data;
    }

    public function offshelfMany(Request $request)
    {
        $ids = $request->get('ids');
        foreach ($ids as $id) {
            $music = Music::find($id);
            $result[] = $music->delete();
        }
        /**
         * 合并数组中的重复值
         */
        $result_unique = array_unique($result);

        /**
         * 如果合并后的数组中有'true', 并且数组的元素个数为1, 则返回TRUE
         */
        if(in_array(true, $result_unique) && count($result_unique) == 1) {
            $data['status'] = true;
        }else {
            $data['status'] = false;
        }

        return $data;
    }

    /**
     * 获取不同筛选条件中的值
     * @method getCondations
     * @return [type]        [description]
     */
    public function getCondations()
    {
        $data['instrument'] = Instrument::select('id', 'name')->get();
        $data['press'] = \App\Press::select('id', 'name')->get();
        $data['tag'] = \App\Tag::select('id', 'name')->get();
        // $data['operator'] = \App\User::select('id', 'name')->with('musics')->whereHas('musics', function ($query) {
        //                                                         $query->groupby('operator');
        //                                                     })->groupby('id')->get();
        $data['operator'] = \App\User::select('id', 'name')->whereHas('musics', function ($query) {
                                                                $query->groupby('operator');
                                                            })->groupby('id')->get();
        $data['organizer'] = \App\Organizer::select('id', 'name')->get();
        return $data;
        // $data['status'] = 'sdfsdfsdfsdfsdfsdfsdfdsf';
        // return $data;
    }

    public function musicStatistics()
    {
        $request = new Request(['instrumentValue' => 0]);
        $data = self::musicStatisticsByInstrument($request);
        return view('musicStatistics')->with('data', $data);
    }

    /**
     * 按乐器种类返回统计结果
     * @method musicStatisticsByInstrument
     * @param  Request                     $request [description]
     * @return [json]                               [description]
     */
    public function musicStatisticsByInstrument(Request $request)
    {
        $instrumentValue = $request->get('instrumentValue');
        if ($instrumentValue == 0) {
            $data['allCount']     = Music::count();
            $data['onshelfCount'] = Music::where('onshelf', 2)->count();
            $data['waitForCheck'] = Music::where('onshelf', 1)->count();
            $data['deleteCount']  = Music::onlyTrashed()->count();
            // 业余考级乐曲统计
            $data['amateur_allCount']     = Music::whereHas('tags', function ($query) {$query->where('name', '业余考级');})->count();
            $data['amateur_onshelfCount'] = Music::whereHas('tags', function ($query) {$query->where('name', '业余考级');})->where('onshelf', 2)->count();
            $data['amateur_waitForCheck'] = Music::whereHas('tags', function ($query) {$query->where('name', '业余考级');})->where('onshelf', 1)->count();
            $data['amateur_deleteCount']  = Music::whereHas('tags', function ($query) {$query->where('name', '业余考级');})->onlyTrashed()->count();
            // 专业考级乐曲统计
            $data['pro_allCount']     = Music::whereHas('tags', function ($query) {$query->where('name', '专业考级');})->count();
            $data['pro_onshelfCount'] = Music::whereHas('tags', function ($query) {$query->where('name', '专业考级');})->where('onshelf', 2)->count();
            $data['pro_waitForCheck'] = Music::whereHas('tags', function ($query) {$query->where('name', '专业考级');})->where('onshelf', 1)->count();
            $data['pro_deleteCount']  = Music::whereHas('tags', function ($query) {$query->where('name', '专业考级');})->onlyTrashed()->count();
            // 热门曲目统计
            $data['hot_allCount']     = Music::whereHas('tags', function ($query) {$query->where('name', '热门曲目');})->count();
            $data['hot_onshelfCount'] = Music::whereHas('tags', function ($query) {$query->where('name', '热门曲目');})->where('onshelf', 2)->count();
            $data['hot_waitForCheck'] = Music::whereHas('tags', function ($query) {$query->where('name', '热门曲目');})->where('onshelf', 1)->count();
            $data['hot_deleteCount']  = Music::whereHas('tags', function ($query) {$query->where('name', '热门曲目');})->onlyTrashed()->count();
        }else {
            $data['allCount']     = Music::where('instrument_id', $instrumentValue)->count();
            $data['onshelfCount'] = Music::where('instrument_id', $instrumentValue)->where('onshelf', 2)->count();
            $data['waitForCheck'] = Music::where('instrument_id', $instrumentValue)->where('onshelf', 1)->count();
            $data['deleteCount']  = Music::where('instrument_id', $instrumentValue)->onlyTrashed()->count();
            // 业余考级乐曲统计
            $data['amateur_allCount']     = Music::where('instrument_id', $instrumentValue)->whereHas('tags', function ($query) {$query->where('name', '业余考级');})->count();
            $data['amateur_onshelfCount'] = Music::where('instrument_id', $instrumentValue)->whereHas('tags', function ($query) {$query->where('name', '业余考级');})->where('onshelf', 2)->count();
            $data['amateur_waitForCheck'] = Music::where('instrument_id', $instrumentValue)->whereHas('tags', function ($query) {$query->where('name', '业余考级');})->where('onshelf', 1)->count();
            $data['amateur_deleteCount']  = Music::where('instrument_id', $instrumentValue)->whereHas('tags', function ($query) {$query->where('name', '业余考级');})->onlyTrashed()->count();
            // 专业考级乐曲统计
            $data['pro_allCount']     = Music::where('instrument_id', $instrumentValue)->whereHas('tags', function ($query) {$query->where('name', '专业考级');})->count();
            $data['pro_onshelfCount'] = Music::where('instrument_id', $instrumentValue)->whereHas('tags', function ($query) {$query->where('name', '专业考级');})->where('onshelf', 2)->count();
            $data['pro_waitForCheck'] = Music::where('instrument_id', $instrumentValue)->whereHas('tags', function ($query) {$query->where('name', '专业考级');})->where('onshelf', 1)->count();
            $data['pro_deleteCount']  = Music::where('instrument_id', $instrumentValue)->whereHas('tags', function ($query) {$query->where('name', '专业考级');})->onlyTrashed()->count();
            // 热门曲目统计
            $data['hot_allCount']     = Music::where('instrument_id', $instrumentValue)->whereHas('tags', function ($query) {$query->where('name', '热门曲目');})->count();
            $data['hot_onshelfCount'] = Music::where('instrument_id', $instrumentValue)->whereHas('tags', function ($query) {$query->where('name', '热门曲目');})->where('onshelf', 2)->count();
            $data['hot_waitForCheck'] = Music::where('instrument_id', $instrumentValue)->whereHas('tags', function ($query) {$query->where('name', '热门曲目');})->where('onshelf', 1)->count();
            $data['hot_deleteCount']  = Music::where('instrument_id', $instrumentValue)->whereHas('tags', function ($query) {$query->where('name', '热门曲目');})->onlyTrashed()->count();
        }
        return $data;

    }

    /**
     * 下载mid文件
     * 实现下载的文件显示乐曲名称,而不是实际的文件名
     * @method downloadMusic
     * @param  Request       $request [原文件, 新文件名]
     * @return [?]                 [请求的下载文件]
     */
    public function downloadMusic(Request $request)
    {
        // 真实文件所在的位置
        $path = public_path('midis') ;
        // 第一个参数: 原始文件
        $filename = $path . '/' . $request->get('name');
        // 第二个参数: 新文件名
        $newfilename = $request->get('newname') . '.mid';
        // 第三个参数: 响应头
        $headers = array(
          'Content-Type: audio/mid',
        );

        return Response::download($filename, $newfilename, $headers);
    }
}
