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
    var from_time = $.getUrlParam('from_time').replace("+", " ");
    var to_time   = $.getUrlParam('to_time').replace("+", " ");
    if (from_time != null && from_time != '') {
        $("#from_time").val(from_time);
        $("#to_time").val(to_time);
    }
    console.log(from_time);
    console.log(to_time);


});
