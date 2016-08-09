@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
          <li>用户管理</li>
          <li>学生弹奏记录</li>
        </ol>
        <form class="" action="playRecords" method="get">
            <div class="form-group form-inline">
                <div class="">精确搜索: </div>
                <select class="form-control col-md-1" name="search_condition">
                    <option value="music_name">乐曲名</option>
                    <option value="origin_midi_path">源MIDI路径</option>
                    <option value="match_midi_path">匹配后MIDI路径</option>
                </select>
                &nbsp;<input type="text" class="form-control col-md-1" id="searchName" name="name" placeholder="请输入曲目名">
                <input type="hidden" name="field" value="uid">
                <input type="hidden" name="order" value="asc">
            <!-- <div class="container"> -->
                <div class="col-md-3 col-md-offset-1 date_left">
                    <div class="form-group">
                        <div class='input-group date' id='datetimepicker6'>
                            <input type='text' class="form-control" name="from_time" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class='col-md-3 date_right'>
                    <div class="form-group">
                        <div class='input-group date' id='datetimepicker7'>
                            <input type='text' class="form-control" name="to_time"/>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <button type="submit" name="button" class= "btn btn-success" id="search">搜索</button>
            </div>
            <!-- </div> -->
        </form>
    <table class="table table-bordered table-hover">
        <tr>
            <th>乐曲名</th>
            <th>用户姓名</th>
            {{-- <th>用户ID</th> --}}
            <th>WAV文件路径</th>
            <th>源MIDI文件路径</th>
            <th>匹配后的MIDI文件路径</th>
            <th>弹奏时间</th>
            <th>日期</th>
        </tr>
        @forelse($play_records as $item)
            <tr>
                <td>{{ $item->music->name or '-' }}</td>
                <td><a href="basicinfo/{{ $item->uid or '#' }}">{{ $item->user->nickname or $item->uid }}</a></td>
                <td><a href="http://120.26.243.208{{ $item->wav_path }}">{{ $item->wav_path }}</a></td>
                <td>
                    @forelse($item->origin_midi_path as $item_midi)
                        <a href="http://120.26.243.208{{ $item_midi }}">{{ $item_midi }}</a><br>
                    @empty

                    @endforelse
                </td>
                <td>
                    @forelse($item->midi_path as $item_midi)
                        <a href="http://120.26.243.208{{ $item_midi }}">{{ $item_midi }}</a><br>
                    @empty

                    @endforelse
                </td>
                <td>{{ $item->practice_time }}</td>
                <td>
                    {{ $item->practice_date }}
                </td>
            </tr>
        @empty

        @endforelse
    </table>
    <div class="text-center">
        {!! $play_records->render() !!}
    </div>

</div>
@endsection

@section('js')
    <script src="{{ elixir('js/playRecords.js') }}"></script>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ elixir('css/playRecords.css') }}">
    <style media="screen">
        /*th, tr, td {
            white-space: nowrap;
        }*/
    /*.date_left, .date_right {
        padding-left: 0;
        padding-right: 0;
    }*/
    </style>
@endsection
