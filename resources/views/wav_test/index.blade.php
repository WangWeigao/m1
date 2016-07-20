@extends('layouts.app')

@section('content')
    <div class="container">
        <form class="" action="/auto_test_wav" method="get">
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
                    </tr>
                    <tr>
                        <td>{{ $practice->music->name or '' }}</td>
                        <td>{{ $practice->user->nickname or '' }}</td>
                        <td>{{ $practice->user->uid or '' }}</td>
                        <td>{{ $practice->practice_time or '' }}</td>
                        <td><a href="{{ $practice->wav_path or '' }}">{{ $practice->wav_path or '' }}</a></td>
                        <td>{{ $practice->practice_date or '' }}</td>
                    </tr>
                </table>
            @endif
            @if(count($results) > 0)
                <table class="table table-striped">
                    <tr>
                        <th>n</th>
                        <th>s</th>
                        <th>c</th>
                        <th>w</th>
                        <th>源MIDI文件路径</th>
                        <th>匹配后的MIDI文件路径</th>
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
                            <td><a href="{{ $result->origin_midi_path or '' }}">{{ $result->origin_midi_path or '' }}</a></td>
                            <td><a href="{{ $result->midi_path or '' }}">{{ $result->midi_path or '' }}</a></td>
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
        </div>
    </div>
@endsection
