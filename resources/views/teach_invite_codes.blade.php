@extends('layouts.app')

@section('content')
    <div class="container">
        {{-- 面包屑导航 --}}
        <ol class="breadcrumb">
            <li>邀请码管理</li>
            <li>机构</li>
        </ol>

        <div class="btn-group tab">
            <a class="btn btn-default" href="/org_invite_codes">机构</a>
            <a class="btn btn-default active" href="/teach_invite_codes">教师</a>
        </div>

        <form class="clearfix form-group form-inline" action="/teach_invite_codes" method="get">
                <label class="">精确搜索</label>
                <input class="form-control" type="text" name="keyword" value="{{ Input::get('keyword') }}" placehoder="请输入邀请码/机构名称/教师名称" />

                <label for="province">地域</label>
                <select class="form-control" name="province">
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

            <button type="submit" name="button" class="form-control btn btn-info col-md-offset-1">搜索</button>
        </form>
        @if(count($result) > 0)
            <table class="table table-hover table-bordered table-condensed">
                <tr>
                    <td>
                        <input type="checkbox" id="all">
                    </td>
                    <th>教师名称</th>
                    <th>联系电话</th>
                    <th>电子邮箱</th>
                    <th>邀请码编号</th>
                    <th>交易方式</th>
                    <th>邀请人数</th>
                    <th>邀请码状态</th>
                    <th>操作</th>
                </tr>
                <tbody id="list">
                    @foreach($result as $v)
                        <tr>
                            <td>
                                <input type="checkbox" name="" value="{{ $v->id }}" @if($v->invite_code_status)
                                    disabled
                                @endif>
                            </td>
                            <td>
                                {{ $v->name }}
                                @if(!empty($v->subbranch))
                                    ({{ $v->subbranch }})
                                @endif
                            </td>
                            <td>{{ $v->cell_phone }}</td>
                            <td>{{ $v->email }}</td>
                            <td>{{ $v->invite_code }}</td>
                            <td>{{ $v->payment_account }}</td>
                            <td>邀请人数</td>
                            <td>{{ $v->invite_code_status ? '已生效' : '未生效' }}</td>
                            <td>
                                <div class="btn-group pull-right">
                                    @if($v->invite_code_status == 0)
                                        <button type="button" class="btn btn-xs btn-success release_invite_code" data-id="{{ $v->id }}">发行邀请码</button>
                                    @endif
                                    <button type="button" class="btn btn-xs btn-info edit_teacher" data-toggle="modal" data-target="#edit_teacher" data-id="{{ $v->id }}">编辑</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="pull-right">
                {{ $result->render() }}
            </div>
            <div class="pull-left">
                <button type="button" name="" class="btn btn-default" id="all_release">批量发行邀请码</button>
                <button type="button" name="" data-target=".add_teacher" data-toggle="modal" class="btn btn-default">添加教师</button>
            </div>
            @include('addTeacher')
            @include('editTeacher')
        @else
            <center style="margin-top: 100px;"><h3>暂无查询结果</h3></center>
        @endif
    </div>
@endsection

@section('js')
    <script src="/js/jquery.validate.min.js"></script>
    <script src="/js/messages_cn.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {

        // 生成邀请码
        $("#generate_invite_code").click(function(event) {
            $.ajax({
                url: '/getInviteCode',
                type: 'GET',
                dataType: 'json'
            })
            .done(function(data) {
                $("#disabledInput").val(data.invite_code);
                $("input[name=invite_code]").val(data.invite_code);
            });

        });

        // 表单校验加提交
        $("#add_teacher").validate({
            rules: {
                    // simple rule, converted to {required:true}
                    teacher_name: {
                        required: true
                    },
                    // compound rule
                    email: {
                      required: true,
                      email: true
                    },
                    cell_phone: {
                        required: true,
                        minlength: 11,
                        maxlength: 11,
                        digits: true
                    },
                    disabledInput: {
                        required: true
                    },
                    bank_name: {
                        required: true
                    },
                    payment_account: {
                        required: true,
                        digits: true
                    }

                  }
        });

        // 实现全选
        $("#all").click(function(event) {
            if ($("#all").prop('checked')) {
                $("#list :checkbox:not(:disabled)").prop('checked', true);
            }else {
                $("#list :checkbox").prop('checked', false);
            }
        });
        // 获得选中项目的value
        $("#all_release").click(function() {
            var id_arr = new Array;
            $("#list :checkbox:checked").each(function(i) {
                id_arr[i] = $(this).val();
            });
            if (id_arr.length == 0) {
                alert('请选择教师');
                return;
            } else {
                $.post('/teachers/invite_code', {ids: id_arr,
                    _method: 'put',
                    _token: $("input[name=_token]").val()
                }, function(data, textStatus, xhr) {
                    location.reload();
                });
            }
        });

        // 完善全选checkbox状态
        $("#list :checkbox").click(function() {
            allchk();
        });

        // 检查是否处于全选状态
        function allchk() {
            var chksum = $("#list :checkbox:not(:disabled)").size();
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

        // 发行单个机构的邀请码
        $(".release_invite_code").click(function() {
            $.post('/teacher/' + $(this).attr('data-id') + '/invite_code', {invite_code: 1, _method: 'put', _token: $("input[name=_token]").val()}, function(json, textStatus) {
                location.reload();
            });
        });

        // 编辑机构信息
        $(".edit_teacher").click(function() {
            $.getJSON('/teacher/' + $(this).attr('data-id'), function(json, textStatus) {
                    $("#edit_teacher input[name=teacher_name]").val(json.data.name);
                    $("#edit_teacher input[name=cell_phone]").val(json.data.cell_phone);
                    $("#edit_teacher input[name=address]").val(json.data.address);
                    $("#edit_teacher input[name=email]").val(json.data.email);
                    $("#edit_teacher form").attr('action', '/teacher/' + json.data.id);
            });
        });

        // 保存机构信息
        $("#save_ins_info").click(function() {
            $("#edit_teacher form").submit();
        });

        // 保持select中上次查询的条件
        $("select[name=province]").val("{{ Input::get('province', '') }}");
        $("select[name=teacher]").val("{{ Input::get('teacher', '') }}");



    });
    </script>
@endsection

@section('css')
    <style media="screen">
        .input-group {
            margin-bottom: 5px;
        }
        label.error {
            color: red;
            font-weight: bold;
        }
        .tab, .tab>a {
            width: 50%;
        }
        .tab {
            margin-bottom: 30px;
        }
    </style>
@endsection
