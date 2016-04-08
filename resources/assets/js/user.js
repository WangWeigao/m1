$(document).ready(function() {
    /**
     * select下拉式日期选择器(注册时间段的开始时间)
     */
     var myDate = new Date();
     $("#date_start").DateSelector({
         ctlYearId: 'idYear',
         ctlMonthId: 'idMonth',
         ctlDayId: 'idDay',
         defYear: myDate.getFullYear(),
         defMonth: (myDate.getMonth() + 1),
         defDay: myDate.getDate(),
         minYear: 1800,
         maxYear: (myDate.getFullYear() + 1)
     });

     /**
      * select下拉式日期选择器(注册时间段的结束时间)
      */
     var myDate2 = new Date();
     $("#date_end").DateSelector({
         ctlYearId: 'idYear2',
         ctlMonthId: 'idMonth2',
         ctlDayId: 'idDay2',
         defYear: myDate2.getFullYear(),
         defMonth: (myDate2.getMonth() + 1),
         defDay: myDate2.getDate(),
         minYear: 1800,
         maxYear: (myDate2.getFullYear() + 1)
     });

    /**
     * "地域"中的省份显示
     */
    $.ajax({
        url: '/user/provinces',
        type: 'GET',
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $("input[name='_token']").val()
        }
    })
    .done(function(data) {

        // 填充省份的下拉菜单
        $.each(data, function(index, el) {
            var str = '<option value=' + el.pid + '>' + el.name + '</option>';
            $("#province").append(str);
        });
        // 设置默认省份
        $("#province").val(data[2].pid);
        // 设置默认城市
        $("#city option:eq(0)").text('上海');
        $("#city option:eq(0)").val(6);
        $("#city").val(6);
        // 设置相应的 input 的 value
        $("input[name='area']").val(6);
    });

    /**
     * 根据省份取得"城市列表"
     */
    $("#province").bind('change', function(event) {
        $.ajax({
            url: '/user/cities/' + $("#province").val(),
            type: 'GET',
            dataType: 'json',
            headers: {
                'X-CSRF-Token': $("input[name='_token']").val()
            }
        })
        .done(function(data) {
            // 清空下拉菜单
            $("#city").children('option').remove();
            // 填充下拉菜单中的城市列表
            $.each(data, function(index, el) {
                var str = '<option value=' + el.cid + '>' + el.name + '</option>';
                $("#city").append(str);
            });
            // 设置默认值
            $("#city").val(data[0].cid);
            // 设置对应的 input 的 value
            $("input[name='area']").val(data[0].cid);
        });
    });

    /**
     * 地域(城市)改变时修改「地域」值
     */
    $("#city").bind('change', function () {
        // 把select的值赋给对应的input
        $("input[name='area']").val($("#city").val());
    });
    /**
     * "水平等级"改变时修改 input 的 value
     */
    $("#user_grade").val(1);                // 设置 select 的默认值
    $("input[name='user_grade']").val(1);   // 设置 input 的默认值
    $("#user_grade").bind('change', function () {
        $("input[name='user_grade']").val($("#user_grade").val());
    });

    /**
     * "注册时间"改变时修改 input 的 value
     */
    $("#reg_time").val("day");   // 设置 select 的默认值
    $("input[name='reg_time']").val("day");
    $("#reg_time").bind('change', function () {
        $("input[name='reg_time']").val($("#reg_time").val());  // 给input赋值
    });

    /**
     * 搜索『按筛选条件』
     */
    $("#search_condition").bind('click', function(event) {
        ajaxSubmitForm();
        function ajaxSubmitForm() {
            var option = {
                url: '/user',
                type: 'GET',
                dataType: 'json',
                data:{},
                headers: {
                    'X-CSRF-TOKEN': $("input[name='_token']").val()
                },
                success: function(data) {
                    console.log('搜索成功');
                },
                error: function(data) {
                    console.log('啊哦，搜索引擎开小差了');
                }
            };
            $("#search_user").ajaxSubmit(option);
            return false;
        }
    });

});
