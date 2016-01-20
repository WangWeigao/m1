@extends('user')
@section('searchResult')
<table class="table">
    <tr>
        <th>UID</th>
        <th>CellPhone</th>
        <th>email</th>
        <th>nickname</th>
        <th>lastlogin</th>
        <th>regdate</th>
        <th>isactive</th>
    </tr>
    @foreach($users as $user)
        <tr>
            <td>{{ $user->uid }}</td>
            <td>{{ $user->cellphone }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->nickname }}</td>
            <td>{{ $user->lastlogin }}</td>
            <td>{{ $user->regdate }}</td>
            <td>{{ $user->isactive }}</td>
        </tr>
    @endforeach
</table>
<div class="text-center">
    {!! $users->render() !!}
</div>
@endsection
