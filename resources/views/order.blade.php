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

        <form class="" action="/order" method="get">
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

            <div class="form-group form-inline">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="data_str" value="" id="data_str">订单生成日期
                    </label>
                </div>
                <div class="col-md-3 col-md-offset-1 date_left">
                    <div class="form-group">
                        <div class='input-group date' id='datetimepicker6'>
                            <input type='text' class="form-control" name="from_time" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class='col-md-3 date_right'>
                    <div class="form-group">
                        <div class='input-group date' id='datetimepicker7'>
                            <input type='text' class="form-control" name="to_time"/>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="form-group form-inline">
                <div class='col-md-3'>
                    <div class="form-group">
                        <div class='input-group date' id='datetimepicker6'>
                            <input type='text' class="form-control" name="" id="from_time"/>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class='col-md-3'>
                    <div class="form-group">
                        <div class='input-group date' id='datetimepicker7'>
                            <input type='text' class="form-control" name="" id="to_time"/>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div> --}}

            <div class="col-md-2">
                <div class="form-group">
                    <button type="submit" name="button" class="btn btn-info" id="search">查询</button>
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
                                    @if(!empty($order->user))
                                        <td>{{ $order->user->nickname or '-' }}</td>
                                    @else
                                        <td>{{ $order->nickname or '-' }}</td>
                                    @endif
                                    <td>{{ $order->id }}</td>
                                    <td>
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
                                        @if($order->account_grade == 1)
                                            VIP1
                                        @elseif($order->account_grade == 2)
                                            VIP2
                                        @endif
                                    </td>
                                    <td>{{ $order->price or '-' }}</td>
                                    <td>{{ $order->pay_time }}</td>
                                    <td>{{ $order->account_end_at }}</td>
                                    <td>
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
                                        @if(!empty($order->operator))
                                            {{ $order->operator }}:{{ $order->notes }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    {{-- <td> --}}
                                    {{-- <div class=""> --}}
                                    {{-- <button type="button" id="{{ $order->oid }}" class="btn btn-info btn-sm lockorder" >锁定</button> --}}
                                    {{-- <button type="button" class="btn btn-info btn-sm cancleorder" >取消</button> --}}
                                    {{-- 调用模态框 --}}
                                    {{-- <button type="button" id="{{ $order->oid }}" class="btn btn-info btn-xs detail" data-toggle="modal" data-target="#order_detail">查看</button> --}}
                                    {{-- 模态框 --}}
                                    {{-- <div class="modal fade" id="order_detail" tabindex="-1" role="dialog" aria-labelledby="order_detailLabel" aria-hidden="true"> --}}
                                    {{-- <div class="modal-dialog" style="width: auto"> --}}
                                    {{-- <div class="modal-content"> --}}
                                    {{-- <div class="modal-header"> --}}
                                    {{-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> --}}
                                    {{-- <h4 class="modal-title" id="order_detailLabel">订单详细信息</h4> --}}
                                    {{-- </div> --}}
                                    {{-- <div class="modal-body"> --}}
                                    {{-- <table class="table table-striped table-hover"> --}}
                                    {{-- <thead> --}}
                                    {{-- <tr> --}}
                                    {{-- <th>订单 ID</th> --}}
                                    {{-- <th>课程 ID</th> --}}
                                    {{-- <th>用户 ID</th> --}}
                                    {{-- <th>授课方式</th> --}}
                                    {{-- <th>课时数量</th> --}}
                                    {{-- <th>提交时间</th> --}}
                                    {{-- <th>订单价格</th> --}}
                                    {{-- <th>状态</th> --}}
                                    {{-- </tr> --}}
                                    {{-- </thead> --}}
                                    {{-- <tbody> --}}
                                    {{-- <tr> --}}
                                    {{-- <td></td> --}}
                                    {{-- <td></td> --}}
                                    {{-- <td></td> --}}
                                    {{-- <td></td> --}}
                                    {{-- <td></td> --}}
                                    {{-- <td></td> --}}
                                    {{-- <td></td> --}}
                                    {{-- <td></td> --}}
                                    {{-- </tr> --}}
                                    {{-- </tbody> --}}
                                    {{-- </table> --}}
                                    {{-- </div> --}}
                                    {{-- <div class="modal-footer"> --}}
                                    {{-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> --}}
                                    {{-- <button type="button" class="btn btn-primary">保存修改</button> --}}
                                    {{-- </div> --}}
                                    {{-- </div> --}}
                                    {{-- </div> --}}
                                    {{-- </div> --}}
                                    {{-- </div> --}}
                                    {{-- </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-center">
                    {!! $orders->appends($query_string)->render() !!}
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
    <link rel="stylesheet" href="/css/order.css" media="screen" title="no title" charset="utf-8">
@endsection

@section('js')
    <script src="js/order.js"></script>
@endsection
