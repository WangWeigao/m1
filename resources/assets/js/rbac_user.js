$(document).ready(function() {
    // 点击"编辑"按钮
    $(".rbac_edit").each(function(index, el) {
        $(this).click(function() {
            $("#rbac_id").val($(el).closest('tr').find('td:eq(0)').text());
            $("#rbac_name").val($(el).closest('tr').find('td:eq(1)').text());
            $("#rbac_email").val($(el).closest('tr').find('td:eq(2)').text());
            $("#rbac_role").val($.trim($(el).closest('tr').find('div').attr('id')));
            $("#rbac_origin_role").val($.trim($(el).closest('tr').find('div').attr('id')));
        });
    });

    // 点击"保存修改"按钮
    $("#rbac_save").bind('click', function(event) {
        ajaxSubmitForm();
        function ajaxSubmitForm() {
            var $id = $("#rbac_id").val();
            var $name = $("#rbac_name").val();
            var $email = $("#rbac_email").val();
            var $origin_role = $("#rbac_origin_role").val();
            var $role = $("#rbac_role").val();

            var option = {
                url : 'rbac/' + $id,
                type : 'put',
                dataType : 'json',
                data : {
                    'id' : $id,
                    'name' : $name,
                    'email' : $email,
                    'origin_role' : $origin_role,
                    'role' : $role
                },
                headers : {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                success : function(data) {
                    // $("tr:[id=$id] div[id=$role]").text('23478')
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
        location.reload();
    });

    // 点击"删除"按钮
    $(".rbac_remove").each(function(indel, el) {
        $(this).bind('click', function(event) {
            var $role = $.trim($(el).closest('tr').find('div').attr('id'));
            $.ajax({
                url: '/rbac/' + $(el).closest('tr').attr('id') + '?role=' + $role,
                type: 'DELETE',
                dataType: 'json',
                headers : {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                success : function(data) {
                    $(el).closest('tr').remove();
                }
            })
            .done(function() {
                console.log("success");
            })
            .fail(function() {
                console.log("error");
            })
            .always(function() {
                console.log("complete");
            });
        });
    });
});
