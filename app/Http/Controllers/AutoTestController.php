<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\QueryWavGetRequest;
use App\MatchForTest;
use App\Practice;

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
    // 查看midi是否已经存在
    $midi_exists = self::midiExists($request);
    // 若midi不存在，执行wav转midi
    if (!$midi_exists) {
        self::midiExists($request);
    }
    // 匹配midi
    self::matchMidi($request);
    // 由于'wav转midi'和'匹配midi'花费时间较长，此处不判断，直接返回true
    return 'true';
}


/**
* midi文件是否存在
* @param  Request $request [description]
* @return [type]           [description]
*/
private static function midiExists(Request $request)
{
    $wav = $request->input('wav');
    $uid = $request->input('uid');
    $pid = $request->input('pid');

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://120.26.243.208/AIPianoBear/api/waonOver",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 180,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"wav\"\r\n\r\n\"" . $wav . "\"\r\n-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"uid\"\r\n\r\n" . $uid . "\r\n-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"pid\"\r\n\r\n" . $pid . "\r\n-----011000010111000001101001--",
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
            "content-type: multipart/form-data; boundary=---011000010111000001101001",
            "postman-token: bc0ae2c8-dbe8-648f-0c21-bac2fb184a20"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        return  "cURL Error #:" . $err;
    } else {
        return $response;
    }
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

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "http://120.26.243.208/AIPianoBear/api/waon",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 180,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => "-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"wav\"\r\n\r\n\"" . $wav . "\"\r\n-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"uid\"\r\n\r\n" . $uid . "\r\n-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"pid\"\r\n\r\n" . $pid . "\r\n-----011000010111000001101001--",
      CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: multipart/form-data; boundary=---011000010111000001101001",
        "postman-token: bc0ae2c8-dbe8-648f-0c21-bac2fb184a20"
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      return "cURL Error #:" . $err;
    } else {
      return $response;
    }
}


/**
 * 执行midi匹配
 * @param Request $request [description]
 */
public function matchMidi(Request $request)
{
    $wav = $request->get('wav');
    $uid = $request->get('uid');
    $pid = $request->get('pid');

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "http://120.26.243.208/AIPianoBear/api/match",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 180,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => "-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"wav\"\r\n\r\n\"" . $wav . "\"\r\n-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"uid\"\r\n\r\n" . $uid . "\r\n-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"pid\"\r\n\r\n" . $pid . "\r\n-----011000010111000001101001--",
      CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: multipart/form-data; boundary=---011000010111000001101001",
        "postman-token: bc0ae2c8-dbe8-648f-0c21-bac2fb184a20"
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      return "cURL Error #:" . $err;
    } else {
      return $response;
    }
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
