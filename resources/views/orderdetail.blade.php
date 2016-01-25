@extends('layouts.app')

@section('content')
<div class="container">
    <h3>订单详细信息</h3>
    <table class="table table-striped table-hover">
        <tr>
            <th>订单 ID</th>
            <th>课程 ID</th>
            <th>用户 ID</th>
            <th>授课方式</th>
            <th>课时数量</th>
            <th>提交时间</th>
            <th>订单价格</th>
            <th>状态</th>
        </tr>
        <tr>
            <td>{{ $orderInfo->oid }}</td>
            <td>{{ $orderInfo->lid }}</td>
            <td>{{ $orderInfo->student_uid }}</td>
            <td>{{ $orderInfo->method }}</td>
            <td>{{ $orderInfo->lasts }}</td>
            <td>{{ $orderInfo->submit_time }}</td>
            <td>{{ $orderInfo->price }}</td>
            <td>{{ $orderInfo->status }}</td>
        </tr>
    </table>
</div>
@endsection
