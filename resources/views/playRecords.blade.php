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
                <td>{{ $item->music->name or '' }}</td>
                <td><a href="{{ $item->wav_path }}">{{ $item->wav_path }}</a></td>
                <td>
                    {{-- <div class="panel-group" id="accordion">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="penal-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                        点击我就可以展开拉
                                    </a>
                                </h4>
                            </div>
                            <div class="panel-collapse collapse in" id="collapse">
                                <div class="panel-body">

                                </div>
                            </div>
                        </div>

                    </div> --}}
                    @forelse($item->midi_path as $item_midi)
                        <a href="{{ $item_midi }}">{{ $item_midi }}</a><br>
                    @empty

                    @endforelse

{{-- <div class="panel-group" id="accordion"> --}}
  {{-- <div class="panel">
    <div class="panel-heading">
        <a data-toggle="collapse" href="#collapseOne">
          点击我进行展开，再次点击我进行折叠。第 1 部分
        </a>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" name="testname[]">
      <div class="panel-body">
          @forelse($item->midi_path as $item_midi)
              <a href="{{ $item_midi }}">{{ $item_midi }}</a><br>
          @empty

          @endforelse
      </div>
    </div>
  </div> --}}
{{-- </div> --}}
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
