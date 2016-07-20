@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="panel panel-default panel-info">
          <div class="panel-heading">
            <h3 class="panel-title">乐器列表</h3>
          </div>
          {{-- <div class="panel-body"> --}}
                @if(count($instruments) > 0)
                    <table class="table table-hover">
                        <tr>
                            <th>ID</th>
                            <th>乐器名称</th>
                            <th>操作</th>
                        </tr>
                        @foreach($instruments as $i)
                            <tr>
                                <td>{{ $i->id }}</td>
                                <td>{{ $i->name }}</td>
                                <td>
                                    <a href="/instrument/{{$i->id}}/edit" class="btn btn-default btn-xs">编辑</a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @endif
          {{-- </div> --}}
          <div class="panel-footer">
              <a href="/instrument/create" class="btn btn-default">添加乐器</a>
          </div>
        </div>
    </div>
@endsection
