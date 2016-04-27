$(document).ready(function() {
    // 绘制柱状图
    $(function (data) {
        $.ajax({
            url: '/order/calEveryPeriodAddUsers',
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
