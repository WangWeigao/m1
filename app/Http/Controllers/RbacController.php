<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;
use App\Role;

class RbacController extends Controller
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
        $users = User::with('roles')->get();
        $roles = Role::all();
        return view('rbac.user')->with(['users' => $users, 'roles' => $roles]);
        // return view('rbac.user');
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
        // return $request->all();
        $user = User::find($id);
        /**
         * 判断用户是否有角色，如果没有创建一个，如果有更新
         */
        if (count($user->roles) < 1) {
            $result = $user->roles()->attach($request->role);
            if ($result) {
                $data['status'] = true;
            } else {
                $data['status'] = false;
                $data['errCode'] = 10011;
                $data['errMsg'] = '创建失败';
            }
        }else {
            $result = $user->roles()->updateExistingPivot($request->origin_role, ['role_id' => $request->role]);
            if ($result) {
                $data['status'] = true;
            } else {
                $data['status'] = false;
                $data['errCode'] = 10012;
                $data['errMsg'] = '保存失败';
            }
        }
        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        // return $id . '/' . $request->role;
        $count = count(User::find($id)->roles());
        if ($count < 1) {
            $data['status'] =false;
            $data['errCode'] = 10013;
            $data['errMsg'] = '删除失败';
            return $data;
        }else {
            $user = User::find($id);
            $result = $user->roles()->detach($request->role);
        }

        if ($result) {
            $data['status'] = true;
        } else {
            $data['status'] =false;
            $data['errCode'] = 10013;
            $data['errMsg'] = '删除失败';
        }
        return $data;
    }
}
