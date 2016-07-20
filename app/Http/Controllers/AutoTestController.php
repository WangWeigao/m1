<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\QueryWavGetRequest;
use App\MatchForTest;
use App\Practice;

class AutoTestController extends Controller
{
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
            $practice = Practice::with('music', 'user')
                                    ->where('uid', $user_id)
                                    ->where('wav_path', 'like', "%$wav_name%")
                                    ->first();

            // 查找match_for_tests表的信息
            $results = MatchForTest::where('practice_id', $practice['pid'])
                                    ->paginate(10)
                                    ->appends($request->all());
        } else {

            // 页面刚刚进入时(没有做查询操作)
            $results = MatchForTest::paginate(10)->appends($request->all());
            $practice = [];
        }
        return view('wav_test.index')->with($request->all())->with('results', $results)->with('practice', $practice);
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
