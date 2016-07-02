@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
          <li>用户管理</li>
          <li>学生列表</li>
          <li class="active">用户详情</li>
        </ol>

        {{-- 标签栏 --}}
        <div class="text-center">
            <div class="btn-group btn-group-lg form-group">
                <a href="/user/basicinfo/{{ $user_id }}" class="btn btn-default">基本信息</a>
                <a href="/user/actionhistory/{{ $user_id }}" class="btn btn-default">活动历史</a>
                <a href="/user/recordhistory/{{ $user_id }}" class="btn btn-default">成绩历史</a>
                <a href="/user/orderhistory/{{ $user_id }}" class="btn btn-default active">订单历史</a>
                <a href="/user/socialhistory/{{ $user_id }}" class="btn btn-default form-conotrol" disabled="disabled">社交历史</a>
            </div>
        </div>

        @if(count($orders) != 0)
            <legend>订单历史</legend>
            <div class="form-inline" style="font-size:1.3em">
                <span>目前累计消费:{{ $consume_all[0]->value or 0}}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <span>本月累计消费:{{ $consume_month[0]->value or 0 }}</span>
            </div>
            <table class="table table-bordered table-hover">
                <tr>
                    <th>订单号</th>
                    <th>日期</th>
                    <th>订单类型</th>
                    <th>渠道</th>
                    <th>价格</th>
                    <th>订单状态</th>
                </tr>
                @foreach($orders as $o)
                    <tr>
                        <td>{{ $o->id }}</td>
                        <td>{{ $o->pay_time }}</td>
                        <td>
                            @if($o->type == 1)
                                VIP1(包年)
                            @elseif($o->type == 2)
                                VIP2(包月)
                            @else
                                普通用户
                            @endif
                        </td>
                        <td>
                            {{ $o->channel }}
                        </td>
                        <td>{{ $o->price }}</td>
                        <td>
                            {{ $o->status }}
                        </td>
                    </tr>
                @endforeach
            </table>
            <div class="text-center">
                {!! $orders->render() !!}
            </div>
        @else
            <div class="text-center">
                <hr>
                <h3>暂时没有订单历史</h3>
            </div>
        @endif
    </div>
@endsection
