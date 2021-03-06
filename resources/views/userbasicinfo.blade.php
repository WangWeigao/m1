@extends('layouts.app')

@section('content')
<div class="container">
    <ol class="breadcrumb">
      <li>用户管理</li>
      <li><a href="/user">学生列表</a></li>
      <li class="active">用户详情</li>
    </ol>

    {{-- 标签栏 --}}
    <div class="text-center">
        <div class="btn-group btn-group-lg">
            <a href="/user/basicinfo/{{ $user->uid }}" class="btn btn-default active">基本信息</a>
            <a href="/user/actionhistory/{{ $user->uid }}" class="btn btn-default">活动历史</a>
            <a href="/user/recordhistory/{{ $user->uid }}" class="btn btn-default">成绩历史</a>
            <a href="/user/orderhistory/{{ $user->uid }}" class="btn btn-default">订单历史</a>
            <a href="/user/socialhistory/{{ $user->uid }}" class="btn btn-default" disabled>社交历史</a>
        </div>
    </div>
{!! csrf_field() !!}
    <h3>基本信息</h3>
    <table class="table table-hover">
        <tr>
            <td class="col-sm-3">编号</td>
            <td class="col-sm-9">{{ $user->uid }}</td>
        </tr>
        <tr>
            <td>头像</td>
            <td>
                @if(!empty($user->avatar))
                    <img src="/avatar/{{ $user->avatar }}" alt="头像" height="50"/>&nbsp;&nbsp;
                    <button type="button">查看大图</button>
                @else
                    暂无头像
                @endif
            </td>
        </tr>
        <tr>
            <td>用户名</td>
            <td>{{ $user->nickname }}</td>
        </tr>
        <tr>
            <td>手机号</td>
            <td>{{ $user->cellphone }}</td>
        </tr>
        <tr>
            <td>电子邮箱</td>
            <td>{{ $user->email }}</td>
        </tr>
        <tr>
            <td>性别</td>
            <td>{{ $user->sex }}</td>
        </tr>
        <tr>
            <td>学龄</td>
            <td>{{ $user->study_age }}</td>
        </tr>
        <tr>
            <td>水平等级</td>
            <td>{{ $user->user_grade }}</td>
        </tr>
        <tr>
            <td>指定乐器</td>
            <td>
                {{-- @if(!empty($user->instrument_id))
                    @foreach($user->instrument_id as $value)
                        {{ $value['name'] }}&nbsp;
                    @endforeach
                @else
                    暂无
                @endif --}}
                {{ $user->instrument_id }}
            </td>
        </tr>
        <tr>
            <td>注册日期</td>
            <td>{{ $user->regdate }}</td>
        </tr>
        <tr>
            <td>账号级别</td>
            <td>{{ $user->account_grade }}</td>
        </tr>
        <tr>
            <td>账号截止日期</td>
            <td>{{ $user->account_end_at }}</td>
        </tr>
        <tr>
            <td>本月使用时长</td>
            <td>
                @forelse($user->duration_month as $value)
                    {{ $value->sum_duration }}
                @empty
                    0
                @endforelse
            </td>
        </tr>
        <tr>
            <td>状态</td>
            <td>{{ $user->status }}</td>
        </tr>
        <tr>
            <td>操作</td>
            <td>
                <button type="button" class="btn lockuser {{ $user->isactive ?  'btn-danger' : 'btn-info' }}" id="{{ $user->uid }}">{{ $user->isactive ? '锁定' : '解锁' }}</button>
                <button type="button" class="btn btn-default" id="notifyuser"  data-toggle="modal" data-target=".m_notify_all" data-value="{{ $user->uid }}">通知</button>
            </td>
        </tr>
    </table>

    {{-- 通知选中用户，模态框 --}}
    <div class="modal fade m_notify_all" id="" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="">通知内容</h4>
          </div>
          <div class="modal-body">
              <div class="form-group">
                  <select class="form-control" name="" id="select_multi">
                      <option value="1">通知账号到期</option>
                      <option value="2">通知资料到期</option>
                      <option value="3">通知违规与禁言</option>
                      <option value="4">通知重新提交资料，并输入理由</option>
                  </select>
                  <input type="hidden" class="form-control" name="message" value="" placeholder="请输入理由">
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="send_message">发送通知</button>
          </div>
        </div>
      </div>
    </div>

</div>
@endsection

@section('css')

@endsection

@section('js')
    <script src="{{ elixir('js/userbasicinfo.js') }}"></script>
@endsection
