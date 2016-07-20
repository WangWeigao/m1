@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="input-group">
          <span class="input-group-addon">用户ID</span>
          <input type="text" class="form-control" placeholder="用户ID">
        </div>
        <div class="input-group">
          <span class="input-group-addon">wav文件名</span>
          <input type="text" class="form-control" placeholder="wav文件名">
        </div>
        <div class="input-group">
          <span class="input-group-addon">-n</span>
          <input type="text" class="form-control" placeholder="参数 n 的值">
        </div>
        <div class="input-group">
          <span class="input-group-addon">-s</span>
          <input type="text" class="form-control" placeholder="参数 s 的值">
        </div>
        <div class="input-group">
          <span class="input-group-addon">-c</span>
          <input type="text" class="form-control" placeholder="参数 c 的值">
        </div>
        <br>
        <div class="btn-group btn-group-sm">
            <button type="button" class="btn btn-info">匹配</button>
        </div>
    </div>
@endsection
