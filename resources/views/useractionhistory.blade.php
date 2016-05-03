@extends('layouts.app')
@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li>用户管理</li>
            <li>学生列表</li>
            <li class="active">活动历史</li>
        </ol>

        {{-- 标签栏 --}}
        <div class="text-center">
            <div class="btn-group btn-group-lg">
                <a href="/user/basicinfo/{{ $user_id }}" class="btn btn-default">基本信息</a>
                <a href="/user/actionhistory/{{ $user_id }}" class="btn btn-default active">活动历史</a>
                <a href="/user/recordhistory/{{ $user_id }}" class="btn btn-default">成绩历史</a>
                <a href="/user/orderhistory/{{ $user_id }}" class="btn btn-default">订单历史</a>
                <a href="/user/socialhistory/{{ $user_id }}" class="btn btn-default" disabled>社交历史</a>
            </div>
        </div>
        @if(count($actions) != 0)
            <h3>活动历史</h3>
            <table class="table table-hover">
                <tr>
                    <th>动作</th>
                    <th>时间</th>
                    <th>时长</th>
                </tr>
                @foreach($actions as $action)
                    <tr>
                        <td class="col-sm-4">{{ $action->action }}</td>
                        <td class="col-sm-4">{{ $action->created_at }}</td>
                        <td class="col-sm-4">{{ $action->duration ? $action->duration : '-' }}</td>
                    </tr>
                @endforeach
            </table>
            <div class="text-center">
                {!! $actions->render() !!}
            </div>
        @else
            <div class="text-center">
                <hr>
                <h3>暂无活动历史</h3>
            </div>
        @endif
    </div>

@endsection

@section('js')

@endsection

@section('css')

@endsection
