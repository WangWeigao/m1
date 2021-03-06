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
                practice_time: $duration,
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
                practice_time: $duration,
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

    // 点击"第二个"搜索按钮
    $("#activeUserSearch").bind('click', function(event) {
        if ($("#practice_duration").prop('checked')) {
            // 将下拉菜单的值赋给对应的checkbox
            $("#practice_duration").val($("select[name=practice_duration]").val());
        }
        if ($("#account_type").prop('checked')) {
            // 将下拉菜单的值赋给对应的checkbox
            $("#account_type").val($("select[name=account_type]").val());
        }


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
                practice_time: $duration,
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
                practice_time: $duration,
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

    // 绘制今日柱状图
    // $(function (data) {
        $.ajax({
            url: '/user/calEveryPeriodAddUsers',
            type: 'get',
            dataType: 'json',
            data: {
                'period':'today',
                'length':$("input[name=todayValue]").val()
            },
            header: {
                'X-CSRF-Token': $("input[name=_token]").val()
            }
        })
        .done(function(data) {
            var todayArray = [];
            $.each(data, function(index, el) {
                todayArray.push([index, el]);
            });
            console.log(todayArray);
            // 绘制柱状图
            $('#today_highcharts').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: '今天每小时增长人数统计图表'
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
                    },
                    allowDecimals: false,
                },
                legend: {
                    enabled: false
                },
                tooltip: {
                    pointFormat: '新增用户数: <b>{point.y:.f} 个人</b>'
                },
                series: [{
                    name: 'Population',
                    data: todayArray,
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
        });

    // 绘制本月柱状图
    // $(function (data) {
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
                    },
                    allowDecimals: false,
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
        });
    // });

    // 绘制本季度柱状图
    // $(function (data) {
        $.ajax({
            url: '/user/calEveryPeriodAddUsers',
            type: 'get',
            dataType: 'json',
            data: {
                'period':'quarter',
                'length':$("input[name=quarterValue]").val()
            },
            header: {
                'X-CSRF-Token': $("input[name=_token]").val()
            }
        })
        .done(function(data) {
            var quarterArray = [];
            $.each(data, function(index, el) {
                quarterArray.push([index+1, el]);
            });
            console.log(quarterArray);
            // 绘制柱状图
            $('#quarter_highcharts').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: '本季度每月增长人数统计图表'
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
                    },
                    allowDecimals: false,
                },
                legend: {
                    enabled: false
                },
                tooltip: {
                    pointFormat: '新增用户数: <b>{point.y:.f} 个人</b>'
                },
                series: [{
                    name: 'Population',
                    data: quarterArray,
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
        });
    // });
    // 绘制本年柱状图
    // $(function (data) {
        $.ajax({
            url: '/user/calEveryPeriodAddUsers',
            type: 'get',
            dataType: 'json',
            data: {
                'period':'year',
                'length':$("input[name=yearValue]").val()
            },
            header: {
                'X-CSRF-Token': $("input[name=_token]").val()
            }
        })
        .done(function(data) {
            var yearArray = [];
            $.each(data, function(index, el) {
                yearArray.push([index+1, el]);
            });
            console.log(yearArray);
            // 绘制柱状图
            $('#year_highcharts').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: '本年每月增长人数统计图表'
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
                    },
                    allowDecimals: false,
                },
                legend: {
                    enabled: false
                },
                tooltip: {
                    pointFormat: '新增用户数: <b>{point.y:.f} 个人</b>'
                },
                series: [{
                    name: 'Population',
                    data: yearArray,
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
        });
    // });
});

//# sourceMappingURL=userUsageStatics.js.map
