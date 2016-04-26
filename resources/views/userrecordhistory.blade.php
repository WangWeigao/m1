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
            <div class="btn-group btn-group-lg">
                <a href="/user/basicinfo/{{ $user_id }}" class="btn btn-default">基本信息</a>
                <a href="/user/actionhistory/{{ $user_id }}" class="btn btn-default">活动历史</a>
                <a href="/user/recordhistory/{{ $user_id }}" class="btn btn-default active">成绩历史</a>
                <a href="/user/orderhistory/{{ $user_id }}" class="btn btn-default">订单历史</a>
                <a href="/user/socialhistory/{{ $user_id }}" class="btn btn-default" disabled>社交历史</a>
            </div>
        </div>
        @if(count($records) != 0)
            <h3>成绩历史</h3>
            <table class="table">
                <tr>
                    <th>日期</th>
                    <th>曲目</th>
                    <th>时长</th>
                    <th>录音有效期</th>
                    <th>midi文件链接</th>
                    <th>错误汇总</th>
                    <th>努力值</th>
                    <th>徽章</th>
                </tr>
                @foreach($records as $record)
                    <tr>
                        <td>{{ $record->start_time }}</td>
                        <td>{{ $record->music_id }}</td>
                        <td>{{ $record->duration }}</td>
                        <td>{{ $record->record_expiration }}</td>
                        <td>
                            @foreach($record->midi_path as $value)
                                {{ $value }}<br>
                            @endforeach
                        </td>
                        <td>
                            @foreach($record->errors as $err)
                                第{{ $err['section'] }}节:
                                {{ $err['intonation'] ? '音准' : '' }}
                                {{ $err['rhythm'] ? '节奏' : '' }}
                                <br>
                            @endforeach
                        </td>
                        <td>
                            {{-- 努力值 --}}
                            @if($record->duration <= 10*60)
                                冒泡
                            @elseif($record->duration > 10*60 && $record->duration <= 20*60 )
                                飘过
                            @elseif($record->duration > 20*60 && $record->duration <= 30*60)
                                乖宝宝
                            @elseif($record->duration > 30*60 && $record->duration <= 45*60)
                                三道杠
                            @elseif($record->duration > 45*60 && $record->duration <= 60*60)
                                劳模
                            @elseif($record->duration > 60*60)
                                痴汉
                            @endif
                        </td>
                        <td>{{ $record->badge }}</td>
                    </tr>
                @endforeach
            </table>
        @else
            <div class="text-center">
                <hr>
                <h3>暂无成绩历史</h3>
            </div>
        @endif
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ elixir('css/userrecordhistory.css') }}" media="screen" title="no title" charset="utf-8">
@endsection
