@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
          <li>邀请管理</li>
          <li>邀请用户列表</li>
        </ol>
        <div class="btn-group tab">
            <a href="/invite_new_users" class="btn btn-default active">新用户</a>
            <a href="/invite_paid_users" class="btn btn-default">充值用户</a>
        </div>
        <form class="" action="/invite_new_users" method="get">
            <div class="form-group form-inline">
                <label for="username">精确搜索</label>
                <input class="form-control" type="text" name="keyword" value="{{ Input::get('keyword') }}" id="username" placeholder="请输入用户名">
            </div>
            <div class="form-group form-inline">
                <label for="province" class="">地域</label>
                <select class="form-control" name="province" id="province">
                    <option value="0">不限</option>
                    <option value="1">北京</option>
                    <option value="2">天津</option>
                    <option value="3">上海</option>
                    <option value="4">重庆</option>
                    <option value="5">河北</option>
                    <option value="6">山西</option>
                    <option value="7">台湾</option>
                    <option value="8">辽宁</option>
                    <option value="9">吉林</option>
                    <option value="10">黑龙江</option>
                    <option value="11">江苏</option>
                    <option value="12">浙江</option>
                    <option value="13">安徽</option>
                    <option value="14">福建</option>
                    <option value="15">江西</option>
                    <option value="16">山东</option>
                    <option value="17">河南</option>
                    <option value="18">湖北</option>
                    <option value="19">湖南</option>
                    <option value="20">广东</option>
                    <option value="21">甘肃</option>
                    <option value="22">四川</option>
                    <option value="23">贵州</option>
                    <option value="24">海南</option>
                    <option value="25">云南</option>
                    <option value="26">青海</option>
                    <option value="27">陕西</option>
                    <option value="28">广西</option>
                    <option value="29">西藏</option>
                    <option value="30">宁夏</option>
                    <option value="31">新疆</option>
                    <option value="32">内蒙古</option>
                    <option value="33">澳门</option>
                    <option value="34">香港</option>
                </select>
                <label for="thirty_days_duration" class="">近30天使用时间</label>
                <select class="form-control" name="thirty_days_duration" id="thirty_days_duration">
                    <option value="">不限</option>
                    <option value="large30min">30分钟以上</option>
                    <option value="less30min">30分钟以下</option>
                </select>
            </div>
            <div class="form-group form-inline">
                <label for="payment_status">结算状态</label>
                <select class="form-control" name="payment_status" id="payment_status">
                    <option value="all">全部</option>
                    <option value="non-payment">未结算</option>
                    <option value="paid">已结算</option>
                    <option value="do_not_pay">不可结算</option>
                </select>
                <label for="thirty_days_boot_times">近30天启动次数</label>
                <select class="form-control" name="thirty_days_boot_times" id="thirty_days_boot_times">
                    <option value="">不限</option>
                    <option value="more2times">2次以上</option>
                    <option value="less2times">2次以下</option>
                </select>
                <button type="submit" class="btn btn-info">搜索</button>
            </div>
        </form>
        <hr>
        <table class="table table-striped table-condensed table-bordered">
            <thead>
                <th>
                    <input type="checkbox" name="" value="">
                </th>
                <th>用户帐号</th>
                <th>被邀请时间</th>
                <th>联系方式</th>
                <th>30天内使用时间</th>
                <th>30天内启动次数</th>
                <th>能否结算</th>
                <th>结算状态</th>
                <th>结算金额</th>
                <th>操作</th>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>
                            <input type="checkbox" name="all" value="">
                        </td>
                        {{--  用户帐号 --}}
                        <td>{{ $order->user->nickname }}</td>
                        {{-- // 被邀请时间 --}}
                        <td>{{ $order->user->regdate }}</td>
                        {{--  联系方式 --}}
                        <td>{{ $order->user->cellphone }}</td>
                        {{--  30内使用时间 --}}
                        <td></td>
                        {{--  30内启动次数 --}}
                        <td>{{ $order->user->boot_times }}</td>
                        {{--  能否结算 --}}
                        <td></td>
                        {{--  结算状态 --}}
                        <td>{{ $order->paid }}</td>
                        {{--  结算金额 --}}
                        <td>{{ $order->price * 0.1 }}</td>
                        <td>
                            <button type="button" class="btn btn-xs btn-success">结算</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="form-group form-inline">
            <div class="" text-align="right">
                {{ $orders->render() }}
            </div>
            <div class="">
                <button type="button" class="btn btn-default">批量结算</button>
            </div>

        </div>
    </div>
@endsection

@section('css')
    <style media="screen">
    .tab, .tab > a {
        width: 50%;
    }
    .tab {
        margin-bottom: 30px;
    }
    label[for=province] {
        margin-right: 28px;
    }
    #province {
        margin-right: 120px;
    }
    #payment_status {
        margin-right: 105px;
    }
    button {
        margin-left: 120px;
    }
    </style>
@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $("#province").val("{{ Input::get('province', 0) }}");
            $("#thirty_days_duration").val("{{ Input::get('thirty_days_duration', '') }}");
            $("#payment_status").val("{{ Input::get('payment_status', 'all') }}");
            $("#thirty_days_boot_times").val("{{ Input::get('thirty_days_boot_times', '') }}");
        });
    </script>
@endsection
