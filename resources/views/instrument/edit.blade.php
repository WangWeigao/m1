@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="panel panel-default panel-info">
          <div class="panel-heading">
            <h3 class="panel-title">修改乐器名称</h3>
          </div>
          <div class="panel-body">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
              <form class="" action="/instrument/{{ $id }}" method="post">
                  {{ csrf_field() }}
                  {{ method_field('put') }}
                  <div class="form-group">
                    <label for="instrument_name">乐器名称</label>
                    <input type="text" class="form-control" id="instrument_name" name="name" placeholder="{{ $name }}" value="{{ old('name') }}">
                    <p class="help-block">填写如"钢琴", "吉它"这样的名称</p>
                  </div>
                  <button type="submit" class="btn btn-success">更新</button>
              </form>
          </div>
          {{-- <div class="panel-footer"> --}}
              {{-- <a href="/instrument/create" class="btn btn-default">添加乐器</a> --}}
          {{-- </div> --}}
        </div>
    </div>
@endsection
