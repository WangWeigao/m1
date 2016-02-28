<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'> --}}

    <!-- Styles -->
    {{-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"> --}}
    <link href="{{ elixir('css/all.css') }}" rel="stylesheet">

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
                    音熊后台管理
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
                                <li><a href="/music/create">添加曲目</a></li>
                                <li><a href="/music">查找曲目</a></li>
                            </ul>
                        </li>
                        <li id="user-manager" class="dropdown">
                            <a href="{{ url('/user') }}">学生管理</a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/userdetails') }}"></a></li>
                            </ul>
                        </li>
                        <li id="teacher-manager"><a href="{{ url('/teacher') }}">教师管理</a></li>
                        <li id="order-manager"><a href="{{ url('/order') }}">订单管理</a></li>
                        <li class="disabled"><a href="#">结算系统</a></li>
                        <li class="disabled"><a href="{{ url('/lessons') }}">发布审批</a></li>
                        <li class="disabled"><a href="#">客服</a></li>
                        <li class="disabled"><a href="#">系统管理</a></li>
                    @endif
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        {{-- <li><a href="{{ url('/register') }}">Register</a></li> --}}
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
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
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> --}}
    <script src="{{ elixir('js/all.js') }}"></script>

    @yield('js')

</body>
</html>
