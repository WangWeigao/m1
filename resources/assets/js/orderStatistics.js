$(document).ready(function() {
    // 绘制本日柱状图
        $.ajax({
            url: '/order/tendency',
            type: 'get',
            dataType: 'json',
            data: {
                'period':'today',
            },
            header: {
                'X-CSRF-Token': $("input[name=_token]").val()
            }
        })
        .done(function(data) {
            var dateArray = [];
            $.each(data, function(index, el) {
                dateArray.push([index, el]);
            });
            // 绘制本日柱状图
            $('#today_highcharts').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: '今日订单数增长统计图表'
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
                        text: '订单数'
                    },
                    allowDecimals: false,
                },
                legend: {
                    enabled: false
                },
                tooltip: {
                    pointFormat: '新增订单数: <b>{point.y:.f} </b>'
                },
                series: [{
                    name: 'Population',
                    data: dateArray,
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
        });


    // 绘制本月柱状图
        $.ajax({
            url: '/order/tendency',
            type: 'get',
            dataType: 'json',
            data: {
                'period':'month',
            },
            header: {
                'X-CSRF-Token': $("input[name=_token]").val()
            }
        })
        .done(function(data) {
            var dateArray = [];
            $.each(data, function(index, el) {
                dateArray.push([index+1, el]);
            });
            // 绘制本月柱状图
            $('#month_highcharts').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: '本月订单数增长统计图表'
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
                        text: '订单数'
                    },
                    allowDecimals: false,
                },
                legend: {
                    enabled: false
                },
                tooltip: {
                    pointFormat: '新增订单数: <b>{point.y:.f} </b>'
                },
                series: [{
                    name: 'Population',
                    data: dateArray,
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
        });

    // 绘制本季度柱状图
        $.ajax({
            url: '/order/tendency',
            type: 'get',
            dataType: 'json',
            data: {
                'period':'quarter',
            },
            header: {
                'X-CSRF-Token': $("input[name=_token]").val()
            }
        })
        .done(function(data) {
            var dateArray = [];
            $.each(data, function(index, el) {
                dateArray.push([index+1, el]);
            });
            // 绘制本季度柱状图
            $('#quarter_highcharts').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: '本季度订单数增长统计图表'
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
                        text: '订单数'
                    },
                    allowDecimals: false,
                },
                legend: {
                    enabled: false
                },
                tooltip: {
                    pointFormat: '新增订单数: <b>{point.y:.f} </b>'
                },
                series: [{
                    name: 'Population',
                    data: dateArray,
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
        });

    // 绘制本年柱状图
        $.ajax({
            url: '/order/tendency',
            type: 'get',
            dataType: 'json',
            data: {
                'period':'year',
            },
            header: {
                'X-CSRF-Token': $("input[name=_token]").val()
            }
        })
        .done(function(data) {
            var dateArray = [];
            $.each(data, function(index, el) {
                dateArray.push([index+1, el]);
            });
            // 绘制本年柱状图
            $('#year_highcharts').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: '本年订单数增长统计图表'
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
                        text: '订单数'
                    },
                    allowDecimals: false,
                },
                legend: {
                    enabled: false
                },
                tooltip: {
                    pointFormat: '新增订单数: <b>{point.y:.f} </b>'
                },
                series: [{
                    name: 'Population',
                    data: dateArray,
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
        });
});
