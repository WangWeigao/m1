<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\QueryWavGetRequest;
use App\MatchForTest;
use App\Practice;
use Log;
use GuzzleHttp\Client;

class AutoTestController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // 提交查询
        if ($request->has('user_id') && $request->has('wav_name')) {

            $user_id  = $request->get('user_id');
            $wav_name = $request->get('wav_name');

            // 查找practice表的信息
            $practice = Practice::with([
                                    'user' => function($query) { $query->select('uid', 'nickname'); },
                                    'music' => function($query) { $query->select('id', 'name'); }
                                ])
                                ->where('uid', $user_id)
                                ->where('wav_path', '/midis/' . $user_id . '/' . $wav_name)
                                ->first();

            // 查找match_for_tests表的信息
            $results = MatchForTest::where('practice_id', $practice['pid'])
                                    ->orderBy('id', 'desc')
                                    ->paginate(100)
                                    ->appends($request->all());

            return view('wav_test.index')->with($request->all())->with('results', $results)->with('practice', $practice);
        } else {
            return view('wav_test.index')->with('practice', []);
        }
    }


public function generateAndMatchMidi(Request $request)
{
    echo 'true';

    // =======这部分是将输出内容刷新到用户浏览器并断开和浏览器的连接=====
    // 如果使用的是php-fpm
    if(function_exists('fastcgi_finish_request')){
        // 刷新buffer
        ob_flush();
        flush();
        // 断开浏览器连接
        fastcgi_finish_request();
    }
    // ========下面是后台要继续执行的内容========

    // 查看midi是否已经存在
    $midi_exists = self::midiExists($request);
    Log::info('[查询 midi是否生成] ' . $midi_exists);
    // 若midi不存在，执行wav转midi, 否则执行匹配midi
    if ($midi_exists == 'false') {
        Log::info('[转换 midi] ' . $request->uid . '/' . $request->pid . '/' . $request->wav);
        // wav转midi
        $this->midiIsGenerated($request);
    } else {
        Log::info('[匹配 midi] ' . $request->uid . '/' . $request->pid . '/' . $request->wav);
        // 匹配midi
        self::matchMidi($request);
    }
}


/**
* midi文件是否存在
* @param  Request $request [description]
* @return [type]           [description]
*/
public function midiExists(Request $request)
{
    $wav = $request->input('wav');
    $uid = $request->input('uid');
    $pid = $request->input('pid');

    $client = new Client(['base_uri' => 'http://120.26.243.208/AIPianoBear/api/']);
    $response = $client->request('POST', 'waonOver', [
        'form_params' => [
            'wav' => $wav,
            'uid' => $uid,
            'pid' => $pid
        ]
    ]);
    $result = $response->getBody()->getContents();

    return $result;

}


/**
 * 生成midi文件(wav转midi)
 * @param  [string] $wav [用来生成midi的wav文件名称]
 * @param  [int] $uid [practice表中wav文件所属的uid]
 * @param  [int] $pid [practice表中wav文件所属的pid]
 * @return [boolean]      [生成结果]
 */
private static function midiIsGenerated(Request $request)
{
    $wav = $request->input('wav');
    $uid = $request->input('uid');
    $pid = $request->input('pid');

    $client = new Client(['base_uri' => 'http://120.26.243.208/AIPianoBear/api/']);
    $response = $client->request('POST', 'waon', [
        'form_params' => [
            'wav' => $wav,
            'uid' => $uid,
            'pid' => $pid
        ]
    ]);
    $result = $response->getBody()->getContents();

    return $result;
}


/**
 * 执行midi匹配
 * @param Request $request [description]
 */
public function matchMidi(Request $request)
{
    $wav = $request->input('wav');
    $uid = $request->input('uid');
    $pid = $request->input('pid');

    $client = new Client(['base_uri' => 'http://120.26.243.208/AIPianoBear/api/']);
    $response = $client->request('POST', 'match', [
        'form_params' => [
            'wav' => $wav,
            'uid' => $uid,
            'pid' => $pid
        ]
    ]);
    $result = $response->getBody()->getContents();

    return $result;
}


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('wav_test.create');
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
