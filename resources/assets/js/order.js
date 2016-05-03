$(function () {
    var dt     = new Date();
    var year   = dt.getFullYear()
    var month  = dt.getMonth()
    var day    = dt.getDate()
    var hour   = dt.getHours()
    var minute = dt.getMinutes()
    var second = dt.getSeconds()
    $('#datetimepicker6').datetimepicker({
        // useCurrent: true,
        format: 'YYYY-MM-DD HH:mm:ss',
        viewMode: 'days',
        dayViewHeaderFormat: 'YYYY-MM-DD HH:mm:ss',
        defaultDate: new Date(year,month,day,0,0,0)
    });
    $('#datetimepicker7').datetimepicker({
        // useCurrent: true, //Important! See issue #1075
        format: 'YYYY-MM-DD HH:mm:ss',
        viewMode: 'days',
        dayViewHeaderFormat: 'YYYY-MM-DD HH:mm:ss',
        defaultDate: new Date()
    });
    $("#datetimepicker6").on("dp.change", function (e) {
        $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
    });
    $("#datetimepicker7").on("dp.change", function (e) {
        $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
    });

    // 设置日期选择器的日期
    var from_time = $.getUrlParam('from_time');
    if (from_time != null) {
        from_time = from_time.replace("+", " ");
    }
    var to_time   = $.getUrlParam('to_time');
    if (to_time != null) {
        to_time = to_time.replace("+", " ");
    }
    if (from_time != null && from_time != '') {
        $("#from_time").val(from_time);
        $("#to_time").val(to_time);
    }

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
    var order_type   = $.getUrlParam('order_type');
    var vendor       = $.getUrlParam('vendor');
    var order_status = $.getUrlParam('order_status');
    var data_str     = $.getUrlParam('data_str');
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
    
    if ($("#data_str").prop('checked')) {
        $("#from_time").attr('name', 'from_time');
        $("#to_time").attr('name', 'to_time');
    } else {
        $("#from_time").attr('name', '');
        $("#to_time").attr('name', '');
    }

    $("#data_str").bind('change', function(event) {
        if ($("#data_str").prop('checked')) {
            $("#from_time").attr('name', 'from_time');
            $("#to_time").attr('name', 'to_time');
        } else {
            $("#from_time").attr('name', '');
            $("#to_time").attr('name', '');
        }
    });

});
