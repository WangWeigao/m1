<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Music;
use DB;
use App\Instrument;

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

        if (empty($name) && empty($instrument) && empty($press)
            && empty($category) && empty($onshelf) && empty($organizer)
            && empty($operator) && empty($date)) {
            return view('music');
        }
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
            $musics = $musics->where('name', 'like', "%$name%");
        }
        if (!empty($instrument)) {
            $musics = $musics->where('instrument_id', '=', "$instrument");
        }
        if (!empty($press)) {
            $musics = $musics->where('press_id', '=', "$press");
        }
        if (!empty($category)) {
            $musics = $musics->whereHas('tags', function ($query) use ($category) {
                $query->where('id',"=", "$category");
            });
        }
        if (!empty($onshelf)) {
            $musics = $musics->where('onshelf', '=', "$onshelf");
        }
        if (!empty($organizer)) {
            $musics = $musics->where('organizer_id', '=', "$organizer");
        }
        if (!empty($operator)) {
            $musics = $musics->where('operator', '=', "$operator");
        }
        if (!empty($date)) {
            $date_start = $date . " 00:00:00";
            $date_end = $date . " 23:23:59";
            $musics = $musics->whereBetween('created_at', ["$date_start", "$date_end"]);
        }

        $musics = $musics->paginate(10)->appends(
                                                    ['name'      => $name,
                                                    'instrument' => $instrument,
                                                    'press'      => $press,
                                                    'category'   => $category,
                                                    'onshelf'    => $onshelf,
                                                    'organizer'  => $organizer,
                                                    'operator'   => $operator,
                                                    'date'       => $date]
                                                );
        $name       = $request->get('name') or "";
        $instrument = $request->get('instrument') or "";
        $press      = $request->get('press') or 0;
        $category   = $request->get('category') or "";
        $onshelf    = $request->get('onshelf') or "";
        $organizer  = $request->get('organizer') or "";
        $operator   = $request->get('operator') or "";
        $date       = $request->get('date') or "";
        // $musics = Music::find(92)->press;
        // return $musics;

        /**
         * 将结果返回给视图
         */
        return view('music')->with(['musics' => $musics]);
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

    public function store(Request $request)
    {
        // return $request->all();
        /**
         * 取得表单中各个项的值
         */
        $name          = $request->get('name') or '';
        $composer      = $request->get('composer') or '';
        $instrument_id = $request->get('instrument');
        $version       = $request->get('version') or '';
        $press_id      = $request->get('press');
        $operator      = $request->user()->id;
        $organizer_id  = $request->get('organizer') or 0;
        $note_content  = $request->get('note_content') or '';
        $note_operator = $request->user()->id;
        $category      = $request->get('category');

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
            $music = new Music;
            $music->name = $name;
            $music->composer = $composer;
            $music->instrument_id = $instrument_id;
            $music->version = $version;
            $music->press_id = $press_id;
            $music->operator = $operator;
            $music->organizer_id = $organizer_id;
            $music->note_content = $note_content;
            $music->note_operator = $note_operator;
            $result = $music->save();
            /**
             * 插入乐曲分类标签
             */
            $music->tags()->attach($category);

            /**
             * 保存midi文件
             */
            $id = $music->id;
            $path = public_path() . '/midis';
            $name = $id . '.mid';
            $request->file('midi_file')->move($path, $name);

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
        $result = $this->music_import_csv($path, $filename);

        return view('importcsv')->with('result', $result);

    }

    protected function music_import_csv($path, $filename)
    {
        $file = $path . '/' . $filename;
        $fp = fopen($file, 'r');
        while($arr = fgetcsv($fp)) {
            $music = new Music;
            $music -> name = mb_convert_encoding($arr[0], 'UTF-8', 'GB2312');
            $music -> author = mb_convert_encoding($arr[1], 'UTF-8', 'GB2312');
            $music -> filename = mb_convert_encoding($arr[2], 'UTF-8', 'GB2312');
            $result[] = $music->save();
        }

        if (!in_array(false, $result)) {
            return true;
        }else {
            return false;
        }
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
        $name          = $request->get('name') or '';
        $composer      = $request->get('composer') or '';
        $instrument_id = $request->get('instrument');
        $version       = $request->get('version') or '';
        $press_id      = $request->get('press');
        $organizer_id  = $request->get('organizer') or 0;
        $note_content  = $request->get('notes') or '';
        $note_operator = $request->user()->id;
        // return $request->all();
        $music = Music::find($id);
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
        if (!empty($note_content)) {
            $music->note_content = $note_content;
            $music->note_operator = $note_operator;
        }
        $category             = $request->get('category');
        $category_old         = $request->get('category_old');
        if(!empty($category_old)) {
            $music->tags()->updateExistingPivot($category_old, ['tag_id' => $category]);
        }else {
            $music->tags()->attach($category);
        }
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
        $data['operator'] = \App\User::select('id', 'name')->with('musics')->whereHas('musics', function ($query) {
                                                                $query->groupby('operator');
                                                            })->groupby('id')->get();
        $data['organizer'] = \App\Organizer::select('id', 'name')->get();
        return $data;
        // $data['status'] = 'sdfsdfsdfsdfsdfsdfsdfdsf';
        // return $data;
    }
}
