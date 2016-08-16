@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li>反馈管理</li>
        </ol>
        <form action="/manage_feedback" method="get">
            {{ csrf_field() }}
            <div class="row form-inline form-group">
                <span class="col-md-1">精确搜索</span>
                <input type="text" size="40" class="form-control col-md-3" name="keyword" placeholder="请输入用户账号/手机号/电子邮箱">
            </div>
            <div class="row">
                <h5 class="col-md-1">筛选条件</h5>
                <div class="col-md-3">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="field_date">
                            按时间顺序排列(从新到旧)
                        </label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="field_today">
                            只看今天
                        </label>
                    </div>
                </div>
                <button type="submit" class="col-md-offset-1 btn btn-info">搜索</button>
                <a href="#" class="btn btn-warning" onclick="myFunction()">点我</a>
            </div>
        </form>
        <hr>
        <ul>
            @foreach($feedbacks as $f)
                <li>{{ $f->id }}: {{ str_limit($f->content, 20) }} -----
                                  {{ str_limit($f->reply, 20) }} -----
                                  {{ $f->user->nickname }} -----
                                  {{ $f->user->cellphone }} -----
                                  {{ $f->user->email }}</li>
            @endforeach
        </ul>
        {{ $feedbacks->render() }}
    </div>
@endsection

@section('js')
    <script type="text/javascript">
    $(document).ready(function() {
        // 搜索关键字
        if (localStorage.keyword) {
            $("input[name=keyword]").val(localStorage.keyword);
        }

        // 按时间排序
        if (localStorage.field_date) {
            $("input[name=field_date]").prop('checked', true);
        }

        // 搜索当天结果
        if (localStorage.field_today) {
            $("input[name=field_today]").prop('checked', true);
        }

        $("button").click(function(event) {
            // 搜索关键字
            if ($("input[name=keyword]").val()) {
                localStorage.keyword = $("input[name=keyword]").val();
            } else {
                localStorage.removeItem('keyword');
            }

            // 按时间排序
            if ($("input[name=field_date]").prop('checked')) {
                localStorage.field_date = $("input[name=field_date]").val(true);
            } else {
                localStorage.removeItem('field_date');
            }

            // 搜索当天结果
            if ($("input[name=field_today]").prop('checked')) {
                localStorage.field_today = $("input[name=field_today]").val(true);
            } else {
                localStorage.removeItem('field_today');
            }

        });
    });
    </script>
@endsection
