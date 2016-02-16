@extends('layouts.app')
@section('content')
    <div class="container">
        {{-- 用户查询表单 --}}
        <form class="" action="/music" method="get">
            {!! csrf_field() !!}
            <fieldset>
                <legend>曲目查询</legend>
                <div class="form-group">
                    {{-- <label for="">用户搜索</label> --}}
                    <input type="text" class="form-control" id="searchName" name="name" placeholder="请输入曲目名称或作曲家">
                    <input type="hidden" name="field" value="uid">
                    <input type="hidden" name="order" value="asc">
                </div>
                <button type="submit" name="button" class="btn btn-success" id="search">搜索</button>
            </fieldset>
        </form>
        <hr>

        @if(!empty($name))
            <table class="table table-hover">
              <thead>
                  <tr>
                      <th>曲目名称</th>
                      <th>作者家</th>
                      <th>音频文件</th>
                  </tr>
              </thead>
              <tfoot>
                  <tr>
                      <th>曲目名称</th>
                      <th>作者家</th>
                      <th>音频文件</th>
                  </tr>
              </tfoot>
              <tbody>
                  @foreach($data as $item)
                      <tr>
                          <td>{{ $item->name }}</td>
                          <td>{{ $item->auth }}</td>
                          <td>{{ $item->filename }}</td>
                      </tr>
                  @endforeach
              </tbody>
            </table>
        @endif
    </div>
@endsection
