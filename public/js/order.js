$(function () {
    $('#datetimepicker6').datetimepicker({
        // useCurrent: true,
        format: 'YYYY-MM-DD HH:mm:ss',
        viewMode: 'days',
        dayViewHeaderFormat: 'YYYY-MM-DD HH:mm:ss'
    });
    $('#datetimepicker7').datetimepicker({
        // useCurrent: true, //Important! See issue #1075
        format: 'YYYY-MM-DD HH:mm:ss',
        viewMode: 'days',
        dayViewHeaderFormat: 'YYYY-MM-DD HH:mm:ss'
    });
    $("#datetimepicker6").on("dp.change", function (e) {
        $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
    });
    $("#datetimepicker7").on("dp.change", function (e) {
        $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
    });
});
