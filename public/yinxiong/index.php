<?php
include 'dbinfo.php';
session_start();
// the comment restriction
if (isset($_POST['send'])) {
    $err = "请登陆再发信息";
    echo "<script type='text/javascript'>alert('$err');</script>";
}

?>

<html>
<head>
    <!--meta head-->
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name= "viewport" content = "width=device-width, initial-scale=1.0" />
    <meta name="author" content = "Yinxiong.com">
    <meta name = "description" content = "您随时随地的音乐私教">
    <!--title-->
    <title>Welcom to YinXiong</title>
    <link rel='icon' href='images/tuti.ico ' type=‘image/x-ico’ />
    <!--bootstrap core css-->
    <link type="text/css" href="css/bootstrap.min.css" rel="stylesheet"/>
    <link type="text/css" href="css/font-awesome.min.css" rel="stylesheet"/>
    <link type="text/css" href="css/yxstyle.css" rel="stylesheet"/>
    <link type="text/css" href="css/modal.css" rel="stylesheet">
</head>

<body>

    <!-- Fixed navbar -->
    <!--using bootstrap classes: navbar-fixed-top to stick the navbar at top-->
<header>
    <nav class="navbar navbar-default navbar-fixed-top">
      	<div class=" nav-container">
        	<div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand">音熊TUTI
                <img id="tuti"alt="Brand" src="images/tuti.png">
                </a>
        	</div><!--navbar-header-->
        	<div id="navbar" class="navbar-collapse collapse" data-toggle="collapse">
        		<ul id="navbar-right"class="nav navbar-nav navbar-right">
        			<li class="nvb-label" id="nav-home"><a onclick="$('#home').animatescroll({scrollSpeed:2000,easing:'easeInOutBack'});">主页</a></li>
            		<li class="nvb-label" id="nav-product"><a onclick="$('#intro').animatescroll({scrollSpeed:2000,easing:'easeInOutBack'});">产品</a></li>
            		<li class="nvb-label" id="nav-self"><a href="#loginWindow" data-toggle="modal">登陆</a></li>
            		<li class="nvb-label" id="nav-contact"> <a onclick="$('#contact').animatescroll({scrollSpeed:2000,easing:'easeInOutBack'});"> 联系我们</a></li>
       		</div><!--/.nav-collapse -->
       </div><!--nav-container-->
    </nav>
</header>

<!--Bootstrap modal for login-->
<div class="container-fluid">
    <div id="loginWindow" class="modal fade in" data-backdrop="static" role="dialog" aria-labelledby="modal-label" style="display:none;">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
        
        <div class="modal-header">
            <a class="close" data-dismiss="modal"><img src="images/login/login_n_signup/close.png"></a>
        </div><!--modal-header-->

        <div class="modal-body">

            <div id="login-form" class="visible">
                <form class="form-horizontal" action="" method="post">
                    <div class="control-group">
                        <div class="form-group">
                            <h3 id="login"><strong>登录</strong></h3>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <label></label>
                                </div>
                                <input type="text" class="form-control" name="username" id="username" placeholder="账号：手机号" autocomplete="off"/>
                            </div><!--input-group-->
                        </div><!--form-group-->

                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <label></label>
                                </div>
                                <input type="password" class="form-control" name="password" id="password" placeholder="密码：请输入8~16位字符" autocomplete="off" />
                            </div><!--input-group-->
                        </div><!--form-group-->
                        <div class="form-group">
                            <p id="forget"><a onclick="signup_selected()">忘记密码</a></p>
                            <div class="input-group">
                                <input id="login-btn" class="btn" type="submit" value="登 录">
                            </div><!--input-group-->
                            <button id="signup-btn" class="btn" onclick="signup_selected()">注册</button>
                        </div><!--form-group-->
                        <div class="form-group">
                            <ul class="list-inline">
                                <h3 id="disanfang">通过第三方登录</h3>
                                <li class="social-icon" id="weibo"><img src="images/login/login_n_signup/weibo.png"></li>
                                <li class="social-icon" id="qq"><img src="images/login/login_n_signup/qq.png"></li>
                                <li class="social-icon" id="wechat"><img src="images/login/login_n_signup/wechat.png"></li>
                            </ul>
                        </div><!--form-group-->
                    </div><!--control-group-->
                </form>
            </div><!--login-form-->

            <div id="signup-form" class="invisible"><!-- 注册表单 -->
                <form class="form-horizontal" action="" method="post">
                    <div class="control-group">
                        <div class="form-group">
                            <h3 id="sign-up"><strong>注册</strong></h3>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <label>账号:</label>
                                </div>
                                <input type="text" class="form-control" name="username" id="username" placeholder="手机号" autocomplete="off"/>
                            </div><!--input-group-->
                        </div><!--form-group-->

                        <div class="form-group">
                            <div class="input-group" id="signup-code">
                                <div class="input-group-addon">
                                    <label></label>
                                </div><!--input-group-addon-->
                                <input class="form-control" id="code" name="code" type="text" placeholder="输入验证码">
                            </div><!--input-group-->
                            <button id="signup-code-require" class="btn">获取验证码</button>
                        </div><!--form-group-->

                        <div class="form-group" id="signup-password-form">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <label for="signup-password">密码:</label>
                                </div>
                                <input id="signup-password" name="password" class="form-control" type="text"  placeholder="请输入8-16位字符">
                            </div><!--input-group-->
                        </div><!--form-group-->

                        <div class="form-group" id="signup-password-check-form">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <label for="signup-password-check">确认密码:</label>
                                </div>
                                <input id="signup-password-check" class="form-control" type="text" placeholder="请再次输入密码">
                            </div><!--input-group-->
                        </div><!--form-group-->

                        <div class="form-group" id="finish">
                            <div class="input-group">
                                <input type="submit" value="完成">
                            </div><!--input-group-->
                        </div><!--formgroup-->

                    </div><!--control-group-->
                </form>
            </div><!--signup-form-->

        </div><!--modal-body-->

        </div><!--modal-content-->
        </div><!--modal-dialog-->

    </div><!--modal hide fade in-->
</div><!--container-fluid-->

<!--this is the main page-->
<div class="container-fluid text-center banner-main">
    <!-- Main component for a primary marketing message or call to action -->
    <section id="home">
        <img id="planet"src="images/planet.png">
        <div class="ban-text-middle">
            <h1>您随时随地的音乐私教</h1>
            <p>Your private music coach</p>
            <p>Anytime! Anywhere!</p>
            <img id="tuti_sticker"src = "images/tuti.png">
        </div><!--ban-text-middle-->
    </section><!--home-->

    <section id="intro">
    	<div class="intro-pad">
            <img id="fp1" class="fp" src="images/fp1.png">
            <div id="skill"class="text-center">
                <button id="ios-btn" class="btn">ios下载</button></br>
        		<button id="android-btn" class="btn">Android下载</button>
                <h1>音熊有何技能</h1>

        	</div> <!--skill-->
            <img id="fp2" class="fp" src="images/fp2.png">
        	<ul class="intro-list">
                <img id="phone1"class="phone" src="images/iphone1.png">
        		<li class="intro-list-item" id="intro-text-center">
        			<img id="n1"class="num" src="images/NO.1.png">
        			<h3>实时报错</h3>
        		    <p>音熊机器人会仔细聆听学生演奏时的每拍、每节，在句末用语音告知学生。帮助学生发现训练时容易遗漏的错误。</p>
        		    <img id="fp3" class="fp" src="images/fp3.png">
                </li>
        		<li class="intro-list-item" id="intro-text-right">
        			<img id="n2"class="num" src="images/NO.2.png">
        			<h3>成绩报告</h3>
        			<p>家人无需花费自己休息时间来监督孩子联系。音熊会全方位记录孩子的练习情况，并将报告发送给各位。</p>
        		    <img id="fp4" class="fp" src="images/fp4.png">
                </li>
        		<li class="intro-list-item" id="intro-text-left">
        			<img id="n3"class="num" src="images/NO.3.png">
        			<h3>不改变演奏习惯</h3>
        			<p>不强求学生从头弹到尾。一切根据个人习惯，想练到哪段就练哪段。用最适合自己的方式强化技能。</p>
                    <img id="fp5" class="fp" src="images/fp5.png">
                </li>
                <img id="phone2"class="phone" src="images/iphone2.png">
        	</ul>
        </div><!--intro-pad-->
    </section> <!--intro-->

    <section id="contact">
        <div class="icons">
            <ul class="list-inline">
                <li><i class="glyphicon glyphicon-earphone"></i></br>021-48694869</li>
                <li><i class="glyphicon glyphicon-envelope"></i></br>tutituti@tuti.com</li>
                <li><i class="glyphicon glyphicon-map-marker"></i></br>上海市杨浦区政立路447号一楼</li>
            </ul>
        </div><!--icons-->
        <form role="form" action="" method="POST">
            <div class="form_group">
                <p>请留下您的宝贵意见</br></p>
                <textarea type="text"rows="7" name="comment" class="form-control"> </textarea>
                <input type="submit" class="btn btn-defaul" name="send" value="发送"></input>
            </div><!--form-->
        </form>
    </section>
</div><!-- container-fluid -->

<!--bootstrap core js-->
<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/animatescroll.js-master/animatescroll.js"></script>
<script type="text/javascript" src="js/modal-switch.js"></script>
<!--placed at the end of the document so the pages load faster-->

</body>
</html>
