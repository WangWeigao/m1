$(document).ready(function() {

    var dt     = new Date();
    var year   = dt.getFullYear()
    var month  = dt.getMonth()
    var day    = dt.getDate()
    var hour   = dt.getHours()
    var minute = dt.getMinutes()
    var second = dt.getSeconds()

    $('#datepicker').datepicker({
        format: "yyyy/mm/dd",
        todayBtn: "linked",
        language: "zh-CN",
        autoclose: true,
        todayHighlight: true
    });


    // 设置订单类型初始值
    $("input[name=order_type]").val(1);
    // 设置发货商初始值
    $("input[name=vendor]").val(1);
    // 设置订单状态初始值
    $("input[name=order_status]").val(1);

    /**
     * 监控下拉菜单
     */
    $("#s_order_type").click(function(event) {
        $("input[name=order_type]").val($("#s_order_type").val());
    });
    $("#s_vendor").click(function(event) {
        $("input[name=vendor]").val($("#s_vendor").val());
    });
    $("#s_order_status").click(function(event) {
        $("input[name=order_status]").val($("#s_order_status").val());
    });

    // 固定选中的筛选条件
    var order_num_or_username   = $.getUrlParam('order_num_or_username');
    var order_type   = $.getUrlParam('order_type');
    var vendor       = $.getUrlParam('vendor');
    var order_status = $.getUrlParam('order_status');
    var data_str     = $.getUrlParam('data_str');
    if (order_num_or_username != null) {
        $("input[name=order_num_or_username]").val(order_num_or_username);
    }
    if (order_type != null) {
        $("input[name=order_type]").prop('checked', true)
        $("#s_order_type").val(order_type);
    }
    if (vendor != null) {
        $("input[name=vendor]").prop('checked', true)
        $("#s_vendor").val(vendor);
    }
    if (order_status != null) {
        $("input[name=order_status]").prop('checked', true)
        $("#s_order_status").val(order_status);
    }
    if (data_str != null) {
        $("input[name=data_str]").prop('checked', true)
        $("#s_data_str").val(data_str);
    }


});
// 获得当前日期
months = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12']
var d=new Date()
var day=d.getDate()
var month=months[d.getMonth()]
var year=d.getFullYear()
var fullDate = year+'/'+month+'/'+day

var vm = new Vue({
    el: "#form",
    data: {
        checked: false,
        from_time: $("#from_time").attr('data-value') ? $("#from_time").attr('data-value') : '2016/01/01',
        to_time: $("#to_time").attr('data-value') ? $("#to_time").attr('data-value') : fullDate,
    }
});
