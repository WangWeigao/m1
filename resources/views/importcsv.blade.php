@extends('layouts.app')
@section('content')
    <blockquote cite="http://">
        {{ $result ? '导入成功' : '导入不成功' }}
    </blockquote>
@endsection
