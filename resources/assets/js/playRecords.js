$(document).ready(function() {
    // 日期插件
    $("#datepicker").datepicker({
        format: "yyyy/mm/dd",
        todayBtn: "linked",
        language: "zh-CN",
        autoclose: true,
        todayHighlight: true
    });
    /**
     * 保存select中的搜索条件，页面刷新后不变
     */
    var search_condition = $.getUrlParam('search_condition') ? $.getUrlParam('search_condition') : 'music_name';
    var name = $.getUrlParam('name');

    $("select[name='search_condition']").val(search_condition);
    $("input[name='name']").val(name);

    var dt     = new Date();
    var year   = dt.getFullYear()
    var month  = dt.getMonth()
    var day    = dt.getDate()
    var hour   = dt.getHours()
    var minute = dt.getMinutes()
    var second = dt.getSeconds()


    // 设置日期选择器的日期
    var from_time = $.getUrlParam('from_time');
    if (from_time != null) {
        from_time = from_time.replace("+", " ");
        from_time = from_time.replace(/%3A/g, ":");
    }
    var to_time   = $.getUrlParam('to_time');
    if (to_time != null) {
        to_time = to_time.replace("+", " ");
        to_time = to_time.replace(/%3A/g, ":");
    }

    if (from_time != null && from_time != '') {
        $("input[name='from_time']").val(from_time);
        $("input[name='to_time']").val(to_time);
    }
});
months = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12']
var d = new Date()
var year = d.getFullYear()
var month = months[d.getMonth()]
var day = d.getDate()
var fullDate = year+'/'+month+'/'+day
var vm = new Vue({
    el: '#datepicker',
    data: {
        from_time: $('input[name=from_time]').attr('data-value') ? $('input[name=from_time]').attr('data-value') : '2016/01/01',
        to_time: $('input[name=to_time]').attr('data-value') ? $('input[name=to_time]').attr('data-value') : fullDate
    }
})
