@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
          <li>订单管理</li>
          <li class="active">订单统计</li>
        </ol>

        <div>
            <h4>成交订单数:{{ $pay_nums->counts }}</h4>
        </div>
        <div class="">
            <h4>总订单数:{{ $nums->counts }}</h4>
        </div>
        <br>
        <div class="">
            <legend>订单变化趋势图表</legend>
        </div>
        <ul class="nav nav-tabs nav-justified">
          <li class="active"><a href="#today" data-toggle="tab">本日</a></li>
          <li><a href="#month" data-toggle="tab">本月</a></li>
          <li><a href="#quarter" data-toggle="tab">本季度</a></li>
          <li><a href="#year" data-toggle="tab">本年</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="today">
                <div id="today_highcharts" style="height: 400px;width: 80%; margin: 0 auto 30 0" ></div>
            </div>
            <div class="tab-pane" id="month">
                本月
            </div>
            <div class="tab-pane" id="quarter">
                本季度
            </div>
            <div class="tab-pane" id="year">
                本年
            </div>

        </div>
    </div>
@endsection

@section('js')
    <script src="{{ elixir('js/orderStatistics.js') }}"></script>
@endsection
