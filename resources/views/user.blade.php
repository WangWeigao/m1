@extends('layouts.app')
@section('content')
<div class="container">
    {{-- 面包屑导航 --}}
    <div class="breadcrumb">
        <li>用户管理</li>
        <li class="active">学生列表</li>
    </div>

    {{-- 用户查询表单 --}}
    <form class="" action="/user" method="get">
        {!! csrf_field() !!}
        {{-- <fieldset> --}}
            {{-- <legend>用户查询</legend> --}}
            <div class="form-group form-inline">
                {{-- <label for="">用户搜索</label> --}}
                <div>精确搜索</div>
                <input type="text" class="form-control" id="searchName" name="name" placeholder="请输入用户名/手机号/电子邮件">
                <button type="submit" name="button" class="btn btn-success" id="search">搜索</button>
            </div>
            <div class="form-inline">
                <div>筛选待件</div>
                {{-- 地域 --}}
                <input type="checkbox" name="" value="" id="area">
                <label for="area">地域</label>
                <select class="form-control" name="">
                    <option>省份</option>
                </select>
                <select class="form-control" name="">
                    <option>城市</option>
                </select>
                {{-- 水平等级 --}}
                <input type="checkbox" name="name" value="" id="user_grade">
                <label for="user_grade">水平等级</label>
                <select class="form-control" name="">
                    <option>水平等级</option>
                </select>
                {{-- 注册时间 --}}
                <input type="checkbox" name="name" value="" id="reg_time">
                <label for="reg_time">注册时间</label>
                <select class="form-control" name="">
                    <option value="day">新用户</option>
                    <option value="week">一周内</option>
                    <option value="month">一月内</option>
                    <option value="half_year">半年内</option>
                    <option value="year">一年内</option>
                    <option value="one_more_year">一年以上</option>
                </select>
                {{-- 帐号级别 --}}
                <input type="checkbox" name="" value="" id="account_grade">
                <label for="account_grade">帐号级别</label>
                <select class="form-control" name="">
                    <option value="vip1">VIP1</option>
                    <option value="vip2">VIP2</option>
                    <option value="free">免费</option>
                    <option value="all">全部</option>
                </select>
                {{-- 帐号截止日期 --}}
                <input type="checkbox" name="" value="" id="account_end_at">
                <label for="account_end_at">帐号截止日期</label>
                <select class="form-control" name="">
                    <option value="week">一周内</option>
                    <option value="month">一个月内</option>
                    <option value="two_months">二个月内</option>
                </select>
                <input type="hidden" name="field" value="uid">
                <input type="hidden" name="order" value="asc">
            </div>
            <div class="form-inline">
                {{-- 本月使用时长 --}}
                <input type="checkbox" name="" value="" id="month_duration">
                <label for="month_duration">本月使用时长</label>
                <select class="form-control" name="">
                    <option value="1h">1小时以内的</option>
                    <option value="5h">5小时以内的</option>
                    <option value="10h">10小时以内的</option>
                    <option value="30h">30小时以内的</option>
                    <option value="60h">60小时以内的</option>
                    <option value="60h+">60小时以上</option>
                    <option value="0h">未使用</option>
                </select>
                {{-- 帐号状态 --}}
                <input type="checkbox" name="" value="" id="account_status">
                <label for="account_status">帐号状态</label>
                <select class="" name="">
                    <option value="near_expire">帐号到期</option>
                    <option value="lock">锁定</option>
                    <option vlaue="normal">正常</option>
                    <option vlaue="expire">未续费</option>
                </select>
            </div>
        {{-- </fieldset> --}}
    </form>
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
        <tbody>
            @foreach($users as $user)
            <tr>
                <td><a class="user_id" href="{{ url('/user/' . $user->uid) }}">{{ $user->uid }}</a></td>
                <td><a href="{{ url('/user/' . $user->uid) }}">{{ $user->nickname }}</a></td>
                <td>{{ $user->cellphone }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->order_num }}</td>
                <td>{{ $user->lastlogin }}</td>
                <td>{{ $user->regdate }}</td>
                <td>
                    <div class="btn-group btn-group-xs">
                        <button type="button" id="{{ $user->uid }}" class="{{ $user->isactive ? 'lockuser btn btn-success' : 'lockuser btn btn-danger' }}">{{ $user->isactive ? '锁定' : '解锁'  }}</button>
                        <a href="{{ url('/user/' . $user->uid) }}"><button type="button" class="btn btn-info btn-xs">查看</button></a>
                    </div>
                </td>
                <td id="isactive">{{ $user->isactive ? '未锁定' : '已锁定' }}</td>
            </tr>
            @endforeach
        </tbody>
</table>
{{-- 因使用DataTables插件, 将所有数据给到前端, 由前端分页, 此处暂时用不到 --}}
<div class="text-center">
    {!! $users->appends(['name' => $name])->render() !!}
</div>

@endif
@endsection
