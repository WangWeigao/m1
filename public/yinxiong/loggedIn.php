<?php
include 'dbinfo.php';
session_start();
// $email = $_SESSION['email'];
// $usn = $_SESSION['username'];
// the comment restriction
if(isset($_POST['send']) && strlen($_POST['comment'] < 1)) {
    $err = "请勿发空信息";
    echo "<script type='text/javascript'>alert('$err');</script>";
} else if (isset($_POST['send']) && strlen($_POST['comment'] >= 1)) {
    echo "<script type='text/javascript'>alert('发送成功');</script>";
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
    <!-- <link type="text/css" href="css/yxstyle.css" rel="stylesheet"/> -->
    <link type="text/css" href="css/report.css" rel="stylesheet"/>
</head>

<body>
    <!-- Fixed navbar -->
    <!--using bootstrap classes: navbar-fixed-top to stick the navbar at top-->


<div class="container-fluid text-center banner-main">
    <section id="report">
        <div id="report-form" class="container">
            <div class="report-btn-group">
                <button id="history" type = "button" class="btn" onclick="">历史纪录</button>
                <button id="stats" type = "button" class="btn" onclick="">数据统计</button>
            </div><!--report-btn-group-->
            <form action="" method="post">
                <div class="history-form-group is_visible">
                    <div class="history-data-group">
                        <input id="date-picker" type="date" name="ymd">
                        <ul class="list-inline" id="history-total">
                            <li><p>累计练习时长: 2hour 13min</p></li> <!--2hour13min替换-->
                            <li role="separator" class="divider"> | </li>
                            <li><p>练习曲目总数： 1</p></li> <!--曲目总数1替换-->
                            <li role="separator" class="divider"> | </li>
                            <li><p>平均得分：<img class="stars" src="images/4stars_greybg.png"></p></li>
                        </ul>
                    </div>
                    <table border="1" class="table table-bordered" id="history-table"><tr>
                        <td>开始时间</td>
                        <td>乐曲名</td>
                        <td>练习时长</td>
                        <td>得分</td>
                        <td>音准错误总数</td>
                        <td>节奏错误总数</td>
                        <td>试听</td></tr>

                        <tr>
                        <td>07:02</td>
                        <td>七级：A大调音阶</td>
                        <td>2min 13s</td>
                        <td><img class="stars" src="images/4stars.png"></td>
                        <td>1</td>
                        <td>1</td>
                        <td><button type="button" name="play"><img src="images/play.png"></button></td></tr>

                        <tr>
                        <td>07:02</td>
                        <td>七级：A大调音阶</td>
                        <td>2min 13s</td>
                        <td><img class="stars" src="images/5stars.png"></td>
                        <td>0</td>
                        <td>0</td>
                        <td><button type="button" name="play"><img src="images/play.png"></button></td></tr>

                        <tr>
                        <td>07:02</td>
                        <td>七级：A大调音阶</td>
                        <td>2min 13s</td>
                        <td><img class="stars" src="images/4stars.png"></td>
                        <td>2</td>
                        <td>2</td>
                        <td><button type="button" name="play"><img src="images/play.png"></button></td></tr>

                        <tr>
                        <td>07:02</td>
                        <td>七级：A大调音阶</td>
                        <td>2min 13s</td>
                        <td><img class="stars" src="images/2stars.png"></td>
                        <td>9</td>
                        <td>18</td>
                        <td><button type="button" name="play"><img src="images/play.png"></button></td></tr>

                        <tr>
                        <td>07:02</td>
                        <td>七级：A大调音阶</td>
                        <td>2min 13s</td>
                        <td><img class="stars" src="images/3stars.png"></td>
                        <td>6</td>
                        <td>13</td>
                        <td><button type="button" name="play"><img src="images/play.png"></button></td></tr>

                        <tr>
                        <td>07:02</td>
                        <td>七级：A大调音阶</td>
                        <td>2min 13s</td>
                        <td><img class="stars" src="images/4stars.png"></td>
                        <td>3</td>
                        <td>3</td>
                        <td><button type="button" name="play"><img src="images/play.png"></button></td></tr>
                    </table><br>
                    <!-- <a href="#">点击，加载更多...</a> -->
                </div><!--history-form-group-->

                <div class="stats-form-group is_invisible">

                        <ul class="list-inline" id="chart-group">
                        <li style="float: left;">
                            <!-- <div class="chart-banner" id="nulivalue">
                                <h1>努力值</h1>
                                <h6>练习时长统计</h6>
                            </div> -->
                            <img src="images/timelength.png">
                        </li>
                        <li style="float: right;">
                            <!-- <div class="chart-banner" id="chengzhangcurve">
                                <h1>成长曲线</h1>
                                <h6>乐曲演奏得分变化统计</h6>
                                <select name="song" class="form-control">
                                    <option value="小步舞曲">小步舞曲</option>
                                    <option value="致爱丽丝">致爱丽丝</option>
                                </select>
                            </div> -->
                        <img src="images/score.png">
                        </li>
                        </ul>
                        <div class="hard">
                            <div class="table-banner" id="nandiansummary">

                                <!-- <select name="song" class="form-control">
                                    <option value="小步舞曲">小步舞曲</option>
                                    <option value="致爱丽丝">致爱丽丝</option>
                                </select> -->
                            </div>
                            <table border="1" class="table table-bordered">
                            <tr><td>小节号</td>
                            <td>1</td>
                            <td>2</td>
                            <td>3</td>
                            <td>4</td>
                            <td>5</td>
                            <td>6</td>
                            <td>7</td>
                            <td>8</td>
                            <td>9</td>
                            <td>10</td>
                            </tr>

                            <tr><td>低分率</td>
                            <td>80%</td>
                            <td>80%</td>
                            <td>80%</td>
                            <td>80%</td>
                            <td>80%</td>
                            <td>80%</td>
                            <td>80%</td>
                            <td>80%</td>
                            <td>80%</td>
                            <td>80%</td>
                            </tr>

                            <tr><td>练习次数</td>
                            <td>110</td>
                            <td>110</td>
                            <td>110</td>
                            <td>110</td>
                            <td>110</td>
                            <td>110</td>
                            <td>110</td>
                            <td>110</td>
                            <td>110</td>
                            <td>110</td>
                            </tr></table>
                        </div><!--hard-->
                    </div><!--stats-form-group-->
                </form>
        </div><!--report-form-->
    </section>

</div><!-- container-fluid -->

    <!--bootstrap core js-->
    <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/buttonController.js"></script>
    <script type="text/javascript" src="js/animatescroll.js-master/animatescroll.js"></script>

    <!--placed at the end of the document so the pages load faster-->
</body>
</html>
