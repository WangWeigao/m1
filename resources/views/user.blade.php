@extends('layouts.app')
@section('content')
<div class="container">
    {{-- 面包屑导航 --}}
    <div class="breadcrumb">
        <li>用户管理</li>
        <li class="active">学生列表</li>
    </div>

    {{-- 用户查询表单 --}}
    <form class="" action="/user" method="get" id="search_user">
        {!! csrf_field() !!}
        {{-- <fieldset> --}}
            {{-- <legend>用户查询</legend> --}}
            <div class="form-group form-inline">
                {{-- <label for="">用户搜索</label> --}}
                <div>精确搜索</div>
                <input type="text" class="form-control" id="user_cellphone_email" placeholder="请输入用户名/手机号/电子邮件">
                <button type="button" name="button" class="btn btn-success" id="search">搜索</button>
            </div>
            <div class="form-group form-inline">
                <div>筛选待件</div>
                {{-- 地域 --}}
                <input type="checkbox" name="area" value="" id="area">
                <input type="checkbox" name="province" value="" id="" style="display:none">
                <label for="area">地域</label>
                <select class="" id="province">
                    <option>省份</option>
                </select>
                <select class="" id="city">
                    <option>城市</option>
                </select>
                {{-- 水平等级 --}}
                <input type="checkbox" name="user_grade" value="" id="l-user-grade">
                <label for="l-user-grade">水平等级</label>
                <select class="" id="user_grade">
                    <option value="0">水平等级</option>
                    <option value="1">业余1级</option>
                    <option value="2">业余2级</option>
                    <option value="3">业余3级</option>
                    <option value="4">业余4级</option>
                    <option value="5">业余5级</option>
                    <option value="6">业余6级</option>
                    <option value="7">业余7级</option>
                    <option value="8">业余8级</option>
                    <option value="9">业余9级</option>
                    <option value="10">业余10级</option>
                    <option value="11">专业1级</option>
                    <option value="12">专业2级</option>
                    <option value="13">专业3级</option>
                    <option value="14">专业4级</option>
                    <option value="15">专业5级</option>
                    <option value="16">专业6级</option>
                    <option value="17">专业7级</option>
                    <option value="18">专业8级</option>
                    <option value="19">专业9级</option>
                    <option value="20">专业10级</option>
                </select>
                {{-- 注册时间 --}}
                <input type="checkbox" name="reg_time" value="" id="l-reg-time">
                <label for="l-reg-time">注册时间</label>
                <select class="" id="reg_time">
                    <option value="day">新用户</option>
                    <option value="week">一周内</option>
                    <option value="month">一月内</option>
                    <option value="half_year">半年内</option>
                    <option value="year">一年内</option>
                    <option value="one_more_year">一年以上</option>
                </select>
                {{-- 帐号级别 --}}
                <input type="checkbox" name="account_grade" value="" id="l_account_grade">
                <label for="l_account_grade">帐号级别</label>
                <select class="" name="" id="account_grade">
                    <option value="vip1">VIP1</option>
                    <option value="vip2">VIP2</option>
                    <option value="free">免费</option>
                    <option value="all">全部</option>
                </select>
                {{-- 帐号截止日期 --}}
                <input type="checkbox" name="account_end_at" value="" id="l_account_end_at">
                <label for="l_account_end_at">帐号截止日期</label>
                <select class="" name="" id="account_end_at">
                    <option value="week">一周内</option>
                    <option value="month">一个月内</option>
                    <option value="two_months">二个月内</option>
                </select>
                <input type="hidden" name="field" value="uid">
                <input type="hidden" name="order" value="asc">
            </div>
            <div class="form-group form-inline">
                {{-- 本月使用时长 --}}
                <input type="checkbox" name="month_duration" value="" id="l_month_duration">
                <label for="l_month_duration">本月使用时长</label>
                <select class="" name="" id="month_duration">
                    <option value="1h">1小时以内的</option>
                    <option value="5h">5小时以内的</option>
                    <option value="10h">10小时以内的</option>
                    <option value="30h">30小时以内的</option>
                    <option value="60h">60小时以内的</option>
                    <option value="60h_more">60小时以上</option>
                    <option value="0h">未使用</option>
                </select>
                {{-- 帐号状态 --}}
                <input type="checkbox" name="account_status" value="" id="l_account_status">
                <label for="l_account_status">帐号状态</label>
                <select class="" name="" id="account_status">
                    <option value="near_expire">帐号到期</option>
                    <option value="lock">锁定</option>
                    <option value="normal">正常</option>
                    <option value="expire">未续费</option>
                </select>
                {{-- 本月用时大幅变化 --}}
                <input type="checkbox" name="change_duration" value="" id="l_change_duration" disabled="disabled">
                <label for="l_change_duration">本月用户大幅变化</label>
                <select class="" name="" id="change_duration">
                    <option value="up20h">上升20小时以上</option>
                    <option value="up30h">上升30小时以上</option>
                    <option value="up50h">上升50小时以上</option>
                    <option value="down20h">下降20小时以上</option>
                    <option value="down30h">下降30小时以上</option>
                    <option value="down50h">下降50小时以上</option>
                </select>
                {{-- 活跃度 --}}
                <input type="checkbox" name="liveness" value="" id="l_liveness" disabled="disabled">
                <label for="l_liveness">活跃度</label>
                <select class="" name="" id="liveness">
                    <option value="active_user">活跃用户</option>
                    <option value="sleep_user">休眠用户</option>
                    <option value="death_user">死亡用户</option>
                </select>
            </div>
            <div class="form-group form-inline">
                {{-- 注册时间段 --}}
                <input type="checkbox" name="reg_start_time" value="" id="l_reg_timezone">
                <label for="l_reg_timezone">注册时间段</label>
                <span id="date_start" class="" id="l_reg_timezone">
                    <select class="date_select" id="idYear" data=""></select>年
                    <select class="date_select" id="idMonth" data=""></select>月
                    <select class="date_select" id="idDay" data=""></select>日
                </span>
                <span>到</span>
                <input type="checkbox" name="reg_end_time" value="" style="display: none">
                <span id="date_end" class="">
                    <select class="date_select2" id="idYear2" data=""></select>年
                    <select class="date_select2" id="idMonth2" data=""></select>月
                    <select class="date_select2" id="idDay2" data=""></select>日
                </span>
                <button type="submit" class="btn btn-success" id="search_condition">搜索</button>
            </div>
        {{-- </fieldset> --}}
    </form>
@if(!empty($users))
    <table class="table table-hover">
        <thead>
            @if(count($users) > 0)
                <tr>
                    <th><input type="checkbox" id="checkAll"></th>
                    <th>编号</th>
                    <th>用户账号</th>
                    <th>手机号</th>
                    <th>电子邮箱</th>
                    <th>地区</th>
                    <th>性别</th>
                    <th>学龄</th>
                    <th><a style="cursor:pointer">水平等级</a></th>
                    <th>指定乐器</th>
                    <th><a style="cursor:pointer">注册日期</a></th>
                    <th>账号级别</th>
                    <th><a style="cursor:pointer">账号截止日期</a></th>
                    <th><a style="cursor:pointer">上月使用时长</a></th>
                    <th><a style="cursor:pointer">本月使用时长</a></th>
                    <th>账户状态</th>
                    <th>操作</th>
                </tr>
            @else
                <div class="text-center">
                    没有查询到相关数据，更换查询条件再试试吧
                </div>
            @endif
        </thead>
            <tbody>
                @foreach($users as $user)
                <tr id="{{ $user->uid }}">
                    <td><input type="checkbox" name="user_action[]"></td>
                    <input type="hidden" name="user_id" value="{{ $user->uid }}">
                    {{-- 编号 --}}
                    <td>{{ $user->seq_num }}</td>
                    {{-- 用户帐号 --}}
                    <td><a href="{{ url('/user/basicinfo/' . $user->uid) }}" target="_blank">{{ $user->nickname }}</a></td>
                    {{-- 电话号码 --}}
                    <td>{{ $user->cellphone }}</td>
                    {{-- 电子邮箱 --}}
                    <td>{{ $user->email }}</td>
                    {{-- 地区 --}}
                    <td>{{ $user->city_id }}</td>
                    {{-- 性别 --}}
                    <td>{{ $user->sex }}</td>
                    {{-- 学龄 --}}
                    <td>{{ $user->study_age }}</td>
                    {{-- 水平等级 --}}
                    <td>{{ $user->user_grade }}</td>
                    {{-- 指定乐器 --}}
                    <td>
                        {{-- @if(!empty($user->instrument_id))
                            @foreach($user->instrument_id as $instrument)
                                {{ $instrument['name'] }}&nbsp;&nbsp;
                            @endforeach
                        @endif --}}
                        {{ $user->instrument_id ? '钢琴' : '' }}
                    </td>
                    {{-- 注册日期 --}}
                    <td>{{ $user->regdate }}</td>
                    {{-- 账号级别 --}}
                    <td>{{ $user->account_grade }}</td>
                    {{-- 账号截止日期 --}}
                    <td>{{ $user->account_end_at }}</td>
                    {{-- 上月使用时长 --}}
                    <td>{{ $user->duration_preMonth }}</td>
                    {{-- 本月使用时长 --}}
                    <td>{{ $user->duration_Month }}</td>
                    {{-- 账户状态 --}}
                    <td>
                        {{ $user->status }}
                    </td>
                    <td>
                        <button type="button" id="{{ $user->uid }}" class="{{ $user->isactive ? 'lockuser btn btn-success btn-xs' : 'lockuser btn btn-danger btn-xs' }}">
                            {{ $user->isactive ? '锁定' : '解锁'  }}
                        </button>
                        <a style="cursor:pointer">
                            <button type="button" class="btn btn-info btn-xs send_msg_single" id=""
                                    data-toggle="modal" data-target=".m_notify_all">通知</button>
                        </a>
                        <button type="button" class="btn btn-default btn-xs"><a href="/user/basicinfo/{{$user->uid}}" target="_blank">查看</a></button>
                        <button type="button" class="btn btn-default btn-xs"><a href="/user/recordReport/{{$user->uid}}" target="_blank">成绩报告</a></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
    </table>
    <div class="btn btn-danger" id="lock_all">锁定</div>
    <div class="btn btn-success" id="unlock_all">解锁</div>
    <div class="btn btn-info" id="notify_all" data-toggle="modal" data-target=".m_notify_all">通知</div>
    <div class="text-center">
        {!! $users->render() !!}
    </div>
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
@endif
@endsection

@section('css')
    <link rel="stylesheet" href="/css/user.css">
@endsection

@section('js')
    <script src="{{ elixir('js/user.js') }}"></script>
@endsection
