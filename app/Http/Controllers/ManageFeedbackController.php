<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Feedback;
use Carbon\Carbon;

class ManageFeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword     = trim($request->input('keyword'));
        $field_date  = trim($request->input('field_date')) ? 'desc' : 'asc';
        $field_today = trim($request->input('field_today')) ? true : false;

        // 在用户昵称, 手机号, 电子邮箱中查询关键字
        $feedbacks = Feedback::WhereHas('user', function($query) use ($keyword) {
                        $query->where('nickname', 'like', "%$keyword%")
                              ->orWhere('cellphone', 'like', "%$keyword%")
                              ->orWhere('email', 'like', "%$keyword%");
                    });

        // 在当天中查找记录
        if ($field_today) {
            $feedbacks->whereBetween('created_at', [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()]);
        }

        // 按创建时间排序并分页
        $feedbacks = $feedbacks->orderBy('created_at', $field_date)->paginate(10);
        
        return view('feedback.index', compact('feedbacks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
