@extends('layouts.app')

@section('content')
    <div class="container">
        @if($data['status'])
            <div class="panel panel-success">
                <div class="panel-heading">
                    密码修改成功
                </div>
            </div>
        @else
            <div class="panel panel-danger">
                <div class="panel-heading">
                    密码修改失败
                </div>
            </div>
        @endif

    </div>
@endsection
