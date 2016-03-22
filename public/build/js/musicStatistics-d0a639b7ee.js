$(document).ready(function() {
    $.ajax({
        url: '/music/condations',
        type: 'GET',
        dataType: 'json',
        headers : {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        }
    })
    .done(function(data) {
        /**
         * 拉取“乐器”列表
         */
        $.each(data.instrument, function(n, value) {
            var $str = "";
            $str = "<option value=" + value.id + ">" + value.name + "</option>";
            $("#stat_instrument").append($str);
            $("#stat_instrument").val("0");
        });
    })
    .fail(function() {
        console.log("error");
    });

    $("#stat_instrument").bind('change', function(event) {
        /**
         * 使用Ajax取得数据
         */
        $.ajax({
            url: '/music/musicStatisticsByInstrument',
            type: 'GET',
            dataType: 'json',
            data: {instrumentValue: $("#stat_instrument").val()}
        })
        .done(function(data) {
            console.log("success");
            /**
             * 选中乐器总计
             */
            $(".stat_result_instrument span:eq(0)").text(data.allCount);
            $(".stat_result_instrument span:eq(1)").text(data.onshelfCount);
            $(".stat_result_instrument span:eq(2)").text(data.waitForCheck);
            $(".stat_result_instrument span:eq(3)").text(data.deleteCount);
            /**
             * 选中乐器中"业余考级"乐曲情况统计
             */
            $(".stat_result_instrument span:eq(4)").text(data.amateur_onshelfCount);
            $(".stat_result_instrument span:eq(5)").text(data.amateur_waitForCheck);
            $(".stat_result_instrument span:eq(6)").text(data.amateur_deleteCount);
            /**
             * 选中乐器中"专业考级"乐曲情况统计
             */
            $(".stat_result_instrument span:eq(7)").text(data.pro_onshelfCount);
            $(".stat_result_instrument span:eq(8)").text(data.pro_waitForCheck);
            $(".stat_result_instrument span:eq(9)").text(data.pro_deleteCount);
            /**
             * 选中乐器中"热门曲目"乐曲情况统计
             */
            $(".stat_result_instrument span:eq(10)").text(data.hot_onshelfCount);
            $(".stat_result_instrument span:eq(11)").text(data.hot_waitForCheck);
            $(".stat_result_instrument span:eq(12)").text(data.hot_deleteCount);
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });

    });

});

//# sourceMappingURL=musicStatistics.js.map
