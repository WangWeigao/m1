@extends('layouts.app')

@section('content')
    <div class="container">
        <form class="" action="/auto_test_wav" method="get">
            {{ csrf_field() }}
            <div class="form-group">
              <label for="user_id">用户ID</label>
              <input type="text" class="form-control" id="user_id" name="user_id" placeholder="请填写用户ID, 如 666" value="{{ $user_id or '' }}">
              {{-- <p class="help-block">用户ID可以在<a href="/user">用户管理</a>中查询</p> --}}
            </div>
            <div class="form-group">
              <label for="wav_name">WAV名称</label>
              <input type="text" class="form-control" id="wav_name" name="wav_name" placeholder="wav文件名称, 如 1234.wav" value="{{ $wav_name or '' }}">
              {{-- <p class="help-block">填写wav文件名称，如 1234.wav</p> --}}
            </div>
            <button type="submit" class="btn btn-info">查询</button>
        </form>
        <br>
        <center>
            <div class="alert alert-success"><h4></h4></div>
        </center>
        <div class="">
            @if(count($practice) > 0)
                <table class="table table-bordered">
                    <tr>
                        <th>乐曲名</th>
                        <th>用户姓名</th>
                        <th>用户ID</th>
                        <th>弹奏时长</th>
                        <th>WAV文件路径</th>
                        <th>录音日期</th>
                        <th>操作</th>
                    </tr>
                    <tr>
                        <td>{{ $practice->music->name or '' }}</td>
                        <td>{{ $practice->user->nickname or '' }}</td>
                        <td>{{ $practice->uid or '' }}</td>
                        <td>{{ $practice->practice_time or '' }}</td>
                        <td><a href="http://120.26.243.208{{ $practice->wav_path or '' }}">{{ $practice->wav_path or '' }}</a></td>
                        <td>{{ $practice->practice_date or '' }}</td>
                        <td>
                            {{-- <button class="btn btn-success" data-pid="{{ $practice->pid }}" data-uid="{{ $practice->uid }}" name="generate_midi" {{ $midi_exists ? 'disabled' : '' }}>生成midi</button> --}}
                            <button class="btn btn-success" data-pid="{{ $practice->pid }}" data-uid="{{ $practice->uid }}" name="sub_match">匹配一次</button>
                        </td>
                    </tr>
                </table>
                <!-- 若存在测试记录，则显示 -->
                @if(count($results) > 0)
                    <table class="table table-striped">
                        <tr>
                            <th>n</th>
                            <th>s</th>
                            <th>c</th>
                            <th>w</th>
                            {{-- <th>源MIDI文件路径</th> --}}
                            <th>转换后的MIDI文件路径</th>
                            <th>匹配分</th>
                            <th>BPM分</th>
                            <th>时间</th>
                        </tr>
                        @foreach($results as $result)
                            <tr>
                                <td>{{ $result->param_n or '' }}</td>
                                <td>{{ $result->param_s or '' }}</td>
                                <td>{{ $result->param_c or '' }}</td>
                                <td>{{ $result->param_w or '' }}</td>
                                {{-- <td><a href="{{ $result->origin_midi_path or '' }}">{{ $result->origin_midi_path or '' }}</a></td> --}}
                                <td><a href="http://120.26.243.208/midis/{{ $result->midi_path or '' }}">{{ $result->midi_path or '' }}</a></td>
                                <td>{{ $result->match_score or '' }}</td>
                                <td>{{ $result->bpm_score or '' }}</td>
                                <td>{{ $result->created_at or '' }}</td>
                            </tr>
                        @endforeach
                    </table>
                    <center>
                        {{ $results->render() }}
                    </center>
                @else
                    <center>
                        <h3>没有查询到相关的测试数据</h3>
                    </center>
                @endif
            @elseif(!is_null($practice))

            @else
                <center>
                    <h3>没有这条练习记录，调整查询条件再试试吧</h3>
                </center>
            @endif
        </div>
    </div>
@endsection

@section('js')
<script type="text/javascript">
    $(document).ready(function() {
        // // 生成midi
        // $("button[name=generate_midi]").click(function() {
        //     // 显示提示框
        //     function open() {
        //         $(".alert").slideDown(1000);
        //     }
        //
        //     // 关闭提示框
        //     function close() {
        //         $(".alert").slideUp(1000);
        //     }
        //
        //     // 更改按钮显示信息
        //     $("button[name=generate_midi]").html('正在生成midi...');
        //     // 禁用按钮
        //     $("button[name=generate_midi]").prop('disabled', true);
        //
        //     $.ajax({
        //         url: "{{ url('/auto_test_wav/midiIsGenerated') }}",
        //         type: 'POST',
        //         // dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
        //         dataType: 'json',
        //         data: {
        //             wav: "{{ $wav_name or '' }}",
        //             uid: $(".btn-success").attr('data-uid'),
        //             pid: $(".btn-success").attr('data-pid')
        //         },
        //         headers: {
        //             'X-CSRF-Token': $("input[name=_token]").val()
        //         }
        //     })
        //     .done(function(data) {
        //         // 更改提示信息
        //         $(".alert h4").html('已经生成MIDI文件');
        //         // 更改"匹配一次"按钮的状态
        //         $("button[name=sub_match]").removeAttr('disabled');
        //     })
        //     .fail(function() {
        //         // 显示错误信息，并将类更改成alert-danger
        //         $(".alert h4").html('生成MIDI失败');
        //         $(".alert").attr('class', 'alert alert-danger');
        //         // 生成midi失败，允许再次执行此操作
        //         $("button[name=generate_midi]").removeAttr('disabled');
        //     })
        //     .always(function() {
        //         // 恢复按钮的文字
        //         $("button[name=generate_midi]").html('生成midi');
        //         // 显示提示信息
        //         open();
        //         setTimeout(close, 5000)
        //     });
        //
        // });



        // 匹配一次
        $("button[name=sub_match]").click(function() {
            // 禁用按钮
            $("button[name=sub_match]").attr('disabled', true);
            $("button[name=sub_match]").html('正在匹配...');

            // 打开提示框
            function open() {
                $(".alert").slideDown(1000);
            }
            // 关闭提示框
            function close() {
                $(".alert").slideUp(1000);
            }

            // 移除disabled属性，恢复按钮可点击状态
            function removeAttr() {
                $("button[name=sub_match]").removeAttr('disabled');
            }

            $.ajax({
                url: "{{ url('/auto_test_wav/generateAndMatchMidi') }}",
                type: 'POST',
                dataType: 'json',
                data: {
                    wav: "{{ $wav_name or '' }}",
                    uid: $(".btn-success").attr('data-uid'),
                    pid: $(".btn-success").attr('data-pid')
                },
                headers: {
                    'X-CSRF-Token': $("input[name=_token]").val()
                }
            })
            .done(function() {
                // 禁用"匹配一次"按钮，10秒后恢复
                setTimeout(removeAttr, 10000);

                // 添加提示信息
                $(".alert h4").html('请稍候刷新页面查询结果');
                $(".alert").attr('class', 'alert alert-success');
            })
            .fail(function() {
                // 禁用"匹配一次"按钮，2秒后恢复
                setTimeout(removeAttr, 2000);

                // 添加提示信息
                $("h4").html('啊哦，服务器出错了，稍等一会再试吧');
                $(".alert").attr('class', 'alert alert-danger');
            })
            .always(function() {
                // 恢复"匹配一次"按钮状态
                $("button[name=sub_match]").html('匹配一次');

                // 显示提示信息, 5秒后关闭
                open();
                setTimeout(close, 9000);
            });
        });
    });
</script>
@endsection

@section('css')
    <style media="screen">
        div.alert {
            display: none;
        }
    </style>
@endsection
