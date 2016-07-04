<html>
<head>
    <!--meta head-->
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name= "viewport" content = "width=device-width, initial-scale=1.0" />
    <meta name="author" content = "Yinxiong.com">
    <meta name = "description" content = "您随时随地的音乐私教">
    <!--title-->
    <title>成绩报告</title>
    <link rel='icon' href='{{$root}}/yinxiong/images/tuti.ico ' type=‘image/x-ico’ />
    <!-- <link type="text/css" href="css/mail-report.css" rel="stylesheet"/> -->
    <style media="screen">
    body {
        background-color: #F5F5F5;
        padding:0px;
        margin:0px;
    }

    /**nav**/
    .nav-container {
        position:relative;
        text-align: center;
        border-bottom: 2px solid #F0F0F0;
        height:55px;
        width:100%;
        background:#FFFFFF;
    }


    .nav-bar {
        list-style: none;
        text-align: center;
    }

    .nav-bar li{
        font-size: 1.3rem;
        display:inline-block;
        margin-top:18px;
        margin-left:100px;
        margin-right: 100px;
        float:left;
        width:200px;
        white-space: nowrap;
    }
    .nav-bar a {
        color:#666666;
        text-decoration: none;
    }

    .nav-bar a:hover{
        color:#43CD80;
        text-decoration: underline;
    }

    .nav-bar a:active{
        color:#43CD80;
        text-decoration: underline;
    }

    #search-form {
        float:right;
    }

    .container-fluid {
        width:100%;
    }

    button {
        background: transparent;
        border:transparent;
        color:#43CD80;
    }

    .form-control {
        background-color: #F0F0F0;
        height:20px;
        border:transparent;
    }
    /**标题**/

    .container {
        width:60%;
        padding:50px;
        margin-left:100px;
        margin-right: 100px;
    }
    .list-inline {
        display:inline;
        list-style: none outside none;
        white-space: nowrap;
        float:none;
    }

    .report-title {
        white-space: nowrap;
        font-size: 2rem;
        font-weight: bold;
    }

    #daily-total li{
      display:inline-block;
      white-space: nowrap;
    }

    #daily-total {
      text-align: center;
      margin:40px;
      white-space:nowrap;
    }

    #daily-total h3{
      font-size: 1.3rem;
      font-weight: bold;
      color:#b2b2b2;
    }

    #daily-total {
      font-size: 2.6rem;
      font-weight: bolder;
    }

    #detail {
      font-size: 1.5rem;
      padding-bottom: 2rem;
      color:#FFA500;
    }

    .divider {
      margin-left: 150px;
      margin-right: 150px;
      font-size:5rem;
      color:#43CD80;
    }

    /****table****/
    .table-head #date {
        float: right;
        color:#b2b2b2;
        list-style: none;
    }

    table{
        width:100%;
        border:1px solid #cccccc;
        border-collapse: collapse;
    }

    table td{
        border:1px solid #cccccc;
        height:50px;
        text-align: center;
    }

    #history-table button img{
      width:32px;
    }

    /****pi chart group 放弃治疗的hardcode****/
    #pi-chart-group {
        display:inline;
        list-style: none;
        white-space: nowrap;
        padding:0px
    }

    .chart-tag {
      list-style: none;
      text-align: left;
    }

    .pie-chart-group {
      min-width:100px;
      min-height:100px;
      margin-left:10px;
      margin-right:10px;
      position:relative;
    }

    .report-pie-chart-group {
        border:1px solid #cccccc;
        background-color:#FFFFFF;
        padding:0px;
        width:350px;
        height:300px;
    }
    #lianxishichang {
        position:relative;
        top:2em;
    }
    #pingfen {
        position:relative;
        top:-17em;
        left:30em;
    }
    #report-pie1 {
        position:relative;
        left:3em;
        top:3em;
    }

    #report-pie2 {
        position:relative;
        left:-7em;
        top:5em;
    }

    #pingfen-choose-song {
        position:relative;
        top:-6em;
        left:2em;
    }

    #pingfen-chart-tag {
        position:relative;
        left:10em;
        top: -5em;
    }

    #lianxi-chart-tag {
        position:relative;
        top:2em;
    }

    #lianxishichang p {
        position:relative;
        top:3em;
        left:4em;
    }


    /**activity右边公告栏**/
    #activity-form {
      width:15%;
      position:relative;
      top:-80em;
      /*left:70em;*/
      left: 70%;
    }

    #activity {
      background-color: #F5F5F5;
      border-style:1px solid #cccccc;
    }

    #act_icon {
      margin-left: 15px;
      margin-right: 20px;
    }

    #activity td {
      background-color: #FFFFFF;
      text-align: left;
      border:none;
    }

    #activity td:hover{
      border:none;
      background-color: #F0F0F0;
    }

    #activity p {
      text-align: right;
      margin: 15px;
      color:#cccccc;
      white-space: normal;
    }

    #activity h5 {
      margin: 15px;
    }

    </style>
</head>
<body>

	<div class="nav-container" id="nav">
		<ul class="nav-bar">
			<li><a href="">今日练习报告</a></li>
			<li><a href="">数据统计</a></li>
			<li id="search-form">
				<form action="" method="post">
					<input class="form-control" type="text" name="search" value="search" placeholder="请输入搜索内容"></input>
					<button>搜索</button>
				</form>
			</li>
		</ul>
	</div>

        <div id="report" class="container">
	            <div class="report-title">
	                <p style="color:#43CD80;">今日练习报告</p>
	            </div><!--report-title-->
	        <div id="report-form">
	            <form action="" method="post">
	                <div id="daily-form-group">
	                    <div class="daily-data-group">
	                        <ul class="list-inline" id="daily-total">
	                            <li><h3>今日累计练习时长</h3><p>1：08：58</p></li> <!--时间替换-->
	                            <li role="separator" class="divider"> | </li>
	                            <li><h3>今日累计练习曲目总数</h3><p>2首</p></li> <!--曲目总数2替换-->
	                        </ul>
	                    </div>
	                    <ul class="table-head">
	                    	<li id="detail">详细</li>
	                    	<li class="pull-right" id="date"></li><!--根据date()来改日期-->
	                    	<script>
	                    	    document.getElementById('date').innerHTML = new Date().toString();
	                    	</script>
	                    </ul>
	                    </ul>
	                    <table class="table" id="history-table"><tr>
	                        <td>时间</td>
	                        <td>曲目名称</td>
	                        <td>曲目等级</td>
	                        <td>练习时长</td>
	                        <td>需要强化</td>
	                        <td>节奏有误</td>
	                        <td>试听</td></tr>

	                        <tr>
	                        <td>07:02</td>
	                        <td><a title="错误统计" data-container="body" data-toggle="popover" data-placement="right"
      						data-content="错误统计blahblahblah">七级：A大调音阶</a></td>
	                        <td>5</td>
	                        <td>20：46</td>
	                        <td>13</td>
	                        <td>7</td>
	                        <td><button type="button" name="body"><img src="{{$root}}/yinxiong/images/play.png"></button></td></tr>

	                        <tr>
	                        <td>07:02</td>
	                        <td><a title="错误统计" data-container="body" data-toggle="popover" data-placement="right"
      						data-content="错误统计blahblahblah">七级：A大调音阶</a></td>
	                        <td>5</td>
	                        <td>20：46</td>
	                        <td>222</td>
	                        <td>155</td>
	                        <td><button type="button" name="play"><img src="{{$root}}/yinxiong/images/play.png"></button></td></tr>

	                        <tr>
	                        <td>07:02</td>
	                        <td><a title="错误统计" data-container="body" data-toggle="popover" data-placement="right"
      						data-content="错误统计blahblahblah">七级：A大调音阶</a></td>
	                        <td>99</td>
	                        <td>1：08：08</td>
	                        <td>199</td>
	                        <td>211</td>
	                        <td><button type="button" name="play"><img src="{{$root}}/yinxiong/images/play.png"></button></td></tr>

	                        <tr>
	                        <td>07:02</td>
	                        <td><a title="错误统计" data-container="body" data-toggle="popover" data-placement="right"
      						data-content="错误统计blahblahblah">七级：A大调音阶</a></td>
	                        <td>1</td>
	                        <td>10：00</td>
	                        <td>1</td>
	                        <td>1</td>
	                        <td><button type="button" name="play"><img src="{{$root}}/yinxiong/images/play.png"></button></td></tr>

	                        <tr>
	                        <td>07:02</td>
	                        <td><a title="错误统计" data-container="body" data-toggle="popover" data-placement="right"
      						data-content="错误统计blahblahblah">致爱丽丝</a></td>
	                        <td>3</td>
	                        <td>20：00</td>
	                        <td>6</td>
	                        <td>13</td>
	                        <td><button type="button" name="play"><img src="{{$root}}/yinxiong/images/play.png"></button></td></tr>

	                        <tr>
	                        <td>07:02</td>
	                        <td><a title="错误统计" data-container="body" data-toggle="popover" data-placement="right"
      						data-content="错误统计blahblahblah">致爱丽丝</a></td>
	                        <td>3</td>
	                        <td>20：23</td>
	                        <td>3</td>
	                        <td>3</td>
	                        <td><button type="button" name="play"><img src="{{$root}}/yinxiong/images/play.png"></button></td></tr>
	                    </table><br>

	                    <ul class="list-inline" id="pi-chart-group">
	                    	<li>
	                    		<div class="report-pie-chart-group" id="lianxishichang">
		                    		<ul class="chart-tag" id="lianxi-chart-tag">
		                    			<li><img src="{{$root}}/yinxiong/images/pi-chart/bluedot.png">七级：A大调音阶</li>
		                    			<li><img src="{{$root}}/yinxiong/images/pi-chart/purpledot.png">致爱丽丝</li>
		                    		    <!--tag需要根据饼图的颜色变化-->
		                    		</ul>

	                    			<img src="{{$root}}/yinxiong/images/pi-chart/pie1.png" id="report-pie1">
	                    			<p>曲目练习时长</p>
	                    		</div>
	                    	</li>
	                    	<li>
	                    		<div class="report-pie-chart-group" id="pingfen">
	                    			<ul class="list-inline">
	                    				<li>
		                    				<select class="form-control" id="pingfen-choose-song">
		   										<option value="致爱丽丝">致爱丽丝</option>
		   										<option value="七级：A大调音阶">七级：A大调音阶</option>
		                    				</select>

	                    					<img src="{{$root}}/yinxiong/images/pi-chart/pie2.png" id="report-pie2">
	                    				</li>
			                    		<li>
			                    			<ul class="chart-tag" id="pingfen-chart-tag">
				                    			<li><img src="{{$root}}/yinxiong/images/pi-chart/bluedot.png">一星</li>
				                    			<li><img src="{{$root}}/yinxiong/images/pi-chart/purpledot.png">二星</li>
				                    			<li><img src="{{$root}}/yinxiong/images/pi-chart/bluedot.png">三星</li>
				                    			<li><img src="{{$root}}/yinxiong/images/pi-chart/bluedot.png">四星</li>
				                    			<li><img src="{{$root}}/yinxiong/images/pi-chart/purpledot.png">五星</li>
				                    			<li><img src="{{$root}}/yinxiong/images/pi-chart/purpledot.png">六星</li>
				                    			<li><img src="{{$root}}/yinxiong/images/pi-chart/purpledot.png">七星</li>
				                    			<li id="score-times"><p>共评分36次</p></li>
				                    		    <!--tag需要根据饼图的颜色变化-->
				                    		</ul>
				                    	</li>
		                    		</ul>
	                    	    </div>
	                    	</li>

	                    </ul>
	                	<a href="#">更多往日练习情况>></a>
	    			</div><!--daily-form-group-->
			</div><!--report-form-->
		</div><!--container-fluid-->


	<div id="activity-form" class="container">
		<table class="table table-hover" id="activity">
			<tr>
	            <td><img id="act_icon" src="{{$root}}/yinxiong/images/report/activity_icon.png">活动</td>
	        </tr>

	        <tr>
	            <td><h5>新版本2.01上线</h5><p>13:24 04-14</p></td> <!--这里信息和时间应该从数据库来-->
	        </tr>

	        <tr>
	            <td><h5>钢琴只要一元钱啦,清仓大甩卖</h5><p>10:30 04-12</p></td>
	        </tr>
	        <tr>
	            <td><h5>曲库更新，现已加入肯德基豪华套餐...</h5><p>09:08 04-03</p></td>
	        </tr>

	        <tr>
	            <td><h5>跳楼价，2元小提琴...</h5><p>23:32 04-01</p></td>
	        </tr>
	    </table><br>
    </div>

    <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
</body>
</html>
