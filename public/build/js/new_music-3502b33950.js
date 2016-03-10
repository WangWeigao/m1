$(document).ready(function() {
    /**
     * 点击新建按钮
     */
    $("#createMusic").click(function() {
        ajaxSubmitForm();
        function ajaxSubmitForm() {
           var value = $("#midi-file").val();
           if (isEmpty(value)) {
               alert("请先选择文件");
               return false;
           }
           function isEmpty( inputStr ) {
               if ( null == inputStr || "" == inputStr ) {
                   return true;
               }
               return false;
            }
           if (!value.match(/.mid/i)) {
               alert("文件格式错误");
               return false;
           }
           var option = {
               url : 'music',
               type : 'POST',
               dataType : 'json',
               data: {
                   'name': $("#title").val(),
                   'author': $("#author").val()
               },
               headers : {
                //    "ClientCallMode" : "ajax"
                   'X-CSRF-TOKEN': $('input[name="_token"]').val()
               }, //添加请求头部
               success : function(data) {
                   $("#addResult").html("添加成功");
                   $("#addResult").hide('slow', function() {

                   });

               },
               error : function(data) {
                   alert(JSON.stringify(data) + "--上传失败,请刷新后重试");
               }
           };
           $("#add_music").ajaxSubmit(option);
           return false; //最好返回false，因为如果按钮类型是submit,则表单自己又会提交一次;返回false阻止表单再次提交
        }
    });

    // 点击"编辑"按钮
    $(".edit").each(function(index, el) {
        $(this).click(function() {
            $("#edit_id").val($(el).closest('tr').attr('id'));
            $("#edit_title").val($(el).closest('tr').find('td:eq(0)').text());
            $("#edit_author").val($(el).closest('tr').find('td:eq(1)').text());
        });
    });

    // 点击"保存修改"按钮
    $("#save").bind('click', function(event) {
        ajaxSubmitForm();
        function ajaxSubmitForm() {
            var $id_value = $("#edit_id").val();
            var option = {
                url : 'music/' + $id_value,
                type : 'put',
                dataType : 'json',
                data : {
                    'name' : $("#edit_title").val(),
                    'author' : $("#edit_author").val()
                },
                headers : {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                success : function(data) {
                    $("#addResult").html("修改成功!");
                },
                error : function(data) {
                    alert('哦，出了点小问题，再试一次吧');
                }
                // error : function(data) {
                //     alert(JSON.stringify(data) + "--添加失败, 请重试");
                // }
            }
            $("#save_detail").ajaxSubmit(option);
            return false;
        }
    });

    // 点击"删除"按钮
    $(".delete").each(function(indel, el) {
        $(this).bind('click', function(event) {
            $.ajax({
                url: '/music/' + $(el).closest('tr').attr('id'),
                type: 'DELETE',
                dataType: 'json',
                headers : {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                }
            })
            .done(function() {
                console.log("success");
                $(el).closest('tr').remove();

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
     * 自动拉取筛选待件
     */
    $.ajax({
        url: '/music/condations',
        type: 'GET',
        dataType: 'json',
        headers : {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        }
    })
    .done(function(data) {
        console.log("success");
        $.each(data, function(n, value) {
            var $str = "";
            $str = "<option value=" + value.id + ">" + value.name + "</option>";
            $("#instruments").append($str);
        });
    })
    .fail(function(data) {
        console.log(data);
    })
    .always(function() {
        console.log("complete");
    });

    /**
     * select下拉式日期选择器
     */
     $("#calendar").dateSelector({
         ctlYearId: null,
         ctlMonthId: null,
         ctlDayId: null,
         defYear: 2000,
         defMonth: 2,
         defDay: 1,
         minYear: 1882,
         maxYear: 3000
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
});

//# sourceMappingURL=new_music.js.map
