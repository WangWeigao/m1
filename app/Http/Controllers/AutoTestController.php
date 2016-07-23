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
                                    ->orderBy('created_at', 'desc')
                                    ->paginate(10)
                                    ->appends($request->all());
        } else {

            // 页面刚刚进入时(没有做查询操作)
            $results = MatchForTest::paginate(10)->appends($request->all());
            $practice = [];
        }
        return view('wav_test.index')->with($request->all())->with('results', $results)->with('practice', $practice);
    }


public function WaonInterface(Request $request)
{
    $wav = $request->get('wav');
    $uid = $request->get('uid');
    $pid = $request->get('pid');

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "http://120.26.243.208/AIPianoBear/api/waon",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
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
      echo "cURL Error #:" . $err;
    } else {
      echo $response;
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
