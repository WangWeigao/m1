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

                {{-- 日期选择插件 --}}
                <div class="input-daterange input-group" id="datepicker">
                    <input type="text" class="form-control" name="from_time" v-model="from_time" data-value="{{ Input::get('from_time') }}"/>
                    <span class="input-group-addon">to</span>
                    <input type="text" class="form-control" name="to_time" v-model="to_time"  data-value="{{ Input::get('to_time') }}"/>
                </div>

                <button type="submit" name="button" class= "btn btn-success" id="search">搜索</button>
            </div>
            <!-- </div> -->
        </form>
    <table class="table table-bordered table-hover">
        @forelse($play_records as $index => $item)
            @if($index === 0)
                <tr>
                    <th>乐曲名</th>
                    <th>用户ID</th>
                    <th>用户姓名</th>
                    <th>WAV文件路径</th>
                    <th>源MIDI文件路径</th>
                    <th>匹配后的MIDI文件路径</th>
                    <th>弹奏时间</th>
                    <th>日期</th>
                </tr>

            @endif
            <tr>
                <td>{{ $item->music->name or '-' }}</td>
                <td><a href="basicinfo/{{ $item->uid or '#' }}">{{ $item->uid }}</a></td>
                <td><a href="basicinfo/{{ $item->uid or '#' }}">{{ $item->user->nickname or '-' }}</a></td>
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
            <center>
                <br>
                <h3>暂无查询结果</h3>
            </center>
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
