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
     * 自动拉取筛选条件列表
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
        /**
         * 拉取“乐器”列表
         */
        $.each(data.instrument, function(n, value) {
            var $str = "";
            $str = "<option value=" + value.id + ">" + value.name + "</option>";
            $("#instrument").append($str);
        });

        /**
         * 拉取“出版社”列表
         */
        $.each(data.press, function(n, value) {
            var $str = "";
            $str = "<option value=" + value.id + ">" + value.name + "</option>";
            $("#press").append($str);
        });

        /**
         * 拉取"乐曲类别"列表
         */
        $.each(data.tag, function(n, value) {
            var $str = "";
            $str = "<option value=" + value.id + ">" + value.name + "</option>";
            $("#category").append($str);
        });
    })
    .fail(function(data) {
        console.log(data);
    });

    /**
     * select下拉式日期选择器
     */
     var myDate = new Date();
     $("#dateSelector").DateSelector({
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
     * 按筛选条件搜索
     */
    $("#date").val($("#idYear").val() + '-' + $("#idMonth").val() + '-' + $("#idDay").val());
    $("select").each(function(index, el) {
        $(el).bind('change', function() {
            // $(el).closest('input').val($(el).val());
            $(el).siblings('input').val($(el).val());
            if ($(el).attr('id') === 'idYear' || $(el).attr('id') === 'idMonth' || $(el).attr('id') === 'idDay') {
                $("#date").val($("#idYear").val() + '-' + $("#idMonth").val() + '-' + $("#idDay").val());
            }
            console.log($(el).val());
        });
    });


});
