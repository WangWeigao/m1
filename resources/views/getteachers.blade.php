@extends('teacher')
@section('searchResult')
<table class="table table-striped table-hover">
    <tr>
        <th>ID</th>
        <th>用户名</th>
        <th>联系方式</th>
        <th>Email</th>
        <th>订单历史</th>
        <th>注册时间</th>
        <th>最后登陆时间</th>
        <th>操作</th>
        <th>状态</th>
    </tr>
    @foreach($teachers as $teacher)
        <tr>
            <td><a class="user_id" href="{{ url('/userdetail/' . $teacher->uid) }}">{{ $teacher->uid }}</a></td>
            <td><a href="{{ url('/userdetail/' . $teacher->uid) }}">{{ $teacher->nickname }}</a></td>
            <td>{{ $teacher->cellphone }}</td>
            <td>{{ $teacher->email }}</td>
            <td>{{ $teacher->order_num }}</td>
            <td>{{ $teacher->lastlogin }}</td>
            <td>{{ $teacher->regdate }}</td>
            <td>
                <div class="btn-group btn-group-sm">
                    <button type="button" id="{{ $teacher->uid }}" class="{{ $teacher->isactive ? 'lockuser btn btn-success' : 'lockuser btn btn-danger' }}">{{ $teacher->isactive ? '锁定' : '解锁'  }}</button>
                    <a href="{{ url('/userdetail/' . $teacher->uid) }}"><button type="button" class="btn btn-info btn-sm">查看</button></a>
                </div>
            </td>
            <td id="isactive">{{ $teacher->isactive ? '未锁定' : '已锁定' }}</td>
        </tr>
    @endforeach
</table>
<div class="text-center">
    {!! $teachers->appends(['name' => $name])->render() !!}
</div>
@endsection
