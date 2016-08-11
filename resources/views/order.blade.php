@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="breadcrumb">
            <li>订单管理</li>
            <li class="active">订单查询</li>
        </div>
        <form class="" action="/order" method="get">
            <div class="form-group form-inline">
                <label for="">精确搜索</label>&nbsp;&nbsp;&nbsp;
                <input type="text" name="order_num_or_username" value="" class="form-control" placeholder="请输入订单号/用户名">
                <button type="submit" class="form-control btn-info">搜索</button>
            </div>
        </form>
        <hr>

        <form class="" action="/order" method="get" id="form">
            {!! csrf_field() !!}
            <div class="form-group form-inline">
                <div class="col-md-1">筛选条件</div>
                <input type="checkbox" name="order_type" value="" class="" id="order_type">
                <label for="order_type">订单类型</label>
                <select class="form-control" name="" id="s_order_type">
                    <option value="1">VIP1</option>
                    <option value="2">VIP2</option>
                </select>
                <input type="checkbox" name="vendor" value="" class="" id="vendor">
                <label for="vendor">发货商</label>
                <select class="form-control" name="" id="s_vendor">
                    <option value="1">App Store</option>
                    <option value="2">Android</option>
                    <option value="3">Card</option>
                </select>
                <input type="checkbox" name="order_status" value="" class="" id="order_status">
                <label for="order_status">订单状态</label>
                <select class="form-control" name="" id="s_order_status">
                    <option value="1">未付款</option>
                    <option value="2">取消订单</option>
                    <option value="3">已付款</option>
                </select>
            </div>
            <div class="form-group form-inline col-md-offset-1">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" v-model="checked" id="data_str" {{ Input::get('from_time') ? 'checked' : ''}}>订单生成日期
                    </label>
                </div>
                <div class="input-daterange input-group" id="datepicker">
                    <input type="text" id="from_time" class="form-control" v-model="from_time" name="@{{ checked ? 'from_time' : '' }}" data-value="{{ Input::get('from_time') }}"/>
                    <span class="input-group-addon">to</span>
                    <input type="text" id="to_time" class="form-control" v-model="to_time"   name="@{{ checked ? 'to_time' : '' }}" data-value="{{ Input::get('to_time') }}"/>
                </div>
            </div>


            <div class="col-md-offset-1">
                <div class="form-group">
                    <button type="submit" class="btn btn-info" id="search">查询</button>
                </div>
            </div>
        </form>
    </div>
        {{-- @if(!empty($from_time)) --}}
            @if(count($orders))
                <div class="container">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>用户账号</th>
                                <th>订单号</th>
                                <th>发货商</th>
                                <th>订单类型</th>
                                <th>金额</th>
                                <th>开始日期</th>
                                <th>截止日期</th>
                                <th>订单状态</th>
                                <th>操作</th>
                                <th>客服内容备注</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    {{-- 用户账号 --}}
                                    @if(!empty($order->user))
                                        <td>{{ $order->user->nickname or '-' }}</td>
                                    @else
                                        <td>{{ $order->nickname or '-' }}</td>
                                    @endif
                                    {{-- 订单号 --}}
                                    <td>{{ $order->id }}</td>
                                    <td>
                                        {{-- 发货商 --}}
                                        @if($order->channel == 1)
                                            APP Store
                                        @elseif($order->channel == 2)
                                            Android
                                        @elseif($order->channel == 3)
                                            Card
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        {{-- 订单类型 --}}
                                        @if($order->account_grade == 1)
                                            VIP1
                                        @elseif($order->account_grade == 2)
                                            VIP2
                                        @endif
                                    </td>
                                    {{-- 金额 --}}
                                    <td>{{ $order->price or '-' }}</td>
                                    {{-- 开始时间 --}}
                                    <td>{{ $order->pay_time }}</td>
                                    {{-- 截止日期 --}}
                                    <td>{{ $order->account_end_at }}</td>
                                    <td>
                                        {{-- 订单状态 --}}
                                        @if($order->status == 1)
                                            待付款
                                        @elseif($order->status == 2)
                                            取消订单
                                        @elseif($order->status == 3)
                                            已付款
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>操作</td>
                                    <td>
                                        {{-- 客服内容备注 --}}
                                        @if(!empty($order->operator))
                                            {{ $order->operator }}:{{ $order->notes }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-center">
                    {!! $orders->render() !!}
                </div>
            @else
                {{-- @if(!empty($is_start) || $order_num_or_username == '') --}}
                {{-- @else --}}
                    <div class="text-center">
                        <br>
                        <h4>暂无数据，调整查询条件再试试吧</h4>
                    </div>
                {{-- @endif --}}
            @endif

@endsection

@section('css')
    <link rel="stylesheet" href="{{ elixir('css/order.css') }}">
@endsection

@section('js')
    <script type="text/javascript" src=" {{ elixir('js/order.js') }}"></script>
@endsection
