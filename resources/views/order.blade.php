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
            <div class="container">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>订单时间</th>
                            <th>订单ID</th>
                            <th>金额(元)</th>
                            <th>订单评分</th>
                            <th>订单状态</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>订单时间</th>
                            <th>订单ID</th>
                            <th>金额(元)</th>
                            <th>订单评分</th>
                            <th>订单状态</th>
                            <th>操作</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->submit_time }}</td>
                                <td>{{ $order->oid }}</td>
                                <td>{{ $order->price }}</td>
                                <td>{{ $order->rating }}</td>
                                <td>{{ $order->status }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" id="{{ $order->oid }}" class="btn btn-info btn-sm lockorder" >锁定</button>
                                        <button type="button" class="btn btn-info btn-sm cancleorder" >取消</button>
                                        <button type="button" id="{{ $order->oid }}" class="btn btn-info btn-xs detail" >查看</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
        {{-- <div class="text-center">
            {!! $orders->appends(['from_time' => $from_time, 'to_time' => $to_time])->render() !!}
        </div> --}}

@endsection
