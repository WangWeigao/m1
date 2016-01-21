@extends('order')

@section('orderList')
<div class="container">
    <table class="table table-striped table-hover">
        <tr>
            <th>订单时间</th>
            <th>订单号</th>
            <th>金额</th>
            <th>订单评分</th>
            <th>订单状态</th>
            <th>操作</th>
        </tr>
        @foreach($orders as $order)
            <tr>
                <td>{{ $order->submit_time }}</td>
                <td>{{ $order->oid }}</td>
                <td>{{ $order->price }}</td>
                <td>{{ $order->rating }}</td>
                <td>{{ $order->status }}</td>
                <td>
                    <button type="button" name="button" class="btn btn-warning btn-sm" name="lock">锁定</button>
                    <button type="button" name="button" class="btn btn-danger btn-sm" name="cancle">取消</button>
                    <button type="button" name="button" class="btn btn-info btn-sm" name="view">查看</button>
                </td>
            </tr>
        @endforeach
    </table>
    <div class="text-center">
        {!! $orders->render() !!}
    </div>
</div>
@endsection
