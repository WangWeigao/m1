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
        <table class="table table-bordered table-striped">
            @forelse($feedbacks as $index => $feedback)
                @if($index === 0)
                    <tr>
                        <th>全部</th>
                        <th>日期</th>
                        <th>用户账号</th>
                        <th>手机号</th>
                        <th>邮箱</th>
                        <th>最新反馈内容</th>
                        <th>最新回复</th>
                        <th>操作</th>
                    </tr>
                @endif
                <tr>
                    <td><input type="checkbox" name="" id=""></td>
                    <td>{{ $feedback->created_at }}</td>
                    <td>{{ $feedback->user->nickname }}</td>
                    <td>{{ $feedback->user->cellphone }}</td>
                    <td>{{ $feedback->user->email }}</td>
                    <td><abbr title="{{ $feedback->content }}">{{ str_limit($feedback->content, 15) }}</abbr></td>
                    <td><abbr title="{{ $feedback->reply }}">{{ str_limit($feedback->reply, 15) }}</abbr></td>
                    <td>
                        <select class="form-control" name="">
                            <option value="">回复</option>
                            <option value="">谢谢您的反馈,我们会尽快完善曲库</option>
                            <option value="">谢谢您的反馈,我们会尽快解决您的问题</option>
                            <option value="">我们已添加您所需的曲目,请尽快享用</option>
                            <option value="">手动回复</option>
                        </select>
                    </td>
                </tr>

            @empty
                <blockquote>没有查询结果</blockquote>
            @endforelse
        </table>
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
