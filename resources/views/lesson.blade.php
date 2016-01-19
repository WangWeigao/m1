@extends('app')

@section('content')
        <div class="container">
            {!! csrf_field() !!}
            <table class="table table-striped table-hover">
                <tr>
                    <th>lid</th>
                    <th>teacher_uid</th>
                    <th>title</th>
                    <th>type</th>
                    <th>price</th>
                    <th>count</th>
                    <th>valid</th>
                </tr>
                @foreach($lessons as $lesson)
                    <tr>
                        <td>{{ $lesson->lid }}</td>
                        <td>{{ $lesson->teacher_uid }}</td>
                        <td>{{ $lesson->title }}</td>
                        <td>{{ $lesson->type }}</td>
                        <td>{{ $lesson->price }}</td>
                        <td>{{ $lesson->count }}</td>
                        <td>{{ $lesson->valid }}</td>
                    </tr>
                @endforeach
            </table>
            <div class="text-center">
                {{-- 添加分页 --}}
                {!! $lessons->render() !!}
            </div>
        </div>

@endsection
