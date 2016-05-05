<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>音熊运营管理平台</title>

    <!-- Fonts -->
    {{-- <link href="http://apps.bdimg.com/libs/fontawesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'> --}}
    {{-- <link href="http://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'> --}}
    <link href="http://fonts.useso.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>
    {{-- <link rel="stylesheet" href="/css/Lato.css" media="screen" title="no title" charset="utf-8"> --}}

    <!-- Styles -->
    {{-- <link href="http://apps.bdimg.com/libs/bootstrap/3.3.4/css/bootstrap.css" rel="stylesheet"> --}}
    <link rel="stylesheet" href="/bootstrap-3.3.6-dist/css/bootstrap.css" media="screen" title="no title" charset="utf-8">
    {{-- <link href="{{ elixir('css/all.css') }}" rel="stylesheet"> --}}

    {{-- 继承此模板的页面使用的CSS --}}
    @yield('css')

    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
</head>
<body id="app-layout">
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    音熊运营管理平台
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    {{-- Authentication Links --}}
                    @if(Auth::user())
                        <li id="home"><a href="{{ url('/home') }}">Home</a></li>
                        <li id="music" class="dropdown">
                            {{-- <a href="{{ url('/music') }}">曲库管理</a> --}}
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">曲库管理<span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="/music">曲库查询</a></li>
                                <li><a href="/music/musicStatistics">曲库统计</a></li>
                            </ul>
                        </li>
                        <li id="user-manager" class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">用户管理<span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="/user">学生查询</a></li>
                                <li><a href="/user/usageStatistics">学生使用情况统计</a></li>
                                <li><a href="/user/playRecords">弹奏记录</a></li>
                            </ul>
                        </li>
                        {{-- <li class="disabled" id="teacher-manager"><a href="{{ url('/teacher') }}">教师管理</a></li> --}}
                        <li class="" id="order-manager">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">订单管理<span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="/order">订单查询</a></li>
                                <li><a href="/order/statistics">订单统计</a></li>
                            </ul>
                        </li>
                        {{-- @can('access-finance')
                            <li class="disabled"><a href="#">结算系统</a></li>
                        @endif --}}
                        {{-- <li class="disabled"><a href="{{ url('/lessons') }}">发布审批</a></li>
                        <li class="disabled"><a href="#">客服</a></li> --}}
                        {{-- @can('access-finance')
                            <li class=""><a href="#">系统管理</a></li>
                        @endcan --}}
                    @endif
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">登录</a></li>
                        {{-- <li><a href="{{ url('/register') }}">Register</a></li> --}}
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/password/reset/token') }}"><i class="fa fa-btn fa-edit"></i>修改密码</a></li>
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- JavaScripts -->
    {{-- <script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script> --}}
    <script src="/js/jquery.min.js"></script>
    {{-- <script src="http://apps.bdimg.com/libs/bootstrap/3.3.4/js/bootstrap.min.js"></script> --}}
    <script src="/bootstrap-3.3.6-dist/js/bootstrap.js"></script>
    <script src="{{ elixir('js/app.js') }}"></script>
    {{-- <script src="js/app.js"></script> --}}

    @yield('js')

</body>
</html>
