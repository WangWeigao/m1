@extends('layouts.app')

@section('content')
    <div class="container">
        <form class="" action="/order" method="get">
            {!! csrf_field() !!}
            <div class='col-md-3'>
                <div class="form-group">
                    <div class='input-group date' id='datetimepicker6'>
                        <input type='text' class="form-control" name="from_time" id="from_time"/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class='col-md-3'>
                <div class="form-group">
                    <div class='input-group date' id='datetimepicker7'>
                        <input type='text' class="form-control" name="to_time" id="to_time"/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <button type="submit" name="button" class="btn btn-info" id="search">查询</button>
                </div>
            </div>
        </form>
    </div>
        @if(!empty($from_time))
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
                                    <td>{{ $order->user->nick_name or '-' }}</td>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->channel }}</td>
                                    <td>{{ $order->type }}</td>
                                    <td>{{ $order->price or '-' }}</td>
                                    <td>{{ $order->pay_time }}</td>
                                    <td>截止时间</td>
                                    <td>{{ $order->status }}</td>
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
            @else
                <div class="text-center">
                    <br>
                    <h4>暂无数据，调整查询条件再试试吧</h4>
                </div>
            @endif
        @endif
        {{-- <div class="text-center">
            {!! $orders->appends(['from_time' => $from_time, 'to_time' => $to_time])->render() !!}
        </div> --}}

@endsection

@section('css')
    <link rel="stylesheet" href="/css/order.css" media="screen" title="no title" charset="utf-8">
@endsection

@section('js')
    <script src="js/order.js"></script>
@endsection
