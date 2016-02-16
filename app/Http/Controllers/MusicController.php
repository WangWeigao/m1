<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Music;
use DB;

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
        $name = $request->get('name') or '';
        $data = Music::orwhere('name', 'like', "%$name%")
                    ->orwhere('auth', 'like', "%$name%")
                    ->get();
        // return $data;
        return view('music')->with(['data'=>$data, 'name'=>$name]);
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
            $music -> auth = mb_convert_encoding($arr[1], 'UTF-8', 'GB2312');
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
     * 获取内容的编码
     * @param string $str
     */
    // function get_encoding($str = "") {
    	// $encodings = array (
    	// 	'ASCII',
    	// 	'UTF-8',
    	// 	'GBK',
        //     'GB18030'
    	// );
    	// foreach ( $encodings as $encoding ) {
    	// 	if ($str === mb_convert_encoding ( mb_convert_encoding ( $str, "UTF-8", $encoding ), $encoding, "UTF-8" )) {
    	// 		return $encoding;
    	// 	}
    	// }
    	// return false;
        // return mb_convert_encoding($str, 'UTF-8', 'GBK');
    // }

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
