@extends('user')
@section('searchResult')
<table class="table table-hover">
    <tr>
        <th>ID</th>
        <th>用户名</th>
        <th>联系方式</th>
        <th>Email</th>
        <th>订单历史</th>
        <th>注册年</th>
        <th>最后登陆时间</th>
    </tr>
    @foreach($users as $user)
        <tr>
            <td><a href="{{ url('/userdetail/' . $user->uid) }}">{{ $user->uid }}</a></td>
            <td><a href="{{ url('/userdetail/' . $user->uid) }}">{{ $user->nickname }}</a></td>
            <td>{{ $user->cellphone }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->order_num }}</td>
            <td>{{ $user->lastlogin }}</td>
            <td>{{ $user->regdate }}</td>
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
