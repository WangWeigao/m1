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
                <div id="today_highcharts"></div>
            </div>
            <div class="tab-pane" id="month">
                <div id="month_highcharts"></div>
            </div>
            <div class="tab-pane" id="quarter">
                <div id="quarter_highcharts"></div>
            </div>
            <div class="tab-pane" id="year">
                <div id="year_highcharts"></div>
            </div>

        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ elixir('css/orderStatistics.css') }}" media="screen" title="no title" charset="utf-8">
@endsection

@section('js')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="{{ elixir('js/orderStatistics.js') }}"></script>
@endsection
