@extends('layouts.app')
@section('content')
<div class="container">
    {{-- 用户查询表单 --}}
    <form class="" action="/teacher" method="get">
        {!! csrf_field() !!}
        <fieldset>
            <legend>教师查询</legend>
            <div class="form-group">
              {{-- <label for="">教师搜索</label> --}}
              <input type="text" class="form-control" id="searchName" name="name" placeholder="请输入教师名, 模糊搜索">
            </div>
            <button type="submit" name="button" class="btn btn-success" id="search">搜索</button>
        </fieldset>
    </form>
    <hr>
    @if(!empty($name))
        <table class="table table-hover">
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
                @foreach($teachers as $teacher)
                    <tr>
                        <td><a class="user_id" href="{{ url('/teacher/' . $teacher->uid) }}">{{ $teacher->uid }}</a></td>
                        <td><a href="{{ url('/teacher/' . $teacher->uid) }}">{{ $teacher->nickname }}</a></td>
                        <td>{{ $teacher->cellphone }}</td>
                        <td>{{ $teacher->email }}</td>
                        <td>{{ $teacher->order_num }}</td>
                        <td>{{ $teacher->lastlogin }}</td>
                        <td>{{ $teacher->regdate }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button type="button" id="{{ $teacher->uid }}" class="{{ $teacher->isactive ? 'lockuser btn btn-success' : 'lockuser btn btn-danger' }}">{{ $teacher->isactive ? '锁定' : '解锁'  }}</button>
                                <a href="{{ url('/teacher/' . $teacher->uid) }}"><button type="button" class="btn btn-info btn-sm">查看</button></a>
                            </div>
                        </td>
                        <td id="isactive">{{ $teacher->isactive ? '未锁定' : '已锁定' }}</td>
                    </tr>
            @endforeach
        </tbody>
        </table>
    @endif
@endsection
