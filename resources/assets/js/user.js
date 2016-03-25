$(document).ready(function() {
    /**
     * 今日
     */
    // 初始化"机器人使用时长"为30分钟
    $("input[name=today_input_duration]").val(30);
    // 初始化"产生订单"值为1
    $("input[name=today_input_order]").val(1);
    $("#today_duration").bind('change', function(event) {
        $("input[name=today_input_duration]").val($("#today_duration").val());
    });
    // 点击"搜索按钮"
    $("#today_search").bind('click', function(event) {
        if ($("input[name=today_input_duration]").prop('checked')) {
            var $duration = $(".today_active_user input[name=today_input_duration]").val();
        }else {
            var $duration = 0;
        }
        if ($("input[name=today_input_order]").prop('checked')) {
            var $order = $(".today_active_user input[name=today_input_order]").val();
        }else {
            var $order = 0;
        }
        $.ajax({
            url: '/user/activeUser',
            type: 'get',
            dataType: '',
            data: {
                date: 'today',
                duration: $duration,
                order: $order
            }
        })
        .done(function(data) {
            $("#today_active_user").text(data);
        })
        .fail(function() {
            console.log("error");
        });
    });

    /**
     * 本月
     */
    // 初始化"机器人使用时长"为1800分钟
    $("input[name=month_input_duration]").val(1800);
    // 初始化"产生订单"值为1
    $("input[name=month_input_order]").val(1);
    $("#month_duration").bind('change', function(event) {
        $("input[name=month_input_duration]").val($("#month_duration").val());
    });
    // 点击"搜索按钮"
    $("#month_search").bind('click', function(event) {
        if ($("input[name=month_input_duration]").prop('checked')) {
            var $duration = $(".month_active_user input[name=month_input_duration]").val();
        }else {
            var $duration = 0;
        }
        if ($("input[name=month_input_order]").prop('checked')) {
            var $order = $(".month_active_user input[name=month_input_order]").val();
        }else {
            var $order = 0;
        }
        $.ajax({
            url: '/user/activeUser',
            type: 'get',
            dataType: '',
            data: {
                date: 'month',
                duration: $duration,
                order: $order
            }
        })
        .done(function(data) {
            $("#month_active_user").text(data);
        })
        .fail(function() {
            console.log("error");
        });
    });

    /**
     * 本季度
     */
    // 初始化"机器人使用时长"为1800分钟
    $("input[name=quarter_input_duration]").val(1800);
    // 初始化"产生订单"值为1
    $("input[name=quarter_input_order]").val(1);
    $("#quarter_duration").bind('change', function(event) {
        $("input[name=quarter_input_duration]").val($("#quarter_duration").val());
    });
    // 点击"搜索按钮"
    $("#quarter_search").bind('click', function(event) {
        if ($("input[name=quarter_input_duration]").prop('checked')) {
            var $duration = $(".quarter_active_user input[name=quarter_input_duration]").val();
        }else {
            var $duration = 0;
        }
        if ($("input[name=quarter_input_order]").prop('checked')) {
            var $order = $(".quarter_active_user input[name=quarter_input_order]").val();
        }else {
            var $order = 0;
        }
        $.ajax({
            url: '/user/activeUser',
            type: 'get',
            dataType: '',
            data: {
                date: 'quarter',
                duration: $duration,
                order: $order
            }
        })
        .done(function(data) {
            $("#quarter_active_user").text(data);
        })
        .fail(function() {
            console.log("error");
        });
    });
    /**
     * 本年
     */
    // 初始化"机器人使用时长"为1800分钟
    $("input[name=year_input_duration]").val(1800);
    // 初始化"产生订单"值为1
    $("input[name=year_input_order]").val(1);
    $("#year_duration").bind('change', function(event) {
        $("input[name=year_input_duration]").val($("#year_duration").val());
    });
    // 点击"搜索按钮"
    $("#year_search").bind('click', function(event) {
        if ($("input[name=year_input_duration]").prop('checked')) {
            var $duration = $(".year_active_user input[name=year_input_duration]").val();
        }else {
            var $duration = 0;
        }
        if ($("input[name=year_input_order]").prop('checked')) {
            var $order = $(".year_active_user input[name=year_input_order]").val();
        }else {
            var $order = 0;
        }
        $.ajax({
            url: '/user/activeUser',
            type: 'get',
            dataType: '',
            data: {
                date: 'year',
                duration: $duration,
                order: $order
            }
        })
        .done(function(data) {
            $("#year_active_user").text(data);
        })
        .fail(function() {
            console.log("error");
        });
    });

    // 绘制柱状图
    $(function (data) {
        $.ajax({
            url: '/user/calEveryPeriodAddUsers',
            type: 'get',
            dataType: 'json',
            data: {
                'period':'month',
                'length':$("input[name=monthValue]").val()
            },
            header: {
                'X-CSRF-Token': $("input[name=_token]").val()
            }
        })
        .done(function(data) {
            var monthArray = [];
            $.each(data, function(index, el) {
                monthArray.push([index+1, el]);
            });
            console.log(monthArray);
            // 绘制柱状图
            $('#month_highcharts').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: '本月每日增长人数统计图表'
                },
                subtitle: {
                    text: ''
                },
                xAxis: {
                    type: 'category',
                    labels: {
                        rotation: -45,
                        style: {
                            fontSize: '13px',
                            fontFamily: 'Verdana, sans-serif'
                        }
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: '人数'
                    }
                },
                legend: {
                    enabled: false
                },
                tooltip: {
                    pointFormat: '新增用户数: <b>{point.y:.f} 个人</b>'
                },
                series: [{
                    name: 'Population',
                    data: monthArray,
                    dataLabels: {
                        enabled: true,
                        rotation: -90,
                        color: '#FFFFFF',
                        align: 'right',
                        format: '{point.y:.f}', // one decimal
                        y: 10, // 10 pixels down from the top
                        style: {
                            fontSize: '13px',
                            fontFamily: 'Verdana, sans-serif'
                        }
                    }
                }]
            });
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });

    });
});
