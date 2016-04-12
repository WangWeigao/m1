@extends('layouts.app')
@section('content')
        @if($data['status'])
            <div class="panel panel-success">
                <div class="panel-heading">
                    导入成功
                </div>
            </div>
        @else
            <div class="panel panel-danger">
                <div class="panel-heading">
                    导入不成功:<br>
                </div>
                <div class="panel-body">
                    @if(is_array($data['errMsg']))
                        重复的文件名如下：<br>
                        @foreach($data['errMsg'] as $filename)
                            {{ $filename }} <br>
                        @endforeach
                    @else
                        {{ $data['errMsg'] }}
                    @endif
                </div>
            </div>
            <blockquote cite="">
            </blockquote>
        @endif
        {{-- {{ $result ? '导入成功' : '导入不成功' }} --}}

@endsection
