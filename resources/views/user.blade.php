@extends('layouts.app')

@section('content')
<div class="container">
    {{-- 用户查询表单 --}}
    <form class="" action="/getusers" method="post">
        <fieldset>
            <legend>用户查询</legend>
            <div class="form-group">
              <label for="">用户搜索</label>
              <input type="text" class="form-control" id="searchName" name="name" placeholder="请输入用户名, 模糊搜索">
            </div>
            <button type="submit" name="button" class="btn btn-success" id="search">搜索</button>
        </fieldset>
    </form>
    <hr>
    @yield('searchResult')
@endsection


@section('js')
<script src="{{ asset('js/user.js') }}"></script>
@endsection
