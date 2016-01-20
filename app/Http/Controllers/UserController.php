<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\OldUser as User;

class UserController extends Controller
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
    public function index()
    {
        return view('user');
    }

    public function getUsers(Request $request)
    {
        //取得要查询的用户名
        $name = $request->get('name');

        //模糊匹配, 查询结果为分页做准备
        $users = User::where('nickname', 'like', "%$name%")->paginate(10);

        //将结果传递给视图
        return view('getusers')->with('users', $users);

    }
}
