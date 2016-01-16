<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="/bootstrap-3.3.6-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="/bootstrap-3.3.6-dist/css/home.css">
        <title>音熊后台管理系统</title>
    </head>
    <body>
        {{-- 共用头部 --}}
        @include('header');
        <div class="container">
            <table class="table table-striped table-hover">
                <tr>
                    <th>UID</th>
                    <th>cellphone</th>
                    <th>email</th>
                    <th>nickname</th>
                    <th>usertype</th>
                    <th>lastlogin</th>
                    <th>regdate</th>
                    <th>isactive</th>
                </tr>
                @foreach($users as $key => $user)
                    <tr>
                        <td>{{ $user->uid }}</td>
                        <td>{{ $user->cellphone }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->nickname }}</td>
                        <td>{{ $user->usertype }}</td>
                        <td>{{ $user->lastlogin }}</td>
                        <td>{{ $user->regdate }}</td>
                        <td>{{ $user->isactive }}</td>
                    </tr>
                @endforeach
            </table>
        </div>

        {{-- 分页 --}}
        <div style="text-align: center">
            {!! $users->render() !!}
        </div>
        {{-- 共用尾部 --}}
        @include('footer');
        {{-- jquery 和 bootstrap 的JS文件 --}}
        <script src="/bootstrap-3.3.6-dist/js/jquery-2.2.0.min.js"></script>
        <script src="/bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
    </body>
</html>
