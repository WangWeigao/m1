$(document).ready(function() {


    /**
     * 点击搜索按钮，只搜索输入的关键字，不匹配下面的筛选条件
     */
    $("#search").click(function(event) {
        window.location.href='/user?_token=' + $("input[name=_token]").val()
                                             +'&user_cellphone_email='
                                             + $("#user_cellphone_email").val()
                                             + '&field=uid&order=asc';
    });
    $("#user_cellphone_email").val($.getUrlParam('user_cellphone_email'));

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
                //  window.location = strNewUrl;
                 return strNewUrl;
             }
         } else {
             strUrl += "?" + para_name + "=" + para_value;
             //alert(strUrl);
            //  window.location=strUrl;
             return strUrl;
         }
     }

     /**
      * 获取 URL 中的参数
      */
      var url_str = "";
      function getUrlParam(name) {
         var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
         var r = window.location.search.substr(1).match(reg);
         if (r != null) return unescape(r[2]); return null;
     }

     // “水平等级”排序
     $("a:contains('水平等级')").click(function(event) {
         if (getUrlParam('order') == 'desc') {
             url_str = setUrlParam('order', 'asc');
             window.history.pushState(null, null, url_str);
             url_str = setUrlParam('field', 'user_grade');
             window.history.pushState(null, null, url_str);
             window.location = url_str;
         } else {
             url_str = setUrlParam('order', 'desc');
             window.history.pushState(null, null, url_str);
             url_str = setUrlParam('field', 'user_grade');
             window.history.pushState(null, null, url_str);
             window.location = url_str;
         }
     });

     // “注册日期”排序
     $("a:contains('注册日期')").click(function(event) {
         if (getUrlParam('order') == 'desc') {
             url_str = setUrlParam('order', 'asc');
             window.history.pushState(null, null, url_str);
             url_str = setUrlParam('field', 'regdate');
             window.history.pushState(null, null, url_str);
             window.location = url_str;
         } else {
             url_str = setUrlParam('order', 'desc');
             window.history.pushState(null, null, url_str);
             url_str = setUrlParam('field', 'regdate');
             window.history.pushState(null, null, url_str);
             window.location = url_str;
         }
     });

     // “账号截止日期”排序
     $("a:contains('账号截止日期')").click(function(event) {
         if (getUrlParam('order') == 'desc') {
             url_str = setUrlParam('order', 'asc');
             window.history.pushState(null, null, url_str);
             url_str = setUrlParam('field', 'account_end_at');
             window.history.pushState(null, null, url_str);
             window.location = url_str;
         } else {
             url_str = setUrlParam('order', 'desc');
             window.history.pushState(null, null, url_str);
             url_str = setUrlParam('field', 'account_end_at');
             window.history.pushState(null, null, url_str);
             window.location = url_str;
         }
     });

     // “上月使用时长”排序
     $("a:contains('上月使用时长')").click(function(event) {
         if (getUrlParam('order') == 'desc') {
             url_str = setUrlParam('order', 'asc');
             window.history.pushState(null, null, url_str);
             url_str = setUrlParam('field', '');
             window.history.pushState(null, null, url_str);
             window.location = url_str;
         } else {
             url_str = setUrlParam('order', 'desc');
             window.history.pushState(null, null, url_str);
             url_str = setUrlParam('field', '');
             window.history.pushState(null, null, url_str);
             window.location = url_str;
         }
     });

     /**
      * 全部选中，全部取消
      */
     $("#checkAll").bind('click', function(event) {
         if (this.checked) {
             $("input[name='user_action[]']").prop("checked", true);
         }else {
             $("input[name='user_action[]']").prop("checked", false);
         }
     });

     /**
      * 锁定选中的用户
      */
     $("#lock_all").bind('click', function(event) {
         var ids = [];
         $("input[name='user_action[]']:checked").each(function(index, el) {
             ids.push($(el).closest('tr').attr('id'));
         });
         console.log(ids);
         // 如果没有选择用户，中断退出
         if (ids.length == 0) {
             return alert('请先选择用户');
         }
        $confirm = confirm('确定要锁定所选用户?');
        if ($confirm) {
            $.ajax({
                url: '/user/lockUsers',
                type: 'PUT',
                dataType: 'json',
                data: {'ids': ids},
                headers: {
                    'X-CSRF-TOKEN': $("input[name=_token]").val()
                }
            })
            .done(function() {
                location.reload();
            })
        }
     });

     /**
      * 锁定单个用户
      */
      $(".lockuser").each(function(index, el) {
          $(el).click(function(event) {
              var id = $(el).attr('id');
              $.ajax({
                  url: '/user/lockuser/' + id,
                  type: 'GET',
                  dataType: 'json'
              })
              .done(function(data) {
                  if (data) {
                      $(el).attr('class', 'lockuser btn btn-success btn-xs');
                      $(el).text('锁定');
                      $(el).parent().prev().text('正常');
                  } else {
                      $(el).attr('class', 'lockuser btn btn-danger btn-xs');
                      $(el).text('解锁');
                      $(el).parent().prev().text('锁定');
                  }
              })
              .fail(function() {
                  console.log("error");
              })
              .always(function() {
                  console.log("complete");
              });

          });
      });

     /**
      * 解锁选中的用户
      */
     $("#unlock_all").bind('click', function(event) {
         var ids = [];
         $("input[name='user_action[]']:checked").each(function(index, el) {
             ids.push($(el).closest('tr').attr('id'));
         });
         if (ids.length == 0) {
             return alert('请先选择用户');
         }
         $confirm = confirm('确定要解锁所选用户?');
         if ($confirm) {
             $.ajax({
                 url: '/user/unlockUsers',
                 type: 'PUT',
                 dataType: 'json',
                 data: {'ids': ids},
                 headers: {
                     'X-CSRF-TOKEN': $("input[name=_token]").val()
                 }
             })
             .done(function() {
                 console.log("success");
                 location.reload();
             })
         }
     });

     /**
      * 通知选中的用户
      */
     // 判断是否已选择用户
     $("#notify_all").click(function() {
         // 由于之后会弹出模态框，暂时没有找到解决方法
     });
     $("#send_message").bind('click', function(event) {
         var ids = [];
         $("input[name='user_action[]']:checked").each(function(index, el) {
             ids.push($(el).closest('tr').attr('id'));
         });
         if (ids.length == 0) {
             return alert('请先选择用户');
         }
         $confirm = confirm('确定要通知用户?');
         if ($confirm) {
             switch ($("#select_multi").val()) {
                 case '1':
                    var message = '账号到期';
                     break;
                 case '2':
                    var message = '资料到期';
                     break;
                 case '3':
                    var message = '违规与禁言';
                     break;
                 case '4':
                    var message = '重新提交资料:' + $("input[name='message']").val();
                     break;
                 default:
             }
             $.ajax({
                 url: '/user/notifyUsers',
                 type: 'POST',
                 dataType: 'json',
                 data: {
                     'user_id': ids,
                     'message': message
                 },
                 headers: {
                     'X-CSRF-TOKEN': $("input[name=_token]").val()
                 }
             })
             .done(function() {
                 alert("通知成功！");
                 // 关闭模态框
                 $(".m_notify_all").modal('hide');
                 // 取消所有的选中项
                 $("input[name='user_action[]']:checked").each(function(index, el) {
                     $(el).prop('checked', false);
                 });
             })
             .fail(function() {
                 alert('通知失败！');
                 // 关闭模态框
                 $(".m_notify_all").modal('hide');
                 // 取消所有的选中项
                 $("input[name='user_action[]']:checked").each(function(index, el) {
                     $(el).prop('checked', false);
                 });
             })
         }
     });
     // 如果选中第四项，则出现输入框
     $("#select_multi").click(function(event) {
        if ($("#select_multi").val() == 4) {
            $("input[name='message']").attr('type', 'text');
        } else {
            $("input[name='message']").attr('type', 'hidden');
        }
     });

     /**
      * 通知单个用户
      */
     $(".send_msg_single").each(function(index, el) {
         $(el).click(function(event) {
             $(el).closest('tr').find('input').prop('checked', true);
             console.log('printing checkbox log...');
         });
     });

});

/*
* jQuery Date Selector Plugin
* 日期联动选择插件
* 
* Demo:
$("#calendar").DateSelector({
ctlYearId: <年控件id>,
ctlMonthId: <月控件id>,
ctlDayId: <日控件id>,
defYear: <默认年>,
defMonth: <默认月>,
defDay: <默认日>,
minYear: <最小年|默认为1882年>,
maxYear: <最大年|默认为本年>
});

HTML:<div id="calendar"><SELECT id=idYear></SELECT>年 <SELECT id=idMonth></SELECT>月 <SELECT id=idDay></SELECT>日</div>
*/
(function ($) {
    //SELECT控件设置函数
    function setSelectControl(oSelect, iStart, iLength, iIndex) {
        oSelect.empty();
        for (var i = 0; i < iLength; i++) {
            if ((parseInt(iStart) + i) == iIndex)
                oSelect.append("<option selected='selected' value='" + (parseInt(iStart) + i) + "'>" + (parseInt(iStart) + i) + "</option>");
            else
                oSelect.append("<option value='" + (parseInt(iStart) + i) + "'>" + (parseInt(iStart) + i) + "</option>");
        }
    }

    $.fn.DateSelector = function (options) {
        options = options || {};

        //初始化
        this._options = {
            ctlYearId: null,
            ctlMonthId: null,
            ctlDayId: null,
            defYear: 0,
            defMonth: 0,
            defDay: 0,
            minYear: 1882,
            maxYear: new Date().getFullYear()
        }

        for (var property in options) {
            this._options[property] = options[property];
        }

        this.yearValueId = $("#" + this._options.ctlYearId);
        this.monthValueId = $("#" + this._options.ctlMonthId);
        this.dayValueId = $("#" + this._options.ctlDayId);

        var dt = new Date(),
        iMonth = parseInt(this.monthValueId.attr("data") || this._options.defMonth),
        iDay = parseInt(this.dayValueId.attr("data") || this._options.defDay),
        iMinYear = parseInt(this._options.minYear),
        iMaxYear = parseInt(this._options.maxYear);

        this.Year = parseInt(this.yearValueId.attr("data") || this._options.defYear) || dt.getFullYear();
        this.Month = 1 <= iMonth && iMonth <= 12 ? iMonth : dt.getMonth() + 1;
        this.Day = iDay > 0 ? iDay : dt.getDate();
        this.minYear = iMinYear && iMinYear < this.Year ? iMinYear : this.Year;
        this.maxYear = iMaxYear && iMaxYear > this.Year ? iMaxYear : this.Year;

        //初始化控件
        //设置年
        setSelectControl(this.yearValueId, this.minYear, this.maxYear - this.minYear + 1, this.Year);
        //设置月
        setSelectControl(this.monthValueId, 1, 12, this.Month);
        //设置日
        var daysInMonth = new Date(this.Year, this.Month, 0).getDate(); //获取指定年月的当月天数[new Date(year, month, 0).getDate()]
        if (this.Day > daysInMonth) { this.Day = daysInMonth; };
        setSelectControl(this.dayValueId, 1, daysInMonth, this.Day);

        var oThis = this;
        //绑定控件事件
        this.yearValueId.change(function () {
            oThis.Year = $(this).val();
            setSelectControl(oThis.monthValueId, 1, 12, oThis.Month);
            oThis.monthValueId.change();
        });
        this.monthValueId.change(function () {
            oThis.Month = $(this).val();
            var daysInMonth = new Date(oThis.Year, oThis.Month, 0).getDate();
            if (oThis.Day > daysInMonth) { oThis.Day = daysInMonth; };
            setSelectControl(oThis.dayValueId, 1, daysInMonth, oThis.Day);
        });
        this.dayValueId.change(function () {
            oThis.Day = $(this).val();
        });
    }
})(jQuery);
/*!
 * jQuery Form Plugin
 * version: 3.51.0-2014.06.20
 * Requires jQuery v1.5 or later
 * Copyright (c) 2014 M. Alsup
 * Examples and documentation at: http://malsup.com/jquery/form/
 * Project repository: https://github.com/malsup/form
 * Dual licensed under the MIT and GPL licenses.
 * https://github.com/malsup/form#copyright-and-license
 */
/*global ActiveXObject */

// AMD support
(function (factory) {
    "use strict";
    if (typeof define === 'function' && define.amd) {
        // using AMD; register as anon module
        define(['jquery'], factory);
    } else {
        // no AMD; invoke directly
        factory( (typeof(jQuery) != 'undefined') ? jQuery : window.Zepto );
    }
}

(function($) {
"use strict";

/*
    Usage Note:
    -----------
    Do not use both ajaxSubmit and ajaxForm on the same form.  These
    functions are mutually exclusive.  Use ajaxSubmit if you want
    to bind your own submit handler to the form.  For example,

    $(document).ready(function() {
        $('#myForm').on('submit', function(e) {
            e.preventDefault(); // <-- important
            $(this).ajaxSubmit({
                target: '#output'
            });
        });
    });

    Use ajaxForm when you want the plugin to manage all the event binding
    for you.  For example,

    $(document).ready(function() {
        $('#myForm').ajaxForm({
            target: '#output'
        });
    });

    You can also use ajaxForm with delegation (requires jQuery v1.7+), so the
    form does not have to exist when you invoke ajaxForm:

    $('#myForm').ajaxForm({
        delegation: true,
        target: '#output'
    });

    When using ajaxForm, the ajaxSubmit function will be invoked for you
    at the appropriate time.
*/

/**
 * Feature detection
 */
var feature = {};
feature.fileapi = $("<input type='file'/>").get(0).files !== undefined;
feature.formdata = window.FormData !== undefined;

var hasProp = !!$.fn.prop;

// attr2 uses prop when it can but checks the return type for
// an expected string.  this accounts for the case where a form 
// contains inputs with names like "action" or "method"; in those
// cases "prop" returns the element
$.fn.attr2 = function() {
    if ( ! hasProp ) {
        return this.attr.apply(this, arguments);
    }
    var val = this.prop.apply(this, arguments);
    if ( ( val && val.jquery ) || typeof val === 'string' ) {
        return val;
    }
    return this.attr.apply(this, arguments);
};

/**
 * ajaxSubmit() provides a mechanism for immediately submitting
 * an HTML form using AJAX.
 */
$.fn.ajaxSubmit = function(options) {
    /*jshint scripturl:true */

    // fast fail if nothing selected (http://dev.jquery.com/ticket/2752)
    if (!this.length) {
        log('ajaxSubmit: skipping submit process - no element selected');
        return this;
    }

    var method, action, url, $form = this;

    if (typeof options == 'function') {
        options = { success: options };
    }
    else if ( options === undefined ) {
        options = {};
    }

    method = options.type || this.attr2('method');
    action = options.url  || this.attr2('action');

    url = (typeof action === 'string') ? $.trim(action) : '';
    url = url || window.location.href || '';
    if (url) {
        // clean url (don't include hash vaue)
        url = (url.match(/^([^#]+)/)||[])[1];
    }

    options = $.extend(true, {
        url:  url,
        success: $.ajaxSettings.success,
        type: method || $.ajaxSettings.type,
        iframeSrc: /^https/i.test(window.location.href || '') ? 'javascript:false' : 'about:blank'
    }, options);

    // hook for manipulating the form data before it is extracted;
    // convenient for use with rich editors like tinyMCE or FCKEditor
    var veto = {};
    this.trigger('form-pre-serialize', [this, options, veto]);
    if (veto.veto) {
        log('ajaxSubmit: submit vetoed via form-pre-serialize trigger');
        return this;
    }

    // provide opportunity to alter form data before it is serialized
    if (options.beforeSerialize && options.beforeSerialize(this, options) === false) {
        log('ajaxSubmit: submit aborted via beforeSerialize callback');
        return this;
    }

    var traditional = options.traditional;
    if ( traditional === undefined ) {
        traditional = $.ajaxSettings.traditional;
    }

    var elements = [];
    var qx, a = this.formToArray(options.semantic, elements);
    if (options.data) {
        options.extraData = options.data;
        qx = $.param(options.data, traditional);
    }

    // give pre-submit callback an opportunity to abort the submit
    if (options.beforeSubmit && options.beforeSubmit(a, this, options) === false) {
        log('ajaxSubmit: submit aborted via beforeSubmit callback');
        return this;
    }

    // fire vetoable 'validate' event
    this.trigger('form-submit-validate', [a, this, options, veto]);
    if (veto.veto) {
        log('ajaxSubmit: submit vetoed via form-submit-validate trigger');
        return this;
    }

    var q = $.param(a, traditional);
    if (qx) {
        q = ( q ? (q + '&' + qx) : qx );
    }
    if (options.type.toUpperCase() == 'GET') {
        options.url += (options.url.indexOf('?') >= 0 ? '&' : '?') + q;
        options.data = null;  // data is null for 'get'
    }
    else {
        options.data = q; // data is the query string for 'post'
    }

    var callbacks = [];
    if (options.resetForm) {
        callbacks.push(function() { $form.resetForm(); });
    }
    if (options.clearForm) {
        callbacks.push(function() { $form.clearForm(options.includeHidden); });
    }

    // perform a load on the target only if dataType is not provided
    if (!options.dataType && options.target) {
        var oldSuccess = options.success || function(){};
        callbacks.push(function(data) {
            var fn = options.replaceTarget ? 'replaceWith' : 'html';
            $(options.target)[fn](data).each(oldSuccess, arguments);
        });
    }
    else if (options.success) {
        callbacks.push(options.success);
    }

    options.success = function(data, status, xhr) { // jQuery 1.4+ passes xhr as 3rd arg
        var context = options.context || this ;    // jQuery 1.4+ supports scope context
        for (var i=0, max=callbacks.length; i < max; i++) {
            callbacks[i].apply(context, [data, status, xhr || $form, $form]);
        }
    };

    if (options.error) {
        var oldError = options.error;
        options.error = function(xhr, status, error) {
            var context = options.context || this;
            oldError.apply(context, [xhr, status, error, $form]);
        };
    }

     if (options.complete) {
        var oldComplete = options.complete;
        options.complete = function(xhr, status) {
            var context = options.context || this;
            oldComplete.apply(context, [xhr, status, $form]);
        };
    }

    // are there files to upload?

    // [value] (issue #113), also see comment:
    // https://github.com/malsup/form/commit/588306aedba1de01388032d5f42a60159eea9228#commitcomment-2180219
    var fileInputs = $('input[type=file]:enabled', this).filter(function() { return $(this).val() !== ''; });

    var hasFileInputs = fileInputs.length > 0;
    var mp = 'multipart/form-data';
    var multipart = ($form.attr('enctype') == mp || $form.attr('encoding') == mp);

    var fileAPI = feature.fileapi && feature.formdata;
    log("fileAPI :" + fileAPI);
    var shouldUseFrame = (hasFileInputs || multipart) && !fileAPI;

    var jqxhr;

    // options.iframe allows user to force iframe mode
    // 06-NOV-09: now defaulting to iframe mode if file input is detected
    if (options.iframe !== false && (options.iframe || shouldUseFrame)) {
        // hack to fix Safari hang (thanks to Tim Molendijk for this)
        // see:  http://groups.google.com/group/jquery-dev/browse_thread/thread/36395b7ab510dd5d
        if (options.closeKeepAlive) {
            $.get(options.closeKeepAlive, function() {
                jqxhr = fileUploadIframe(a);
            });
        }
        else {
            jqxhr = fileUploadIframe(a);
        }
    }
    else if ((hasFileInputs || multipart) && fileAPI) {
        jqxhr = fileUploadXhr(a);
    }
    else {
        jqxhr = $.ajax(options);
    }

    $form.removeData('jqxhr').data('jqxhr', jqxhr);

    // clear element array
    for (var k=0; k < elements.length; k++) {
        elements[k] = null;
    }

    // fire 'notify' event
    this.trigger('form-submit-notify', [this, options]);
    return this;

    // utility fn for deep serialization
    function deepSerialize(extraData){
        var serialized = $.param(extraData, options.traditional).split('&');
        var len = serialized.length;
        var result = [];
        var i, part;
        for (i=0; i < len; i++) {
            // #252; undo param space replacement
            serialized[i] = serialized[i].replace(/\+/g,' ');
            part = serialized[i].split('=');
            // #278; use array instead of object storage, favoring array serializations
            result.push([decodeURIComponent(part[0]), decodeURIComponent(part[1])]);
        }
        return result;
    }

     // XMLHttpRequest Level 2 file uploads (big hat tip to francois2metz)
    function fileUploadXhr(a) {
        var formdata = new FormData();

        for (var i=0; i < a.length; i++) {
            formdata.append(a[i].name, a[i].value);
        }

        if (options.extraData) {
            var serializedData = deepSerialize(options.extraData);
            for (i=0; i < serializedData.length; i++) {
                if (serializedData[i]) {
                    formdata.append(serializedData[i][0], serializedData[i][1]);
                }
            }
        }

        options.data = null;

        var s = $.extend(true, {}, $.ajaxSettings, options, {
            contentType: false,
            processData: false,
            cache: false,
            type: method || 'POST'
        });

        if (options.uploadProgress) {
            // workaround because jqXHR does not expose upload property
            s.xhr = function() {
                var xhr = $.ajaxSettings.xhr();
                if (xhr.upload) {
                    xhr.upload.addEventListener('progress', function(event) {
                        var percent = 0;
                        var position = event.loaded || event.position; /*event.position is deprecated*/
                        var total = event.total;
                        if (event.lengthComputable) {
                            percent = Math.ceil(position / total * 100);
                        }
                        options.uploadProgress(event, position, total, percent);
                    }, false);
                }
                return xhr;
            };
        }

        s.data = null;
        var beforeSend = s.beforeSend;
        s.beforeSend = function(xhr, o) {
            //Send FormData() provided by user
            if (options.formData) {
                o.data = options.formData;
            }
            else {
                o.data = formdata;
            }
            if(beforeSend) {
                beforeSend.call(this, xhr, o);
            }
        };
        return $.ajax(s);
    }

    // private function for handling file uploads (hat tip to YAHOO!)
    function fileUploadIframe(a) {
        var form = $form[0], el, i, s, g, id, $io, io, xhr, sub, n, timedOut, timeoutHandle;
        var deferred = $.Deferred();

        // #341
        deferred.abort = function(status) {
            xhr.abort(status);
        };

        if (a) {
            // ensure that every serialized input is still enabled
            for (i=0; i < elements.length; i++) {
                el = $(elements[i]);
                if ( hasProp ) {
                    el.prop('disabled', false);
                }
                else {
                    el.removeAttr('disabled');
                }
            }
        }

        s = $.extend(true, {}, $.ajaxSettings, options);
        s.context = s.context || s;
        id = 'jqFormIO' + (new Date().getTime());
        if (s.iframeTarget) {
            $io = $(s.iframeTarget);
            n = $io.attr2('name');
            if (!n) {
                $io.attr2('name', id);
            }
            else {
                id = n;
            }
        }
        else {
            $io = $('<iframe name="' + id + '" src="'+ s.iframeSrc +'" />');
            $io.css({ position: 'absolute', top: '-1000px', left: '-1000px' });
        }
        io = $io[0];


        xhr = { // mock object
            aborted: 0,
            responseText: null,
            responseXML: null,
            status: 0,
            statusText: 'n/a',
            getAllResponseHeaders: function() {},
            getResponseHeader: function() {},
            setRequestHeader: function() {},
            abort: function(status) {
                var e = (status === 'timeout' ? 'timeout' : 'aborted');
                log('aborting upload... ' + e);
                this.aborted = 1;

                try { // #214, #257
                    if (io.contentWindow.document.execCommand) {
                        io.contentWindow.document.execCommand('Stop');
                    }
                }
                catch(ignore) {}

                $io.attr('src', s.iframeSrc); // abort op in progress
                xhr.error = e;
                if (s.error) {
                    s.error.call(s.context, xhr, e, status);
                }
                if (g) {
                    $.event.trigger("ajaxError", [xhr, s, e]);
                }
                if (s.complete) {
                    s.complete.call(s.context, xhr, e);
                }
            }
        };

        g = s.global;
        // trigger ajax global events so that activity/block indicators work like normal
        if (g && 0 === $.active++) {
            $.event.trigger("ajaxStart");
        }
        if (g) {
            $.event.trigger("ajaxSend", [xhr, s]);
        }

        if (s.beforeSend && s.beforeSend.call(s.context, xhr, s) === false) {
            if (s.global) {
                $.active--;
            }
            deferred.reject();
            return deferred;
        }
        if (xhr.aborted) {
            deferred.reject();
            return deferred;
        }

        // add submitting element to data if we know it
        sub = form.clk;
        if (sub) {
            n = sub.name;
            if (n && !sub.disabled) {
                s.extraData = s.extraData || {};
                s.extraData[n] = sub.value;
                if (sub.type == "image") {
                    s.extraData[n+'.x'] = form.clk_x;
                    s.extraData[n+'.y'] = form.clk_y;
                }
            }
        }

        var CLIENT_TIMEOUT_ABORT = 1;
        var SERVER_ABORT = 2;
                
        function getDoc(frame) {
            /* it looks like contentWindow or contentDocument do not
             * carry the protocol property in ie8, when running under ssl
             * frame.document is the only valid response document, since
             * the protocol is know but not on the other two objects. strange?
             * "Same origin policy" http://en.wikipedia.org/wiki/Same_origin_policy
             */
            
            var doc = null;
            
            // IE8 cascading access check
            try {
                if (frame.contentWindow) {
                    doc = frame.contentWindow.document;
                }
            } catch(err) {
                // IE8 access denied under ssl & missing protocol
                log('cannot get iframe.contentWindow document: ' + err);
            }

            if (doc) { // successful getting content
                return doc;
            }

            try { // simply checking may throw in ie8 under ssl or mismatched protocol
                doc = frame.contentDocument ? frame.contentDocument : frame.document;
            } catch(err) {
                // last attempt
                log('cannot get iframe.contentDocument: ' + err);
                doc = frame.document;
            }
            return doc;
        }

        // Rails CSRF hack (thanks to Yvan Barthelemy)
        var csrf_token = $('meta[name=csrf-token]').attr('content');
        var csrf_param = $('meta[name=csrf-param]').attr('content');
        if (csrf_param && csrf_token) {
            s.extraData = s.extraData || {};
            s.extraData[csrf_param] = csrf_token;
        }

        // take a breath so that pending repaints get some cpu time before the upload starts
        function doSubmit() {
            // make sure form attrs are set
            var t = $form.attr2('target'), 
                a = $form.attr2('action'), 
                mp = 'multipart/form-data',
                et = $form.attr('enctype') || $form.attr('encoding') || mp;

            // update form attrs in IE friendly way
            form.setAttribute('target',id);
            if (!method || /post/i.test(method) ) {
                form.setAttribute('method', 'POST');
            }
            if (a != s.url) {
                form.setAttribute('action', s.url);
            }

            // ie borks in some cases when setting encoding
            if (! s.skipEncodingOverride && (!method || /post/i.test(method))) {
                $form.attr({
                    encoding: 'multipart/form-data',
                    enctype:  'multipart/form-data'
                });
            }

            // support timout
            if (s.timeout) {
                timeoutHandle = setTimeout(function() { timedOut = true; cb(CLIENT_TIMEOUT_ABORT); }, s.timeout);
            }

            // look for server aborts
            function checkState() {
                try {
                    var state = getDoc(io).readyState;
                    log('state = ' + state);
                    if (state && state.toLowerCase() == 'uninitialized') {
                        setTimeout(checkState,50);
                    }
                }
                catch(e) {
                    log('Server abort: ' , e, ' (', e.name, ')');
                    cb(SERVER_ABORT);
                    if (timeoutHandle) {
                        clearTimeout(timeoutHandle);
                    }
                    timeoutHandle = undefined;
                }
            }

            // add "extra" data to form if provided in options
            var extraInputs = [];
            try {
                if (s.extraData) {
                    for (var n in s.extraData) {
                        if (s.extraData.hasOwnProperty(n)) {
                           // if using the $.param format that allows for multiple values with the same name
                           if($.isPlainObject(s.extraData[n]) && s.extraData[n].hasOwnProperty('name') && s.extraData[n].hasOwnProperty('value')) {
                               extraInputs.push(
                               $('<input type="hidden" name="'+s.extraData[n].name+'">').val(s.extraData[n].value)
                                   .appendTo(form)[0]);
                           } else {
                               extraInputs.push(
                               $('<input type="hidden" name="'+n+'">').val(s.extraData[n])
                                   .appendTo(form)[0]);
                           }
                        }
                    }
                }

                if (!s.iframeTarget) {
                    // add iframe to doc and submit the form
                    $io.appendTo('body');
                }
                if (io.attachEvent) {
                    io.attachEvent('onload', cb);
                }
                else {
                    io.addEventListener('load', cb, false);
                }
                setTimeout(checkState,15);

                try {
                    form.submit();
                } catch(err) {
                    // just in case form has element with name/id of 'submit'
                    var submitFn = document.createElement('form').submit;
                    submitFn.apply(form);
                }
            }
            finally {
                // reset attrs and remove "extra" input elements
                form.setAttribute('action',a);
                form.setAttribute('enctype', et); // #380
                if(t) {
                    form.setAttribute('target', t);
                } else {
                    $form.removeAttr('target');
                }
                $(extraInputs).remove();
            }
        }

        if (s.forceSync) {
            doSubmit();
        }
        else {
            setTimeout(doSubmit, 10); // this lets dom updates render
        }

        var data, doc, domCheckCount = 50, callbackProcessed;

        function cb(e) {
            if (xhr.aborted || callbackProcessed) {
                return;
            }
            
            doc = getDoc(io);
            if(!doc) {
                log('cannot access response document');
                e = SERVER_ABORT;
            }
            if (e === CLIENT_TIMEOUT_ABORT && xhr) {
                xhr.abort('timeout');
                deferred.reject(xhr, 'timeout');
                return;
            }
            else if (e == SERVER_ABORT && xhr) {
                xhr.abort('server abort');
                deferred.reject(xhr, 'error', 'server abort');
                return;
            }

            if (!doc || doc.location.href == s.iframeSrc) {
                // response not received yet
                if (!timedOut) {
                    return;
                }
            }
            if (io.detachEvent) {
                io.detachEvent('onload', cb);
            }
            else {
                io.removeEventListener('load', cb, false);
            }

            var status = 'success', errMsg;
            try {
                if (timedOut) {
                    throw 'timeout';
                }

                var isXml = s.dataType == 'xml' || doc.XMLDocument || $.isXMLDoc(doc);
                log('isXml='+isXml);
                if (!isXml && window.opera && (doc.body === null || !doc.body.innerHTML)) {
                    if (--domCheckCount) {
                        // in some browsers (Opera) the iframe DOM is not always traversable when
                        // the onload callback fires, so we loop a bit to accommodate
                        log('requeing onLoad callback, DOM not available');
                        setTimeout(cb, 250);
                        return;
                    }
                    // let this fall through because server response could be an empty document
                    //log('Could not access iframe DOM after mutiple tries.');
                    //throw 'DOMException: not available';
                }

                //log('response detected');
                var docRoot = doc.body ? doc.body : doc.documentElement;
                xhr.responseText = docRoot ? docRoot.innerHTML : null;
                xhr.responseXML = doc.XMLDocument ? doc.XMLDocument : doc;
                if (isXml) {
                    s.dataType = 'xml';
                }
                xhr.getResponseHeader = function(header){
                    var headers = {'content-type': s.dataType};
                    return headers[header.toLowerCase()];
                };
                // support for XHR 'status' & 'statusText' emulation :
                if (docRoot) {
                    xhr.status = Number( docRoot.getAttribute('status') ) || xhr.status;
                    xhr.statusText = docRoot.getAttribute('statusText') || xhr.statusText;
                }

                var dt = (s.dataType || '').toLowerCase();
                var scr = /(json|script|text)/.test(dt);
                if (scr || s.textarea) {
                    // see if user embedded response in textarea
                    var ta = doc.getElementsByTagName('textarea')[0];
                    if (ta) {
                        xhr.responseText = ta.value;
                        // support for XHR 'status' & 'statusText' emulation :
                        xhr.status = Number( ta.getAttribute('status') ) || xhr.status;
                        xhr.statusText = ta.getAttribute('statusText') || xhr.statusText;
                    }
                    else if (scr) {
                        // account for browsers injecting pre around json response
                        var pre = doc.getElementsByTagName('pre')[0];
                        var b = doc.getElementsByTagName('body')[0];
                        if (pre) {
                            xhr.responseText = pre.textContent ? pre.textContent : pre.innerText;
                        }
                        else if (b) {
                            xhr.responseText = b.textContent ? b.textContent : b.innerText;
                        }
                    }
                }
                else if (dt == 'xml' && !xhr.responseXML && xhr.responseText) {
                    xhr.responseXML = toXml(xhr.responseText);
                }

                try {
                    data = httpData(xhr, dt, s);
                }
                catch (err) {
                    status = 'parsererror';
                    xhr.error = errMsg = (err || status);
                }
            }
            catch (err) {
                log('error caught: ',err);
                status = 'error';
                xhr.error = errMsg = (err || status);
            }

            if (xhr.aborted) {
                log('upload aborted');
                status = null;
            }

            if (xhr.status) { // we've set xhr.status
                status = (xhr.status >= 200 && xhr.status < 300 || xhr.status === 304) ? 'success' : 'error';
            }

            // ordering of these callbacks/triggers is odd, but that's how $.ajax does it
            if (status === 'success') {
                if (s.success) {
                    s.success.call(s.context, data, 'success', xhr);
                }
                deferred.resolve(xhr.responseText, 'success', xhr);
                if (g) {
                    $.event.trigger("ajaxSuccess", [xhr, s]);
                }
            }
            else if (status) {
                if (errMsg === undefined) {
                    errMsg = xhr.statusText;
                }
                if (s.error) {
                    s.error.call(s.context, xhr, status, errMsg);
                }
                deferred.reject(xhr, 'error', errMsg);
                if (g) {
                    $.event.trigger("ajaxError", [xhr, s, errMsg]);
                }
            }

            if (g) {
                $.event.trigger("ajaxComplete", [xhr, s]);
            }

            if (g && ! --$.active) {
                $.event.trigger("ajaxStop");
            }

            if (s.complete) {
                s.complete.call(s.context, xhr, status);
            }

            callbackProcessed = true;
            if (s.timeout) {
                clearTimeout(timeoutHandle);
            }

            // clean up
            setTimeout(function() {
                if (!s.iframeTarget) {
                    $io.remove();
                }
                else { //adding else to clean up existing iframe response.
                    $io.attr('src', s.iframeSrc);
                }
                xhr.responseXML = null;
            }, 100);
        }

        var toXml = $.parseXML || function(s, doc) { // use parseXML if available (jQuery 1.5+)
            if (window.ActiveXObject) {
                doc = new ActiveXObject('Microsoft.XMLDOM');
                doc.async = 'false';
                doc.loadXML(s);
            }
            else {
                doc = (new DOMParser()).parseFromString(s, 'text/xml');
            }
            return (doc && doc.documentElement && doc.documentElement.nodeName != 'parsererror') ? doc : null;
        };
        var parseJSON = $.parseJSON || function(s) {
            /*jslint evil:true */
            return window['eval']('(' + s + ')');
        };

        var httpData = function( xhr, type, s ) { // mostly lifted from jq1.4.4

            var ct = xhr.getResponseHeader('content-type') || '',
                xml = type === 'xml' || !type && ct.indexOf('xml') >= 0,
                data = xml ? xhr.responseXML : xhr.responseText;

            if (xml && data.documentElement.nodeName === 'parsererror') {
                if ($.error) {
                    $.error('parsererror');
                }
            }
            if (s && s.dataFilter) {
                data = s.dataFilter(data, type);
            }
            if (typeof data === 'string') {
                if (type === 'json' || !type && ct.indexOf('json') >= 0) {
                    data = parseJSON(data);
                } else if (type === "script" || !type && ct.indexOf("javascript") >= 0) {
                    $.globalEval(data);
                }
            }
            return data;
        };

        return deferred;
    }
};

/**
 * ajaxForm() provides a mechanism for fully automating form submission.
 *
 * The advantages of using this method instead of ajaxSubmit() are:
 *
 * 1: This method will include coordinates for <input type="image" /> elements (if the element
 *    is used to submit the form).
 * 2. This method will include the submit element's name/value data (for the element that was
 *    used to submit the form).
 * 3. This method binds the submit() method to the form for you.
 *
 * The options argument for ajaxForm works exactly as it does for ajaxSubmit.  ajaxForm merely
 * passes the options argument along after properly binding events for submit elements and
 * the form itself.
 */
$.fn.ajaxForm = function(options) {
    options = options || {};
    options.delegation = options.delegation && $.isFunction($.fn.on);

    // in jQuery 1.3+ we can fix mistakes with the ready state
    if (!options.delegation && this.length === 0) {
        var o = { s: this.selector, c: this.context };
        if (!$.isReady && o.s) {
            log('DOM not ready, queuing ajaxForm');
            $(function() {
                $(o.s,o.c).ajaxForm(options);
            });
            return this;
        }
        // is your DOM ready?  http://docs.jquery.com/Tutorials:Introducing_$(document).ready()
        log('terminating; zero elements found by selector' + ($.isReady ? '' : ' (DOM not ready)'));
        return this;
    }

    if ( options.delegation ) {
        $(document)
            .off('submit.form-plugin', this.selector, doAjaxSubmit)
            .off('click.form-plugin', this.selector, captureSubmittingElement)
            .on('submit.form-plugin', this.selector, options, doAjaxSubmit)
            .on('click.form-plugin', this.selector, options, captureSubmittingElement);
        return this;
    }

    return this.ajaxFormUnbind()
        .bind('submit.form-plugin', options, doAjaxSubmit)
        .bind('click.form-plugin', options, captureSubmittingElement);
};

// private event handlers
function doAjaxSubmit(e) {
    /*jshint validthis:true */
    var options = e.data;
    if (!e.isDefaultPrevented()) { // if event has been canceled, don't proceed
        e.preventDefault();
        $(e.target).ajaxSubmit(options); // #365
    }
}

function captureSubmittingElement(e) {
    /*jshint validthis:true */
    var target = e.target;
    var $el = $(target);
    if (!($el.is("[type=submit],[type=image]"))) {
        // is this a child element of the submit el?  (ex: a span within a button)
        var t = $el.closest('[type=submit]');
        if (t.length === 0) {
            return;
        }
        target = t[0];
    }
    var form = this;
    form.clk = target;
    if (target.type == 'image') {
        if (e.offsetX !== undefined) {
            form.clk_x = e.offsetX;
            form.clk_y = e.offsetY;
        } else if (typeof $.fn.offset == 'function') {
            var offset = $el.offset();
            form.clk_x = e.pageX - offset.left;
            form.clk_y = e.pageY - offset.top;
        } else {
            form.clk_x = e.pageX - target.offsetLeft;
            form.clk_y = e.pageY - target.offsetTop;
        }
    }
    // clear form vars
    setTimeout(function() { form.clk = form.clk_x = form.clk_y = null; }, 100);
}


// ajaxFormUnbind unbinds the event handlers that were bound by ajaxForm
$.fn.ajaxFormUnbind = function() {
    return this.unbind('submit.form-plugin click.form-plugin');
};

/**
 * formToArray() gathers form element data into an array of objects that can
 * be passed to any of the following ajax functions: $.get, $.post, or load.
 * Each object in the array has both a 'name' and 'value' property.  An example of
 * an array for a simple login form might be:
 *
 * [ { name: 'username', value: 'jresig' }, { name: 'password', value: 'secret' } ]
 *
 * It is this array that is passed to pre-submit callback functions provided to the
 * ajaxSubmit() and ajaxForm() methods.
 */
$.fn.formToArray = function(semantic, elements) {
    var a = [];
    if (this.length === 0) {
        return a;
    }

    var form = this[0];
    var formId = this.attr('id');
    var els = semantic ? form.getElementsByTagName('*') : form.elements;
    var els2;

    if (els && !/MSIE [678]/.test(navigator.userAgent)) { // #390
        els = $(els).get();  // convert to standard array
    }

    // #386; account for inputs outside the form which use the 'form' attribute
    if ( formId ) {
        els2 = $(':input[form="' + formId + '"]').get(); // hat tip @thet
        if ( els2.length ) {
            els = (els || []).concat(els2);
        }
    }

    if (!els || !els.length) {
        return a;
    }

    var i,j,n,v,el,max,jmax;
    for(i=0, max=els.length; i < max; i++) {
        el = els[i];
        n = el.name;
        if (!n || el.disabled) {
            continue;
        }

        if (semantic && form.clk && el.type == "image") {
            // handle image inputs on the fly when semantic == true
            if(form.clk == el) {
                a.push({name: n, value: $(el).val(), type: el.type });
                a.push({name: n+'.x', value: form.clk_x}, {name: n+'.y', value: form.clk_y});
            }
            continue;
        }

        v = $.fieldValue(el, true);
        if (v && v.constructor == Array) {
            if (elements) {
                elements.push(el);
            }
            for(j=0, jmax=v.length; j < jmax; j++) {
                a.push({name: n, value: v[j]});
            }
        }
        else if (feature.fileapi && el.type == 'file') {
            if (elements) {
                elements.push(el);
            }
            var files = el.files;
            if (files.length) {
                for (j=0; j < files.length; j++) {
                    a.push({name: n, value: files[j], type: el.type});
                }
            }
            else {
                // #180
                a.push({ name: n, value: '', type: el.type });
            }
        }
        else if (v !== null && typeof v != 'undefined') {
            if (elements) {
                elements.push(el);
            }
            a.push({name: n, value: v, type: el.type, required: el.required});
        }
    }

    if (!semantic && form.clk) {
        // input type=='image' are not found in elements array! handle it here
        var $input = $(form.clk), input = $input[0];
        n = input.name;
        if (n && !input.disabled && input.type == 'image') {
            a.push({name: n, value: $input.val()});
            a.push({name: n+'.x', value: form.clk_x}, {name: n+'.y', value: form.clk_y});
        }
    }
    return a;
};

/**
 * Serializes form data into a 'submittable' string. This method will return a string
 * in the format: name1=value1&amp;name2=value2
 */
$.fn.formSerialize = function(semantic) {
    //hand off to jQuery.param for proper encoding
    return $.param(this.formToArray(semantic));
};

/**
 * Serializes all field elements in the jQuery object into a query string.
 * This method will return a string in the format: name1=value1&amp;name2=value2
 */
$.fn.fieldSerialize = function(successful) {
    var a = [];
    this.each(function() {
        var n = this.name;
        if (!n) {
            return;
        }
        var v = $.fieldValue(this, successful);
        if (v && v.constructor == Array) {
            for (var i=0,max=v.length; i < max; i++) {
                a.push({name: n, value: v[i]});
            }
        }
        else if (v !== null && typeof v != 'undefined') {
            a.push({name: this.name, value: v});
        }
    });
    //hand off to jQuery.param for proper encoding
    return $.param(a);
};

/**
 * Returns the value(s) of the element in the matched set.  For example, consider the following form:
 *
 *  <form><fieldset>
 *      <input name="A" type="text" />
 *      <input name="A" type="text" />
 *      <input name="B" type="checkbox" value="B1" />
 *      <input name="B" type="checkbox" value="B2"/>
 *      <input name="C" type="radio" value="C1" />
 *      <input name="C" type="radio" value="C2" />
 *  </fieldset></form>
 *
 *  var v = $('input[type=text]').fieldValue();
 *  // if no values are entered into the text inputs
 *  v == ['','']
 *  // if values entered into the text inputs are 'foo' and 'bar'
 *  v == ['foo','bar']
 *
 *  var v = $('input[type=checkbox]').fieldValue();
 *  // if neither checkbox is checked
 *  v === undefined
 *  // if both checkboxes are checked
 *  v == ['B1', 'B2']
 *
 *  var v = $('input[type=radio]').fieldValue();
 *  // if neither radio is checked
 *  v === undefined
 *  // if first radio is checked
 *  v == ['C1']
 *
 * The successful argument controls whether or not the field element must be 'successful'
 * (per http://www.w3.org/TR/html4/interact/forms.html#successful-controls).
 * The default value of the successful argument is true.  If this value is false the value(s)
 * for each element is returned.
 *
 * Note: This method *always* returns an array.  If no valid value can be determined the
 *    array will be empty, otherwise it will contain one or more values.
 */
$.fn.fieldValue = function(successful) {
    for (var val=[], i=0, max=this.length; i < max; i++) {
        var el = this[i];
        var v = $.fieldValue(el, successful);
        if (v === null || typeof v == 'undefined' || (v.constructor == Array && !v.length)) {
            continue;
        }
        if (v.constructor == Array) {
            $.merge(val, v);
        }
        else {
            val.push(v);
        }
    }
    return val;
};

/**
 * Returns the value of the field element.
 */
$.fieldValue = function(el, successful) {
    var n = el.name, t = el.type, tag = el.tagName.toLowerCase();
    if (successful === undefined) {
        successful = true;
    }

    if (successful && (!n || el.disabled || t == 'reset' || t == 'button' ||
        (t == 'checkbox' || t == 'radio') && !el.checked ||
        (t == 'submit' || t == 'image') && el.form && el.form.clk != el ||
        tag == 'select' && el.selectedIndex == -1)) {
            return null;
    }

    if (tag == 'select') {
        var index = el.selectedIndex;
        if (index < 0) {
            return null;
        }
        var a = [], ops = el.options;
        var one = (t == 'select-one');
        var max = (one ? index+1 : ops.length);
        for(var i=(one ? index : 0); i < max; i++) {
            var op = ops[i];
            if (op.selected) {
                var v = op.value;
                if (!v) { // extra pain for IE...
                    v = (op.attributes && op.attributes.value && !(op.attributes.value.specified)) ? op.text : op.value;
                }
                if (one) {
                    return v;
                }
                a.push(v);
            }
        }
        return a;
    }
    return $(el).val();
};

/**
 * Clears the form data.  Takes the following actions on the form's input fields:
 *  - input text fields will have their 'value' property set to the empty string
 *  - select elements will have their 'selectedIndex' property set to -1
 *  - checkbox and radio inputs will have their 'checked' property set to false
 *  - inputs of type submit, button, reset, and hidden will *not* be effected
 *  - button elements will *not* be effected
 */
$.fn.clearForm = function(includeHidden) {
    return this.each(function() {
        $('input,select,textarea', this).clearFields(includeHidden);
    });
};

/**
 * Clears the selected form elements.
 */
$.fn.clearFields = $.fn.clearInputs = function(includeHidden) {
    var re = /^(?:color|date|datetime|email|month|number|password|range|search|tel|text|time|url|week)$/i; // 'hidden' is not in this list
    return this.each(function() {
        var t = this.type, tag = this.tagName.toLowerCase();
        if (re.test(t) || tag == 'textarea') {
            this.value = '';
        }
        else if (t == 'checkbox' || t == 'radio') {
            this.checked = false;
        }
        else if (tag == 'select') {
            this.selectedIndex = -1;
        }
        else if (t == "file") {
            if (/MSIE/.test(navigator.userAgent)) {
                $(this).replaceWith($(this).clone(true));
            } else {
                $(this).val('');
            }
        }
        else if (includeHidden) {
            // includeHidden can be the value true, or it can be a selector string
            // indicating a special test; for example:
            //  $('#myForm').clearForm('.special:hidden')
            // the above would clean hidden inputs that have the class of 'special'
            if ( (includeHidden === true && /hidden/.test(t)) ||
                 (typeof includeHidden == 'string' && $(this).is(includeHidden)) ) {
                this.value = '';
            }
        }
    });
};

/**
 * Resets the form data.  Causes all form elements to be reset to their original value.
 */
$.fn.resetForm = function() {
    return this.each(function() {
        // guard against an input with the name of 'reset'
        // note that IE reports the reset function as an 'object'
        if (typeof this.reset == 'function' || (typeof this.reset == 'object' && !this.reset.nodeType)) {
            this.reset();
        }
    });
};

/**
 * Enables or disables any matching elements.
 */
$.fn.enable = function(b) {
    if (b === undefined) {
        b = true;
    }
    return this.each(function() {
        this.disabled = !b;
    });
};

/**
 * Checks/unchecks any matching checkboxes or radio buttons and
 * selects/deselects and matching option elements.
 */
$.fn.selected = function(select) {
    if (select === undefined) {
        select = true;
    }
    return this.each(function() {
        var t = this.type;
        if (t == 'checkbox' || t == 'radio') {
            this.checked = select;
        }
        else if (this.tagName.toLowerCase() == 'option') {
            var $sel = $(this).parent('select');
            if (select && $sel[0] && $sel[0].type == 'select-one') {
                // deselect all other options
                $sel.find('option').selected(false);
            }
            this.selected = select;
        }
    });
};

// expose debug var
$.fn.ajaxSubmit.debug = false;

// helper fn for console logging
function log() {
    if (!$.fn.ajaxSubmit.debug) {
        return;
    }
    var msg = '[jquery.form] ' + Array.prototype.join.call(arguments,'');
    if (window.console && window.console.log) {
        window.console.log(msg);
    }
    else if (window.opera && window.opera.postError) {
        window.opera.postError(msg);
    }
}

}));

/**
 * 获取 url 中的参数
 */
 (function ($) {
     $.getUrlParam = function (name) {
         var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
         var r = window.location.search.substr(1).match(reg);
         if (r != null) return unescape(r[2]); return null;
     }
 })(jQuery);

//# sourceMappingURL=user.js.map
