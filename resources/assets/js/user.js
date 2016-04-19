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
         minYear: 2015,
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
         minYear: 2015,
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
    // $("input[name='area']").bind('click', function () {
    //     if ($("input[name='area']").prop('checked')) {
    //         $("input[name='province']").prop('checked', true);
    //     } else {
    //         $("input[name='province']").prop('checked', false);
    //     }
    // });
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
     * "帐号级别"改变时修改 input 的 value
     */
    $("#account_grade").val("vip1");    // 设置 select 的默认值
    $("input[name='account_grade']").val("vip1");   // 给 input 赋值
    $("#account_grade").bind('change', function () {
        $("input[name='account_grade']").val($("#account_grade").val());
    })

    /**
     * "帐号截止日期"改变时修改 input 的 value
     */
     $("#account_end_at").val("week");    // 设置 select 的默认值
     $("input[name='account_end_at']").val("week");   // 给 input 赋值
     $("#account_end_at").bind('change', function () {
         $("input[name='account_end_at']").val($("#account_end_at").val());
     })

    /**
     * "本月使用时长"改变时修改 input 的 value
     */
     $("#month_duration").val("1h");    // 设置 select 的默认值
     $("input[name='month_duration']").val("1h");   // 给 input 赋值
     $("#month_duration").bind('change', function () {
         $("input[name='month_duration']").val($("#month_duration").val());
     })

    /**
     * "帐号状态"改变时修改 input 的 value
     */
     $("#account_status").val("near_expire");    // 设置 select 的默认值
     $("input[name='account_status']").val("near_expire");   // 给 input 赋值
     $("#account_status").bind('change', function () {
         $("input[name='account_status']").val($("#account_status").val());
     })

    /**
     * "本月用户大幅变化"改变时修改 input 的 value
     */
     $("#change_duration").val("up20h");    // 设置 select 的默认值
     $("input[name='change_duration']").val("up20h");   // 给 input 赋值
     $("#change_duration").bind('change', function () {
         $("input[name='change_duration']").val($("#change_duration").val());
     })

    /**
     * "活跃度"改变时修改 input 的 value
     */
     $("#liveness").val("active_user");    // 设置 select 的默认值
     $("input[name='liveness']").val("active_user");   // 给 input 赋值
     $("#liveness").bind('change', function () {
         $("input[name='liveness']").val($("#liveness").val());
     })

    /**
     * "注册时间段"被修改时(开始时间)
     */
    $str = $("#idYear").val() + '-'
            + $("#idMonth").val() + '-'
            + $("#idDay").val();
    $("input[name='reg_start_time']").val($str);
    $("#idYear,#idMonth,#idDay").bind('change', function(event) {
        $str = $("#idYear").val() + '-'
                + $("#idMonth").val() + '-'
                + $("#idDay").val();
        $("input[name='reg_start_time']").val($str);
    });
    /**
     * "注册时间段"被修改时(截止时间)
     */
    $str = $("#idYear2").val() + '-'
            + $("#idMonth2").val() + '-'
            + $("#idDay2").val();
    $("input[name='reg_end_time']").val($str);
    $("#idYear2,#idMonth2,#idDay2").bind('change', function(event) {
        $str = $("#idYear2").val() + '-'
                + $("#idMonth2").val() + '-'
                + $("#idDay2").val();
    $("input[name='reg_end_time']").val($str);
    });

    /**
     * 若"注册时间段"被选中,则同时选中"截止时间", 取消时也一样
     */
    $("input[name='reg_start_time']").bind('click', function () {
        if ($("input[name='reg_start_time']").prop('checked')) {
            $("input[name='reg_end_time']").prop('checked', true);
        } else {
            $("input[name='reg_end_time']").prop('checked', false);
        }
    });
    /**
     * 搜索『按筛选条件』
     */
    // $("#search_condition").bind('click', function(event) {
    //     ajaxSubmitForm();
    //     function ajaxSubmitForm() {
    //         var option = {
    //             url: '/user',
    //             type: 'GET',
    //             dataType: 'json',
    //             data:{
    //                 'reg_end_time':$("input[name='reg_timezone']").prop('checked') ? $("input[name='reg_timezone']").attr('data-endtime') : ''
    //             },
    //             headers: {
    //                 'X-CSRF-TOKEN': $("input[name='_token']").val()
    //             },
    //             success: function(data) {
    //                 console.log('搜索成功');
    //             },
    //             error: function(data) {
    //                 console.log('啊哦，搜索引擎开小差了');
    //             }
    //         };
    //         $("#search_user").ajaxSubmit(option);
    //         return false;
    //     }
    // });

    /**
     * 保持url中含有内容的 input 为选中状态
     */
     // 获取 url 中的参数
     (function ($) {
         $.getUrlParam = function (name) {
             var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
             var r = window.location.search.substr(1).match(reg);
             if (r != null) return unescape(r[2]); return null;
         }
     })(jQuery);

     // 调用 getUrlParam 方法
     var user_cellphone_email = $.getUrlParam('user_cellphone_email');
     var area                 = $.getUrlParam('area');
     var user_grade           = $.getUrlParam('user_grade');
     var reg_time             = $.getUrlParam('reg_time');
     var account_grade        = $.getUrlParam('account_grade');
     var account_end_at       = $.getUrlParam('account_end_at');
     var month_duration       = $.getUrlParam('month_duration');
     var account_status       = $.getUrlParam('account_status');
     var change_duration      = $.getUrlParam('change_duration');
     var liveness             = $.getUrlParam('liveness');
     var reg_start_time       = $.getUrlParam('reg_start_time');
     var reg_end_time         = $.getUrlParam('reg_end_time');
     var field                = $.getUrlParam('field');
     var order                = $.getUrlParam('order');

     if (user_cellphone_email != '' && user_grade != null) {
        $("input[name=user_cellphone_email]").val(user_cellphone_email);
     }

     if (area != '' && area != null) {
        // $("input[name=area]").val(area);
        // $("#province").val(province);
        // $("#area").val(area);
     }

     if (user_grade != '' && user_grade != null) {
         $("#user_grade").val(user_grade);
         $("input[name=user_grade]").val(user_grade);
         $("input[name=user_grade]").prop('checked', true);
     }

     if (reg_time != '' && reg_time != null) {
         $("#reg_time").val(reg_time);
         $("input[name=reg_time]").val(reg_time);
         $("input[name=reg_time]").prop('checked', true);
     }

    if (account_grade != '' && account_grade != null) {
         $("#account_grade").val(account_grade);
         $("input[name=account_grade]").val(account_grade);
         $("input[name=account_grade]").prop('checked', true);
    }

     if (account_end_at != '' && account_end_at != null) {
         $("#account_end_at").val(account_end_at);
         $("input[name=account_end_at]").val(account_end_at);
         $("input[name=account_end_at]").prop('checked', true);
     }

     if (month_duration != '' && month_duration != null) {
         $("#month_duration").val(month_duration);
         $("input[name=month_duration]").val(month_duration);
         $("input[name=month_duration]").prop('checked', true);
     }

     if (account_status != '' && account_status != null) {
         $("#account_status").val(account_status);
         $("input[name=account_status]").val(account_status);
         $("input[name=account_status]").prop('checked', true);
     }

     if (change_duration != '' && change_duration != null) {
         $("#change_duration").val(change_duration);
         $("input[name=change_duration]").val(change_duration);
         $("input[name=change_duration]").prop('checked', true);
     }

     if (liveness != '' && liveness != null) {
         $("#liveness").val(liveness);
         $("input[name=liveness]").val(liveness);
         $("input[name=liveness]").prop('checked', true);
     }

     if (reg_start_time != '' && reg_start_time != null) {
         $("#idYear").val(reg_start_time.split('-')[0]);
         $("#idMonth").val(reg_start_time.split('-')[1]);
         $("#idDay").val(reg_start_time.split('-')[2]);
         $("input[name=reg_start_time]").val(reg_start_time);
         $("input[name=reg_start_time]").prop('checked', true);
     }

     if (reg_end_time != '' && reg_end_time != null) {
         $("#idYear2").val(reg_end_time.split('-')[0]);
         $("#idMonth2").val(reg_end_time.split('-')[1]);
         $("#idDay2").val(reg_end_time.split('-')[2]);
         $("input[name=reg_end_time]").val(reg_end_time);
         $("input[name=reg_end_time]").prop('checked', true);
     }

     if (field != '' && field != null) {
        $("input[name=field]").val(field);
     }

     if (order != '' && order != null) {
        $("input[name=order]").val(order);
     }

     /**
      * 修改 URL 中的参数值
      */
     //para_name 参数名称 para_value 参数值 url所要更改参数的网址
     function setUrlParam(para_name, para_value) {
         var strNewUrl = new String();
         var strUrl = new String();
         var url = new String();
         url= window.location.href;
         strUrl = window.location.href;
         //alert(strUrl);
         if (strUrl.indexOf("?") != -1) {
             strUrl = strUrl.substr(strUrl.indexOf("?") + 1);
             //alert(strUrl);
             if (strUrl.toLowerCase().indexOf(para_name.toLowerCase()) == -1) {
                 strNewUrl = url + "&" + para_name + "=" + para_value;
                 window.location = strNewUrl;
                 //return strNewUrl;
             } else {
                 var aParam = strUrl.split("&");
                 //alert(aParam.length);
                 for (var i = 0; i < aParam.length; i++) {
                     if (aParam[i].substr(0, aParam[i].indexOf("=")).toLowerCase() == para_name.toLowerCase()) {
                         aParam[i] = aParam[i].substr(0, aParam[i].indexOf("=")) + "=" + para_value;
                     }
                 }
                 strNewUrl = url.substr(0, url.indexOf("?") + 1) + aParam.join("&");
                 //alert(strNewUrl);
                 window.location = strNewUrl;
                 //return strNewUrl;
             }
         } else {
             strUrl += "?" + para_name + "=" + para_value;
             //alert(strUrl);
             window.location=strUrl;
         }
     }

     /**
      * 获取 URL 中的参数
      */
      function getUrlParam(name) {
         var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
         var r = window.location.search.substr(1).match(reg);
         if (r != null) return unescape(r[2]); return null;
     }

     // “水平等级”排序
     $("a:contains('水平等级')").click(function(event) {
         console.log(getUrlParam('order'));
         if (getUrlParam('order') == 'desc') {
             setUrlParam('field', 'user_grade');
             setUrlParam('order', 'asc');
         } else {
             setUrlParam('field', 'user_grade');
             setUrlParam('order', 'desc');
         }
     });

     // “注册日期”排序
     $("a:contains('注册日期')").click(function(event) {
         console.log(getUrlParam('order'));
         if (getUrlParam('order') == 'desc') {
             setUrlParam('field', 'regdate');
             setUrlParam('order', 'asc');
         } else {
             setUrlParam('field', 'regdate');
             setUrlParam('order', 'desc');
         }
     });

     // “账号截止日期”排序
     $("a:contains('账号截止日期')").click(function(event) {
         console.log(getUrlParam('order'));
         if (getUrlParam('order') == 'desc') {
             setUrlParam('field', 'account_end_at');
             setUrlParam('order', 'asc');
         } else {
             setUrlParam('field', 'account_end_at');
             setUrlParam('order', 'desc');
         }
     });

     // “上月使用时长”排序
     $("a:contains('上月使用时长')").click(function(event) {
         console.log(getUrlParam('order'));
         if (getUrlParam('order') == 'desc') {
             setUrlParam('field', 'account_end_at');
             setUrlParam('order', 'asc');
         } else {
             setUrlParam('field', 'account_end_at');
             setUrlParam('order', 'desc');
         }
     });
});
