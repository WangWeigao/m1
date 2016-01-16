<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Show/Hide Text</title>
        {{-- bootstrap 样式表 --}}
        <link rel="stylesheet" href="/bootstrap-3.3.6-dist/css/bootstrap.min.css">
        {{-- jquery-ui 样式表 --}}
        <link rel="stylesheet" href="/bootstrap-3.3.6-dist/css/jquery-ui.min.css">
        {{-- google 字体 --}}
        {{-- <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css"> --}}
        {{-- 自定义样式表 --}}
        <link rel="stylesheet" href="/bootstrap-3.3.6-dist/css/script01.css">
    </head>
    <body>
        <div class="container">

        {{--------------------- 代码测试区域 ------------------------}}

        <!-- 导航选项卡-->
        <ul class="nav nav-tabs">
            <li class="active"><a href="#home" data-toggle="tab">Home</a></li>
            <li><a href="#profile" data-toggle="tab">Profile</a></li>
            <li><a href="#messages" data-toggle="tab">Messages</a></li>
            <li><a href="#settings" data-toggle="tab">Settings</a></li>
        </ul>
        <!-- 选项卡面板 -->
        <div class="tab-content">
            <div class="tab-pane fade in active" id="home">
                Home Tab.
            </div>
            <div class="tab-pane fade" id="profile">
                Profile Tab.
            </div>
            <div class="tab-pane fade" id="messages">
                Messages Tab.
            </div>
            <div class="tab-pane fade" id="settings">
                Settings Tab.
            </div>
        </div>



        {{--------------------- 代码测试区域 ------------------------}}

        </div>

        {{-- js脚本 --}}
        <script src="/bootstrap-3.3.6-dist/js/jquery-2.2.0.min.js"></script>
        <script src="/bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
        {{-- jquery-ui脚本 --}}
        <script src="/bootstrap-3.3.6-dist/js/jquery-ui.min.js"></script>
        {{-- 自定义脚本 --}}
        <script src="/bootstrap-3.3.6-dist/js/script01.js"></script>
    </body>
</html>
