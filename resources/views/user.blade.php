@extends('app')

@section('content')
        <div class="container">
            <table class="table table-striped table-hover">
                <tr>
                    <th>UID</th>
                    <th>cellphone</th>
                    <th>email</th>
                    <th>name</th>
                    <th>usertype</th>
                    <th>lastlogin</th>
                    <th>regdate</th>
                    <th>isactive</th>
                </tr>
                @foreach($users as $key => $user)
                    <tr>
                        <td>{{ $user->uid }}</td>
                        <td>{{ $user->cellphone }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->usertype }}</td>
                        <td>{{ $user->lastlogin }}</td>
                        <td>{{ $user->regdate }}</td>
                        <td>{{ $user->isactive }}</td>
                    </tr>
                @endforeach
            </table>
            <div class="text-center">
                {!! $users->render() !!}
            </div>
        </div>

@endsection
