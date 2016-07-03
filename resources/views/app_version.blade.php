@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">更新新版本信息</h3>
            </div>
            <table class="table">
                <tr>
                    <th>版本号</th>
                    <th>url地址</th>
                    <th>详细信息</th>
                    <th>类型</th>
                    <th>强制更新</th>
                    <th>操作</th>
                </tr>
                @foreach($infos as $info)
                    <tr>
                        <td>{{ $info->version }}</td>
                        <td>{{ $info->url }}</td>
                        <td>{{ $info->detail }}</td>
                        <td>{{ $info->type ? 'IOS' : 'Android' }}</td>
                        <td>{{ $info->force_update ? '是' : '否' }}</td>
                        <td>
                            <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#edit_info" data-id="{{ $info->id }}">编辑</button>
                        </td>
                    </tr>
                @endforeach
            </table>
            @include('edit_app_version')
        </div>
    </div>
@endsection

@section('js')
<script type="text/javascript">
    $(document).ready(function() {
        // 点击"编辑"按钮，获取原始信息
        $("button:contains('编辑')").click(function(event) {
            // 清空之前的赋值
            $("input").val();
            $("select").val();
            $.getJSON('/app_version/'+$(this).attr('data-id'), function(json, textStatus) {
                // 给panel赋原始值
                $("input[name=version]").val(json.version);
                $("input[name=url]").val(json.url);
                $("input[name=detail]").val(json.detail);
                $("select[name=force_update]").val(json.force_update);
                $("button:contains('更新')").attr('data-id', json.id);
            });
        });

        // 点击"更新"按钮，更新信息
        $("button:contains('更新')").click(function(event) {
            $.post('/app_version/'+$(this).attr('data-id'), {version: $("input[name=version]").val(),
                                                             url: $("input[name=url]").val(),
                                                             detail: $("input[name=detail]").val(),
                                                             force_update: $("select[name=force_update]").val(),
                                                             _token: $("input[name=_token]").val(),
                                                             _method: 'put'}, function(data, textStatus, xhr) {
                console.log(data);
                location.reload();
            });
        });
    });
</script>

@endsection
