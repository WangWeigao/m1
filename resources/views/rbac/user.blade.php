@extends('layouts.app')

@section('content')
<div class="container">
    <table class="table">
        {{ csrf_field() }}
        <thead>
            <th>ID</th>
            <th>用户名</th>
            <th>邮箱</th>
            <th>所属角色</th>
            <th>创建时间</th>
            <th>操作</th>
        </thead>
        <tbody>
            @foreach($users as $key => $user)
                <tr id="{{ $user->id }}">
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @foreach($user->roles as $role)
                            <div id="{{ $role->id }}">
                                {{  $role->name  }}
                            </div>
                        @endforeach
                    </td>
                    <td>{{ $user->created_at }}</td>
                    <td>
                        <button class="btn btn-xs btn-info rbac_edit" data-toggle="modal" data-target="#editPopup" data-backdrop="static">
                            <span class="glyphicon glyphicon-edit"></span> 编辑
                         </button>
                        {{-- <button class="btn btn-xs btn-info rbac_remove"> --}}
                            {{-- <span class="glyphicon glyphicon-remove"></span> 删除 --}}
                         {{-- </button> --}}
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
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
                          <th>ID</th>
                          <th>用户名</th>
                          <th>邮箱</th>
                          <th>角色名称</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                          <form id="save_detail">
                              <td><input type="hidden" id="rbac_id"></td>
                              <td><input type="text" id="rbac_name"></td>
                              <td><input type="text" id="rbac_email"></td>
                              {{-- <td><input type="text" id="rbac_role"></td> --}}
                              <td>
                                  <input type="hidden" id="rbac_origin_role">
                                  <select id="rbac_role">
                                      @foreach($roles as $key => $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                      @endforeach
                                  </select>
                              </td>
                          </form>
                      </tr>
                  </tbody>
              </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="rbac_save" data-dismiss="modal">保存修改</button>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
