@extends('user')
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
    @foreach($users as $user)
        <tr>
            <td><a class="user_id" href="{{ url('/userdetail/' . $user->uid) }}">{{ $user->uid }}</a></td>
            <td><a href="{{ url('/userdetail/' . $user->uid) }}">{{ $user->nickname }}</a></td>
            <td>{{ $user->cellphone }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->order_num }}</td>
            <td>{{ $user->lastlogin }}</td>
            <td>{{ $user->regdate }}</td>
            <td>
                <div class="btn-group btn-group-sm">
                    <button type="button" id="{{ $user->uid }}" class="{{ $user->isactive ? 'lockuser btn btn-success' : 'lockuser btn btn-danger' }}">{{ $user->isactive ? '锁定' : '解锁'  }}</button>
                    <a href="{{ url('/orderdetail/$user->oid') }}"><button type="button" class="btn btn-info btn-sm">查看</button></a>
                </div>
            </td>
            <td id="isactive">{{ $user->isactive ? '未锁定' : '已锁定' }}</td>
        </tr>
    @endforeach
</table>
<div class="text-center">
    {!! $users->appends(['name' => $name])->render() !!}
</div>
@endsection

@section('js')
    <script src="{{ asset('js/getusers.js') }}"></script>
@endsection
