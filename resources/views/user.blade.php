@extends('layouts.app')
@section('content')
<div class="container">
{{-- 用户查询表单 --}}
<form class="" action="/user" method="get">
    {!! csrf_field() !!}
    <fieldset>
        <legend>用户查询</legend>
        <div class="form-group">
          {{-- <label for="">用户搜索</label> --}}
          <input type="text" class="form-control" id="searchName" name="name" placeholder="请输入用户名或手机号">
          <input type="hidden" name="field" value="uid">
          <input type="hidden" name="order" value="asc">
        </div>
        <button type="submit" name="button" class="btn btn-success" id="search">搜索</button>
    </fieldset>
</form>
<hr>
@if(!empty($name))

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>用户名</th>
            <th>联系方式</th>
            <th>Email</th>
            <th>订单历史</th>
            <th>注册时间</th>
            <th>最后登陆时间</th>
            <th>操作</th>
            <th>状态</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th>ID</th>
            <th>用户名</th>
            <th>联系方式</th>
            <th>Email</th>
            <th>订单历史</th>
            <th>注册时间</th>
            <th>最后登陆时间</th>
            <th>操作</th>
            <th>状态</th>
        </tr>
    </tfoot>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td><a class="user_id" href="{{ url('/userdetail/' . $user->uid) }}">{{ $user->uid }}</a></td>
                <td><a href="{{ url('/userdetail/' . $user->uid) }}">{{ $user->nickname }}</a></td>
                <td>{{ $user->cellphone }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->order_num }}</td>
                <td>{{ $user->lastlogin }}</td>
                <td>{{ $user->regdate }}</td>
                <td>
                    <div class="btn-group btn-group-sm">
                        <button type="button" id="{{ $user->uid }}" class="{{ $user->isactive ? 'lockuser btn btn-success' : 'lockuser btn btn-danger' }}">{{ $user->isactive ? '锁定' : '解锁'  }}</button>
                        <a href="{{ url('/userdetail/' . $user->uid) }}"><button type="button" class="btn btn-info btn-sm">查看</button></a>
                    </div>
                </td>
                <td id="isactive">{{ $user->isactive ? '未锁定' : '已锁定' }}</td>
            </tr>
            @endforeach
        </tbody>
</table>

@endif
{{-- 因使用DataTables插件, 将所有数据给到前端, 由前端分页, 此处暂时用不到 --}}
{{-- <div class="text-center">
    {!! $users->appends(['name' => $name])->render() !!}
</div> --}}
@endsection
