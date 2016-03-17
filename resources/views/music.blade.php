@extends('layouts.app')
@section('content')
    <div class="container">
        {{-- 用户查询表单 --}}
        <form class="" action="/music" method="get">
            {!! csrf_field() !!}
            <div class="breadcrumb">
                <li>曲库管理</li>
                <li class="active">曲库列表</li>
            </div>
            {{-- <fieldset> --}}
                {{-- <legend>曲目查询</legend> --}}
                <div class="form-group form-inline">
                    {{-- <label for="">用户搜索</label> --}}
                    <span>精确搜索: </span><input type="text" class="form-control" id="searchName" name="name" placeholder="请输入曲目名">
                    <input type="hidden" name="field" value="uid">
                    <input type="hidden" name="order" value="asc">
                    <button type="submit" name="button" class= "btn btn-success" id="search">搜索</button>
                </div>
            {{-- </fieldset> --}}
        </form>
        <form class="form-group" action="/music" method="get">
            {!! csrf_field() !!}
            <table class="table">
                <tr>
                    <td>
                        <span>筛选待件:</span>
                    </td>
                    <td>
                        <input type="checkbox" name="instrument" id="input_instrument">
                        <label for="input_instrument">乐器</label>
                        <select id="instrument">
                            <option value="0">请选择</option>
                        </select>
                    </td>
                    <td>
                        <input type="checkbox" name="press" id="input_press">
                        <label for="input_press">出版社</label>
                        <select id="press">
                            <option>请选择</option>
                        </select>
                    </td>
                    <td>
                        <input type="checkbox" name="category" id="input_category">
                        <label for="input_category">乐曲类别</label>
                        <select id="category">
                            <option>请选择</option>
                        </select>
                    </td>
                    <td>
                        <input type="checkbox" name="onshelf" id="input_onshelf">
                        <label for="input_onshelf">乐曲状态</label>
                        <select id="onshelf">
                            <option value="">请选择</option>
                            <option value="1">已上架</option>
                            <option value="0">待审核</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                    </td>
                    <td>
                        <input type="checkbox" name="organizer" id="input_organizer">
                        <label for="input_organizer">主办机构</label>
                        <select id="organizer">
                            <option>请选择</option>
                        </select>
                    </td>
                    <td>
                        <input type="checkbox" name="operator" id="input_operator">
                        <label for="input_operator">操作人</label>
                        <select id="operator">
                            <option>请选择</option>
                        </select>
                    </td>
                    <td>
                        <input type="checkbox" name="date" id="date">
                        <label for="date">添加日期</label>
                        <span id="dateSelector">
                            <select id="idYear" data=""></select>年
                            <select id="idMonth" data=""></select>月
                            <select id="idDay" data=""></select>日
                        </span>
                    </td>
                    <td>
                        <button type="submit" id="condation_search" class="btn btn-success">搜索</button>
                    </td>
                </tr>
            </table>
        </form>

        @if(!empty($musics))
            @if(count($musics) > 0)
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>乐器</th>
                            <th>乐曲名</th>
                            <th>作曲人</th>
                            <th>版本</th>
                            <th>出版社</th>
                            <th>主办机构</th>
                            <th>乐曲类别</th>
                            <th>midi地址</th>
                            <th>添加日期</th>
                            <th>乐曲状态</th>
                            <th>操作</th>
                            <th>操作人</th>
                            <th>备注</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($musics as $item)
                            <tr id="{{ $item->id }}">
                                <td>{{ $item->instrument->name }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->composer }}</td>
                                <td>{{ $item->version }}</td>
                                <td>{{ $item->press->name }}</td>
                                <td>{{ $item->organizer->name }}</td>
                                <td>
                                    @foreach($item->tags as $tag)
                                        <span class="">{{ $tag->name }}</span>
                                    @endforeach
                                </td>
                                <td><a href="#">{{ $item->filename }}</a></td>
                                <td>{{ $item->created_at }}</td>
                                <td>{{ $item->onshelf ? "已上架" : "待审核" }}</td>
                                <td>
                                    <button class="btn btn-xs btn-info edit" data-toggle="modal" data-target="#editPopup" data-backdrop="static">
                                        <span class="glyphicon glyphicon-edit"></span> 编辑
                                    </button>
                                    {{-- <button class="btn btn-xs btn-info delete"> --}}
                                        {{-- <span class="glyphicon glyphicon-remove"></span> 删除 --}}
                                    {{-- </button> --}}
                                </td>
                                <td>{{ $item->user->name }}</td>
                                <td>
                                    {{ $item->note or ""}}
                                </td>
                                @if(!empty($item->note_content))
                                    <td>{{ $item->editor['name'] }} : {{ $item->note_content }}</td>
                                @else
                                    <td></td>
                                @endif
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
        <div id="add_one_mucis" class="btn btn-success" data-toggle="modal" data-target="#newPopup" data-backdrop="static">添加单个乐曲</div>
        <div id="add_multi_musics" class="btn btn-success">添加多个乐曲</div>

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
                          <th>乐器</th>
                          <th>乐曲名</th>
                          <th>作曲人</th>
                          <th>版本</th>
                          <th>出版社</th>
                          <th>乐曲类别</th>
                          <th>备注</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                          <form id="save_detail">
                              <input type="hidden" id="edit_id">
                              <td id="edit_instrument"></td>
                              <td><input type="text" id="edit_name"></td>
                              <td><input type="text" id="edit_composer"></td>
                              <td><input type="text" id="edit_version"></td>
                              <td><input type="text" id="edit_press"></td>
                              <td><input type="text" id="edit_category"></td>
                              <td><input type="text" id="edit_notes"></td>
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
				    <h4 class="modal-title" id="myModalLabel">添加单个曲目</h4>
				</div>
				<div class="modal-body">
                    <form class="form-horizontal" id="add_music">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <label for="add_instrument" class="col-sm-2 control-label">乐器</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="add_instrument" name="instrument">
                                    <option value="0">请选择</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="add_name" class="col-sm-2 control-label">乐曲名</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="add_name" name="name" placeholder="请输入乐曲名称">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="add_composer" class="col-sm-2 control-label">作曲人</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="add_composer" name="composer" placeholder="请输入乐曲作者">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="add_version" class="col-sm-2 control-label">版本</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="add_version" name="version" placeholder="请输入版本号">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="add_press" class="col-sm-2 control-label">出版社</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="add_press" name="press">
                                    <option value="0">请选择</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="add_organizer" class="col-sm-2 control-label">主办单位</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="add_organizer" name="organizer">
                                    <option value="0">请选择</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="add_category" class="col-sm-2 control-label">乐曲类别</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="add_category" name="category">
                                    <option value="0">请选择</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="add_note_content" class="col-sm-2 control-label">备注</label>
                            <div class="col-sm-10">
                                <input type="text" name="note_content" value="" id="add_note_content" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="add_midi_file" class="col-sm-2 control-label">mid文件</label>
                            <div class="col-sm-10">
                                <input type="file" name="midi_file" value="" id="add_midi_file" class="form-control">
                            </div>
                        </div>
                        <div class="" id="add_result"></div>
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

@section('css')
    <style media="screen">
        th {
            /*width: 300px;*/
        }
    </style>
    <link href="http://hayageek.github.io/jQuery-Upload-File/4.0.10/uploadfile.css" rel="stylesheet">
    <link rel="stylesheet" href="http://cdn.staticfile.org/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" media="screen" title="no title" charset="utf-8">
@endsection

@section('js')
    <script src="http://hayageek.github.io/jQuery-Upload-File/4.0.10/jquery.uploadfile.min.js"></script>
    <script src="http://cdn.staticfile.org/moment.js/2.10.6/moment.min.js"></script>
    <script src="http://cdn.staticfile.org/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
    <script src="{{ elixir('js/music.js') }}"></script>
@endsection
