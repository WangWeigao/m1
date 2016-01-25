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
                    <div class="form-group">
                        <button type="button" id="{{ $order->oid }}" class="btn btn-info btn-sm lockorder" >锁定</button>
                        <button type="button" class="btn btn-info btn-sm cancleorder" >取消</button>
                        <a href="{{ url('/orderdetail/') . '/' . $order->oid }}"><button type="button" class="btn btn-info btn-sm" >查看</button></a>
                    </div>
                </td>
                {{-- <td>{{ $order->locked }}</td> --}}
            </tr>
        @endforeach
    </table>
    <div class="text-center">
        {!! $orders->appends(['from_time' => $from_time, 'to_time' => $to_time])->render() !!}
    </div>
</div>

{{-- js脚本 --}}
@endsection

@section('js')
    <script src="{{ asset('js/getorders.js') }}"></script>
@endsection
