@extends('app')

@section('content')
        <div class="container">
            <table class="table table-striped table-hover">
                <tr>
                    <th>UID</th>
                    <th>cellphone</th>
                    <th>email</th>
                    <th>nickname</th>
                    <th>usertype</th>
                    <th>lastlogin</th>
                    <th>regdate</th>
                    <th>isactive</th>
                </tr>
                @foreach($teachers as $key => $teacher)
                    <tr>
                        <td>{{ $teacher->uid }}</td>
                        <td>{{ $teacher->cellphone }}</td>
                        <td>{{ $teacher->email }}</td>
                        <td>{{ $teacher->nickname }}</td>
                        <td>{{ $teacher->usertype }}</td>
                        <td>{{ $teacher->lastlogin }}</td>
                        <td>{{ $teacher->regdate }}</td>
                        <td>{{ $teacher->isactive }}</td>
                    </tr>
                @endforeach
            </table>
            <div class="text-center">
                {{-- 添加分页 --}}
                {!! $teachers->render() !!}
            </div>
        </div>

@endsection
