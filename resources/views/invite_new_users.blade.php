@extends('layouts.app')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
          <li>邀请管理</li>
          <li>邀请用户列表</li>
        </ol>
        <div class="btn-group tab">
            <a href="/invite_new_users" class="btn btn-default active">新用户</a>
            <a href="/invite_recharge_users" class="btn btn-default">充值用户</a>
        </div>
        <form class="" action="/invite_new_users" method="get">
            {{ csrf_field() }}
            <div class="form-group form-inline">
                <label for="username">精确搜索</label>
                <input class="form-control" type="text" name="keyword" value="{{ Input::get('keyword') }}" id="username" placeholder="请输入用户名">
            </div>
            <div class="form-group form-inline">
                <label for="province" class="">地域</label>
                <select class="form-control" name="province" id="province">
                    <option value="">不限</option>
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
        @if(count($users) > 0)
            <table class="table table-striped table-condensed table-bordered">
                <thead>
                    <th>
                        <input type="checkbox" name="" id="all" value="">
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
                <tbody id="list">
                    @foreach($users as $user)
                        <tr>
                            <td>
                                <input type="checkbox" name="all" value="{{ $user->uid }}" @if(!($user->payable && $user->paid==0))
                                    disabled
                                @endif>
                            </td>
                            {{--  用户帐号 --}}
                            <td>{{ $user->nickname or '-' }}</td>
                            {{-- // 被邀请时间 --}}
                            <td>{{ $user->regdate }}</td>
                            {{--  联系方式 --}}
                            <td>{{ $user->cellphone or '-' }}</td>
                            {{--  30内使用时间 --}}
                            <td>{{ (int)($user->practice_time_sum /60) }}时{{ (int)($user->practice_time_sum % 60) }}分</td>
                            {{--  30内启动次数 --}}
                            <td>{{ $user->boot_times }}</td>
                            {{--  能否结算 --}}
                            <td>{{ $user->payable ? '是' : '否' }}</td>
                            {{--  结算状态 --}}
                            <td>
                                @if($user->paid)
                                    {{ $user->paid ? '已结算' : '' }}
                                @else
                                    {{ $user->payable ? '未结算' : '不可结算' }}
                                @endif
                                <span class="" id="paid_result"></span>
                            </td>
                            {{--  结算金额 --}}
                            <td>10元</td>
                            <td>
                                @if($user->paid == 0 && $user->payable == 1)
                                    <button type="button" class="btn btn-xs btn-success payment" data-uid="{{ $user->uid }}">结算</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="form-group form-inline">
                <div class="pull-right">
                    {{ $users->render() }}
                </div>
                <div class="pull-left">
                    <button type="button" class="btn btn-default" id="pay_all">批量结算</button>
                </div>

            </div>
        @else
            <div class="text-center">
                <h3 style="margin-top: 100px;">暂无查询结果</h3>
            </div>
        @endif
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
    button[type="submit"] {
        margin-left: 120px;
    }
    </style>
@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function() {
            // 给 select 赋值
            $("#province").val("{{ Input::get('province', '') }}");
            $("#thirty_days_duration").val("{{ Input::get('thirty_days_duration', '') }}");
            $("#payment_status").val("{{ Input::get('payment_status', 'all') }}");
            $("#thirty_days_boot_times").val("{{ Input::get('thirty_days_boot_times', '') }}");
            // 给已结算列添加样式
            $("td:contains('已结算')>span").attr('class', 'glyphicon glyphicon-ok');

            // 更新状态为已结算
            $(".payment").click(function(event) {
                $.post('/invite_new_user/'+$(this).attr('data-uid'), { _token: $("input[name=_token]").val(), _method: 'put'}, function(data, textStatus, xhr) {
                    location.reload();
                });
            });

            // 实现全选
            $("#all").click(function(event) {
                if ($("#all").prop('checked')) {
                    $("#list :checkbox:not(:disabled)").prop('checked', true);
                }else {
                    $("#list :checkbox").prop('checked', false);
                }
            });
            // 完善全选checkbox状态
            $("#list :checkbox").click(function() {
                allchk();
            });
            // 检查是否处于全选状态
            function allchk() {
                var chksum = $("#list :checkbox").size();
                var chk = 0;
                $("#list :checkbox:checked:not(:disabled)").each(function(index, el) {
                    chk++;
                });
                if (chksum == chk) {
                    $("#all").prop('checked', true);
                }else {
                    $("#all").prop('checked', false);
                }
            }

            // 批量结算
            $("#pay_all").click(function(event) {
                var ids = new Array;
                $("#list :checked").each(function(index, el) {
                    ids[index] = $(el).val();
                });
                console.log(ids);
                if (ids.length == 0) {
                    alert('请先选择用户');
                    return;
                } else {
                    $.post('/invite_new_users', {ids: ids, _token: $("input[name=_token]").val(), _method: 'put'}, function(data, textStatus, xhr) {
                        location.reload();
                    });
                }

            });

        });
    </script>
@endsection
