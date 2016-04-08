@extends('layouts.app')

@section('content')
    <table class="table table-bordered table-hover">
        <tr>
            <th>乐曲名</th>
            <th>WAV文件路径</th>
            <th>MIDI文件路径</th>
            <th>弹奏时间</th>
        </tr>
        @forelse($play_records as $item)
            <tr>
                <td>{{ $item->music->name }}</td>
                <td><a href="{{ $item->wav_path }}">{{ $item->wav_path }}</a></td>
                <td>
                    @forelse($item->midi_path as $item_midi)
                        <a href="{{ $item_midi }}">{{ $item_midi }}</a><br>
                    @empty

                    @endforelse
                </td>
                <td>{{ $item->start_time }}</td>
            </tr>
        @empty

        @endforelse
    </table>
    {{-- "点击展开"的弹窗 --}}
    {{-- <div class="modal fade"	id="midis">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
                    @forelse($variable as $key => $value)

                    @empty

                    @endforelse
				</div>
			</div>
		</div>
    </div> --}}
@endsection
