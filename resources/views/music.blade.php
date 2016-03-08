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

        {{-- @if(!empty($name)) --}}
        {{-- <div class="panel panel-success"> --}}
            {{-- <div class="panel-heading clearfix" > --}}
                {{-- <div class="pull-left"> --}}
                    {{-- <button class="btn btn-success" data-toggle="modal" data-target="#newPopup" data-backdrop="static">New</button> --}}
                    {{-- <button class="btn btn-warning">Disable</button>
                    {{-- <button class="btn btn-danger">Delete</button> --}}
                    {{-- <div id="addResult"></div> --}}
                {{-- </div> --}}
            {{-- </div> --}}
            {{-- <div class="panel-body"> --}}
            {{-- </div> --}}
            {{-- <div class="panel-footer"> --}}
            {{-- </div> --}}
        {{-- </div> --}}
        {{-- @endif --}}
        @if(!empty($name))
            @if(count($musics) > 0)
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>曲目名称</th>
                            <th>作者家</th>
                            <th>音频文件</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($musics as $item)
                            <tr id="{{ $item->id }}">
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->author }}</td>
                                <td><a href="#">{{ $item->filename }}</a></td>
                                <td>
                                    <button class="btn btn-xs btn-info edit" data-toggle="modal" data-target="#editPopup" data-backdrop="static">
                                        <span class="glyphicon glyphicon-edit"></span> 编辑
                                    </button>
                                    <button class="btn btn-xs btn-info delete">
                                        <span class="glyphicon glyphicon-remove"></span> 删除
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="text-center">
                    {!! $musics->render() !!}
                </div>

            @else
                <div class="text-center blockquote">
                    没有查到相关结果，更换搜索关键词再试试吧
                </div>
            @endif
        @endif
    {{-- 编辑窗口 --}}
    <div class="modal fade" id="editPopup">
      <div class="modal-dialog" style="width: auto">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id=""></h4>
          </div>
          <div class="modal-body">
              <table class="table">
                  <thead>
                      <tr>
                          <th>曲目名称</th>
                          <th>作者家</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                          <form id="save_detail">
                              <td><input type="text" id="edit_title" placeholder="曲目名称"></td>
                              <td><input type="text" id="edit_author"></td>
                              <input type="hidden" id="edit_id">
                          </form>
                      </tr>
                  </tbody>
              </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="save" data-dismiss="modal">保存修改</button>
          </div>
        </div>
      </div>
    </div>
    {{-- New的弹窗 --}}
    <div class="modal fade"	id="newPopup">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
				    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				    <h4 class="modal-title" id="myModalLabel">添加曲目</h4>
				</div>
				<div class="modal-body">
                    <form class="form-horizontal" id="add_music">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <label for="musicName" class="col-sm-2 control-label">名称</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="title" name="title" placeholder="请输入乐曲名称">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="musicAuthor" class="col-sm-2 control-label">作者</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="author" name="author" placeholder="请输入乐曲作者">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="musicFile" class="col-sm-2 control-label">音频文件</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" id="midi-file" name="midi-file" placeholder="上传音频文件">
                            </div>
                        </div>
                    </form>
				</div>
				<div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" id="createMusic">创建</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
				</div>
			</div>
		</div>
    </div>
</div>
@endsection
