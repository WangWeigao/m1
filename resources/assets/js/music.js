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



});
