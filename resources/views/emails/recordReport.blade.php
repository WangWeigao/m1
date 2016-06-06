<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html class="no-js">
    <head>
    <meta charset="utf-8">
    <title>Border Layout Demo</title>

    <script src="/js/lib/jquery.js"></script>
    <script src="/js/lib/Chart.js"></script>
    <script src="/js/lib/Chart.min.js"></script>
    <script src="/js/lib/layout.border.js"></script>

    <style>
        div, header, footer {
            border: solid 0px #888;
        }
        body {
            margin-left:50px;
            margin-right:50px;
        }
        div.time_and_number {
            margin-top:50px;
        }
        div.today_time {
            margin-left:30px;
        }
        div.today_number {
            margin-right:30px;
        }
        div.chat_div {
          border: solid 1px #888;
          background-color:#ffffff;
          margin-top:20px;
          margin-left:10px;
          display:inline;

        }
        li{ color:red; }
        li>span{ color:black; }
    </style>
    </head>
    <body class="layout" bgcolor="#f6f7f9">

    <div class="layout layout--h" data-options="region:'center'">

        <div class="layout layout--v" data-options="region:'west', width: '80%' ">
            <div data-options="region:'north', height: '10%' ">今日练习报告</div>

            <div class="layout layout--h" data-options="region:'center', width: '100%', height: '20%'" >
              <div class="today_time"  data-options="region:'west' , width: '50%'">
                <table border="0">
                    <tr>
                      <th>今日累计练习时长</th>
                    </tr>
                    <tr>
                      <th>{{ $duration_today }}</th>
                    </tr>
                </table>
              </div>
              <div class="today_number" data-options="region:'east', width: '50%' ">

                <table border="0">
                    <tr>
                      <th>今日累计练习曲目数量</th>
                    </tr>
                    <tr>
                      <th>{{ $count_today }}首</th>
                    </tr>
                </table>
              </div>
            </div>

            <div class="layout layout--v" data-options="region:'south', height: '70%'" >
              <div data-options="region:'north', height: '10%' ">
                <li><span>详细</span></li>
                <div style="text-align: right;" >{{ $date_string }}</div>
              </div>

              <div data-options="region:'center',height: '10%'">
                <table width="100%" border="1" cellspacing="0" cellpadding="0"  bordercolor="#dddddd" style="margin-top:10px">
                  <tr>
                    <td>时间</td>
                    <td>曲目名称</td>
                    <td>曲目等级</td>
                    <td>练习时长</td>
                    <td>需要强化</td>
                    <td>节奏有误</td>
                    <td>播放</td>
                  </tr>
                  @foreach($records as $v)
                      <tr>
                          <td>{{ $v->practice_time or '-' }}</td>
                          <td>{{ $v->music->name or '-' }}</td>
                          <td>{{ $v->music->level or '-' }}</td>
                          <td>{{ $v->practice_time or '-' }}</td>
                          <td>
                              @foreach($v->error_measures as $v1)
                                  {{ $v1 }}
                              @endforeach
                          </td>
                          <td>
                              @foreach($v->fast_measures as $v1)
                                  {{ $v1 }}
                              @endforeach
                          </td>
                          <td>播放</td>
                      </tr>
                  @endforeach
                  {{-- <tr>
                    <td>14:40</td>
                    <td>致爱丽丝</td>
                    <td>5</td>
                    <td>20:46</td>
                    <td>13</td>
                    <td>7</td>
                    <td>00:59</td>
                  </tr>
                  <tr>
                    <td>14:40</td>
                    <td>致爱丽丝</td>
                    <td>5</td>
                    <td>20:46</td>
                    <td>13</td>
                    <td>7</td>
                    <td>00:59</td>
                  </tr> --}}
                </table>
              </div>
              <div class="layout layout--h"  data-options="region:'south', height: '65%' ">
                <div class="chat_div" data-options="region:'west', width: '45%' ">
                  <ul>
                    @foreach($text_data as $v)
                        <li style="list-style-type:square;color:{{ $v->hex }};"><font size="2" color="#000000">{{ $v->music->name }}</font/></li>
                    @endforeach
                  </ul>
                  <div style="text-align:center;"><canvas id="canvas" height="120" width="120"></canvas></div>

                </div>

                <div class="chat_div" data-options="region:'east', width: '45%' ">
                  <ul>
                    @foreach($chart_rating as $v)
                        <li style="list-style-type:square;color:{{ $v['color'] }};"><font size="2" color="#aa8abc">{{ $v['value'] }}星</font/></li>
                    @endforeach
                  </ul>

                  <div style="text-align:center;"><canvas id="canvas1" height="120" width="120"></canvas></div>
                </div>
              </div>
            </div>

        </div>
        <div data-options="region:'east', width: '20%' ">East</div>
    </div>

    <footer data-options="region:'south', height: '30'" class="footer">

      <div >更多往日的联系情况>></div>

    </footer>

    <script>
    $.ajax({
        url: '/user/recordReportChart/'+{{ $id }},
        type: 'GET',
        dataType: 'Json',
    })
    .done(function(data) {
        var chart = new Chart(document.getElementById("canvas").getContext("2d")).Doughnut(data.data);
        var chart1 = new Chart(document.getElementById("canvas1").getContext("2d")).Doughnut(data.data1);
    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });

    //   var data = [
    //       {
    //         value: 30,
    //         color:"#F7464A"
    //       },
    //       {
    //         value : 50,
    //         color : "#46BFBD"
    //       },
    //       {
    //         value : 100,
    //         color : "#FDB45C"
    //       },
    //       {
    //         value : 40,
    //         color : "#949FB1"
    //       },
    //       {
    //         value : 120,
    //         color : "#4D5360"
    //       }
      //
    //     ];
    </script>
</body>
</html>
