@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
          <li>用户管理</li>
          <li>学生使用情况统计</li>
        </ol>
        <ul	class="nav nav-tabs nav-justified">
    		<li class="active"><a href="#today" data-toggle="tab">今日</a></li>
    		<li><a href="#month" data-toggle="tab">本月</a></li>
    		<li><a href="#quarter" data-toggle="tab">本季度</a></li>
    		<li><a href="#year" data-toggle="tab">本年</a></li>
        </ul>
        <div class="tab-content">
                {{-- 今日 --}}
				<div class="tab-pane active" id="today">
				    <div class="">
				        目前累计总用户数：<span>{{ $data['countStudents'] }}</span>人
				    </div>
				    <div class="">
				        今日增加用户数：<span>{{ $data['todayCountAdd'] }}</span>人
				    </div>
				    <div class="">
				        今日使用用户数：<span>{{ $data['todayCountUsed'] }}</span>人
				    </div>
				    <div class="">
				        今日订单数：<span>{{ $data['todayCountOrder'] }}</span>个
				    </div>
				    <div class="today_active_user form-inline">
				        今日活跃用户数：<span id="today_active_user">{{ $data['todayCountActive'] }}</span>个
                        {{-- <form class="form-group"> --}}
                            <input type="checkbox" name="today_input_duration" value="" id="today_input_duration" checked="checked">
                            <label for="today_input_duration">机器人使用时长</label>
                            <select name="" class="form-control" id="today_duration">
                                <option value="30">30分钟以上</option>
                                <option value="60">1小时以上</option>
                                <option value="120">2小时以上</option>
                            </select>
                            <input type="checkbox" name="today_input_order" value="" id="today_input_order">
                            <label for="today_input_order">产生订单</label>
                            <button id="today_search" class="form-control">搜索</button>
                        {{-- </form> --}}
				    </div>
				    <div class="">
				        {{-- 机器人：O2O = <span style="color:red;weight:bold">由于表结构及实现细节暂未商定,此处暂未实现</span><span></span> --}}
				    </div>
				</div>

                {{-- 本月 --}}
				<div class="tab-pane" id="month">
				    <div class="">
				        目前累计总用户数：<span>{{ $data['countStudents'] }}</span>人
				    </div>
				    <div class="">
				        本月增加用户数：<span>{{ $data['monthCountAdd'] }}</span>人
				    </div>
				    <div class="">
				        本月使用用户数：<span>{{ $data['monthCountUsed'] }}</span>人
				    </div>
				    <div class="">
				        本月订单数：<span>{{ $data['monthCountOrder'] }}</span>个
				    </div>
				    <div class="month_active_user form-inline">
				        本月活跃用户数：<span id="month_active_user">{{ $data['monthCountActive'] }}</span>个
                            <input type="checkbox" name="month_input_duration" value="" id="month_input_duration" checked="checked">
                            <label for="month_input_duration">机器人使用时长</label>
                            <select name="" class="form-control" id="month_duration">
                                <option value="1800">30小时以上的</option>
                                <option value="3600">60小时以上的</option>
                                <option value="5400">90小时以上的</option>
                                <option value="7200">120小时以上的</option>
                            </select>
                            <input type="checkbox" name="month_input_order" value="" id="month_input_order">
                            <label for="month_input_order">产生订单</label>
                            <button id="month_search" class="form-control">搜索</button>
				    </div>
				    <div class="">
				        {{-- 机器人：O2O = <span style="color:red;weight:bold">由于表结构及实现细节暂未商定,此处暂未实现</span><span></span> --}}
				    </div>
                    <input type="hidden" name="monthValue" value="{{ $data['monthValue'] }}">
                    <div id="month_highcharts" style="height: 400px;width: 60%; margin: 0 auto 30 0" ></div>
                    <div class="form-inline" style="margin:30px auto">
                        <input type="checkbox" name="" value="" id="practice_duration">
                        <label for="practice_duration">练习时长</label>
                        <select class="form-control" name="practice_duration">
                            <option value="1800">30小时以上</option>
                            <option value="3600">60小时以上</option>
                            <option value="5400">90小时以上</option>
                            <option value="7200">120小时以上</option>
                        </select>
                        <input type="checkbox" name="" value="" id="account_type">
                        <label for="account_type">帐号类型</label>
                        <select class="form-control" name="account_type">
                            <option value="3">VIP1</option>
                            <option value="2">VIP2</option>
                            <option value="1">普通</option>
                        </select>
                        <button type="button" class="form-control" id="activeUserSearch">搜索</button>
                    </div>
				</div>

                {{-- 本季度 --}}
				<div class="tab-pane" id="quarter">
				    <div class="">
				        目前累计总用户数：<span>{{ $data['countStudents'] }}</span>人
				    </div>
				    <div class="">
				        本季度增加用户数：<span>{{ $data['quarterCountAdd'] }}</span>人
				    </div>
				    <div class="">
				        本季度使用用户数：<span>{{ $data['quarterCountUsed'] }}</span>人
				    </div>
				    <div class="">
				        本季度订单数：<span>{{ $data['quarterCountOrder'] }}</span>个
				    </div>
				    <div class="quarter_active_user form-inline">
				        本季度活跃用户数：<span id="quarter_active_user">{{ $data['quarterCountActive'] }}</span>个
                            <input type="checkbox" name="quarter_input_duration" value="" id="quarter_input_duration" checked="checked">
                            <label for="quarter_input_duration">机器人使用时长</label>
                            <select name="" class="form-control" id="quarter_duration">
                                <option value="1800">30小时以上的</option>
                                <option value="3600">60小时以上的</option>
                                <option value="5400">90小时以上的</option>
                                <option value="7200">120小时以上的</option>
                            </select>
                            <input type="checkbox" name="quarter_input_order" value="" id="quarter_input_order">
                            <label for="quarter_input_order">产生订单</label>
                            <button id="quarter_search" class="form-control">搜索</button>
				    </div>
				    <div class="">
				        {{-- 机器人：O2O = <span style="color:red;weight:bold">由于表结构及实现细节暂未商定,此处暂未实现</span><span></span> --}}
				    </div>
				</div>
                {{-- 本年 --}}
				<div class="tab-pane" id="year">
				    <div class="">
				        目前累计总用户数：<span>{{ $data['countStudents'] }}</span>人
				    </div>
				    <div class="">
				        本年增加用户数：<span>{{ $data['yearCountAdd'] }}</span>人
				    </div>
				    <div class="">
				        本年使用用户数：<span>{{ $data['yearCountUsed'] }}</span>人
				    </div>
				    <div class="">
				        本年订单数：<span>{{ $data['yearCountOrder'] }}</span>个
				    </div>
				    <div class="year_active_user form-inline">
				        本年活跃用户数：<span id="year_active_user">{{ $data['yearCountActive'] }}</span>个
                            <input type="checkbox" name="year_input_duration" value="" id="year_input_duration" checked="checked">
                            <label for="year_input_duration">机器人使用时长</label>
                            <select name="" class="form-control" id="year_duration">
                                <option value="1800">30小时以上的</option>
                                <option value="3600">60小时以上的</option>
                                <option value="5400">90小时以上的</option>
                                <option value="7200">120小时以上的</option>
                            </select>
                            <input type="checkbox" name="year_input_order" value="" id="year_input_order">
                            <label for="year_input_order">产生订单</label>
                            <button id="year_search" class="form-control">搜索</button>
				    </div>
				    <div class="">
				        {{-- 机器人：O2O = <span style="color:red;weight:bold">由于表结构及实现细节暂未商定,此处暂未实现</span><span></span> --}}
				    </div>
				</div>
				<div class="tab-pane" id="quarter">month</div>
				<div class="tab-pane" id="quarter">quarter</div>
				<div class="tab-pane" id="year">year</div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ elixir('js/userUsageStatics.js') }}"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
@endsection
