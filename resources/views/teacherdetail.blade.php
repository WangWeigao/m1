@extends('layouts.app')

@section('content')
<div class="container">
    <h3>用户信息</h3>
    <table class="table table-striped">
        <tr>
            <th>ID</th>
            <th>用户名</th>
            <th>联系方式</th>
            <th>Email</th>
            <th>订单历史</th>
            <th>注册日期</th>
            <th>最后登陆时间</th>
        </tr>

        <tr>
            <td>{{ $data['teacherInfo']->uid }}</td>
            <td>{{ $data['teacherInfo']->nickname }}</td>
            <td>{{ $data['teacherInfo']->cellphone }}</td>
            <td>{{ $data['teacherInfo']->email }}</td>
            <td>{{ $data['teacherInfo']->order_num }}</td>
            <td>{{ $data['teacherInfo']->lastlogin }}</td>
            <td>{{ $data['teacherInfo']->regdate }}</td>
        </tr>
    </table>

@if(count($data['teacherInfo']['orders']) != 0)
    <h3>订单信息</h3>
    <table class="table table-striped table-hover">
        <tr>
            <th>订单时间</th>
            <th>订单号</th>
            <th>金额</th>
            <th>课时</th>
            <th>订单状态</th>
            <th>教师ID</th>
            <th>交易教师</th>
            <th>评分</th>
        </tr>
        @foreach($data['teacherInfo']['orders'] as $order)
            <tr>
                <td>{{ $order->submit_time }}</td>
                <td>{{ $order->oid }}</td>
                <td>{{ $order->price }}</td>
                <td>{{ $order->lasts }}</td>
                <td>{{ $order->status }}</td>
                <td>{{ $order->teacher_uid }}</td>
                <td>{{ $order->teacher_nickname }}</td>
                <td>{{ $order->rating }}</td>
            </tr>
        @endforeach
    </table>
@else
    <div class="text-center">
        <blockquote>没有订单数据</blockquote>
    </div>
@endif
</div>

@endsection
