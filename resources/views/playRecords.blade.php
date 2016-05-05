@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
          <li>用户管理</li>
          <li>学生弹奏记录</li>
        </ol>
    <table class="table table-bordered table-hover">
        <tr>
            <th>乐曲名</th>
            <th>用户姓名</th>
            <th>WAV文件路径</th>
            <th>MIDI文件路径</th>
            <th>弹奏时间</th>
        </tr>
        @forelse($play_records as $item)
            <tr>
                <td>{{ $item->music->name or '-' }}</td>
                <td><a href="basicinfo/{{ $item->user->uid or '#' }}">{{ $item->user->nickname or '-' }}</a></td>
                <td><a href="{{ $item->wav_path }}">{{ $item->wav_path }}</a></td>
                <td>

                    @forelse($item->midi_path as $item_midi)
                        <a href="{{ $item_midi }}">{{ $item_midi }}</a><br>
                    @empty

                    @endforelse
                </td>
                <td>{{ $item->practice_time }}</td>
            </tr>
        @empty

        @endforelse
    </table>
    <div class="text-center">
        {!! $play_records->render() !!}
    </div>

</div>
@endsection

@section('css')
    <style media="screen">
        th, tr, td {
            white-space: nowrap;
        }
    </style>
@endsection
