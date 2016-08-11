$(document).ready(function() {
    // 时间插件
    $('#datepicker').datepicker({
        format: "yyyy/mm/dd",
        todayBtn: "linked",
        todayHighlight: true,
        language: "zh-CN",
        autoclose: true
    });

/**
     * 点击"创建"按钮(相当于点击"新建"之后的保存)
     */
    $("#createMusic").click(function() {
        ajaxSubmitForm();
        function ajaxSubmitForm() {
           var value = $("#add_midi_file").val();
        //    验证上传文件是否为空
           if (isEmpty(value)) {
               alert('请先添加文件');
               return false;
           }else if (isEmpty($("#add_name").val())) {
               alert('乐曲名不能为空');
               return false;
           }else if (isEmpty($("#add_composer").val())) {
               alert('作曲人不能为空');
               return false;
           }
           /**
            * 验证变量是否为空
            * @method isEmpty
            * @param  {[type]}  inputStr [传入变量]
            * @return {Boolean}          [返回的boolean值]
            */
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
                   'instrument': $("#add_instrument").val(),
                   'name': $("#add_name").val(),
                   'composer': $("#add_composer").val(),
                   'version': $("#add_version").val(),
                   'press': $("#add_press").val(),
                   'organizer': $("#add_organizer").val(),
                   'category': $("#add_category").val(),
                   'level': $("#add_level").val(),
                   'note_content': $("#add_note_content").val(),
               },
               headers : {
                //    "ClientCallMode" : "ajax"
                   'X-CSRF-TOKEN': $('input[name="_token"]').val()
               }, //添加请求头部
               success : function(data) {
                //    $("#addResult").html("添加成功");
                //    $("#addResult").hide('slow', function() {
                   //
                //    });

                    alert('添加成功!');
                    $("#newPopup").modal('hide');

               },
               error : function(data) {
                //    console.log(JSON.stringify(data) + "--上传失败,请刷新后重试");
                alert('上传失败,请刷新后重试!');
               }
           };
           $("#add_music").ajaxSubmit(option);
           return false; // 最好返回false，因为如果按钮类型是submit,则表单自己又会提交一次;返回false阻止表单再次提交
        }
    });

    // 点击"编辑"按钮
    $(".edit").each(function(index, el) {
        $(this).click(function() {
            $("#edit_id").val($(el).closest('tr').attr('id'));                                      // 乐曲id
            $("#edit_instrument").val($(el).closest('tr').find('td:eq(1)').attr('class'));          // 乐器
            $("#edit_name").val($(el).closest('tr').find('td:eq(2)').text());                       // 乐曲名
            $("#edit_composer").val($(el).closest('tr').find('td:eq(3)').text());                   // 作曲人
            $("#edit_version").val($(el).closest('tr').find('td:eq(4)').text());                    // 版本
            $("#edit_press").val($(el).closest('tr').find('td:eq(5)').attr('class'));               // 出版社
            $("#edit_organizer").val($(el).closest('tr').find('td:eq(6)').attr('class'));           // 主办机构
            // $("#edit_category").val($(el).closest('tr').find('td:eq(7) span').attr('class'));    // 乐曲类别
            $("#edit_level").val($(el).closest('tr').find('td:eq(7)').attr('class'));               // 乐曲等级
            $("#edit_category_old").val($(el).closest('tr').find('td:eq(7) span').attr('class'))    // 改变之前的"乐曲类别"
            $("#edit_section_duration").val($.trim($(el).closest('tr').find('td:eq(13)').text()));  // 分段时间
            $("#edit_track").val($.trim($(el).closest('tr').find('td:eq(14)').text()));             // 轨道
            $("#edit_notes").val($(el).closest('tr').find('.note_content').text());                 // 备注
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
                    'id': $("#edit_id").val(),
                    'instrument': $("#edit_instrument").val(),
                    'name': $("#edit_name").val(),
                    'composer': $("#edit_composer").val(),
                    'version': $("#edit_version").val(),
                    'press': $("#edit_press").val(),
                    'organizer': $("#edit_organizer").val(),
                    // 'category': $("#edit_category").val(),
                    // 'category_old': $("#edit_category_old").val(),
                    'level': $("#edit_level").val(),
                    'section_duration': $("#edit_section_duration").val(),
                    'track': $("#edit_track").val(),
                    'notes': $("#edit_notes").val()
                },
                headers : {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                success : function(data) {
                    location.reload();
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
    /**
     * 点击"审核通过"按钮
     */
    $(".putaway").each(function(index, el) {
        $(this).bind('click', function(event) {
            $result = confirm('确认通过审核?');
            if ($result) {
                $.getJSON('/music/putaway/' + $(el).closest('tr').attr('id'), function(json, textStatus) {
                    location.reload();
                });
            }
        });
    });
    // 点击"下架"按钮
    $(".delete").each(function(indel, el) {
        $(this).bind('click', function(event) {
            $result = confirm('确认要下架这首乐曲?');
            if ($result) {
                $.ajax({
                    url: '/music/' + $(el).closest('tr').attr('id'),
                    type: 'DELETE',
                    dataType: 'json',
                    headers : {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    }
                })
                .done(function() {
                    // console.log("success");
                    $(el).closest('tr').remove();

                });
            }
        });
    });

    /**
     * 点击“添加多个乐曲”跳转到指定页面
     */
    $("#add_multi_musics").bind('click', function(event) {
        window.location.href = "/music/create";
    });


    // 实现全选按钮功能
    $("#checkAll").click(function(event) {
        if ($("#checkAll").prop('checked')) {
            $(".list :checkbox").prop('checked', true);
        }else {
            $(".list :checkbox").prop('checked', false);
        }
    });

    // 完善全选checkbox状态
    $(".list :checkbox").click(function() {
        allchk();
    });

    // 检查是否处于全选状态
    function allchk() {
        var chksum = $(".list :checkbox").size();
        var chk = 0;
        $(".list :checkbox:checked").each(function(index, el) {
            chk++;
        });
        if (chksum == chk) {
            $("#checkAll").prop('checked', true);
        }else {
            $("#checkAll").prop('checked', false);
        }
    }



    /**
     * 批量审核通过
     */
    $("#allow_all").bind('click', function() {
        var ids = [];
        $("input[name='music_action[]']:checked").each(function(index, el) {
            ids.push($(el).closest('tr').attr('id'));
        });
        $confirm = confirm('确认要批量审核通过所选乐曲?');
        if ($confirm) {
            $.ajax({
                url: '/music/putawayMany',
                type: 'PUT',
                dataType: 'json',
                data: {'ids': ids},
                headers: {
                    'X-CSRF-TOKEN': $("input[name='_token']").val()
                }
            })
            .done(function() {
                location.reload();
            })
        }
    });

    /**
     * 批量下架
     */
    $("#off_shelf").bind('click', function () {
        var ids = [];
        $("input[name='music_action[]']:checked").each(function(index, el) {
            ids.push($(el).closest('tr').attr('id'));
        });
        $confirm = confirm('确认要批量下架所选乐曲?');
        if ($confirm) {
            $.ajax({
                url: '/music/offshelfMany',
                type: 'DELETE',
                dataType: 'json',
                data: {'ids': ids},
                headers: {
                    'X-CSRF-TOKEN': $("input[name='_token']").val()
                }
            })
            .done(function() {
                location.reload();
            })
        }

    });

    // var d = new Date();
    // console.log(d.getFullYear());
    // $('.form_date input').val(d.getFullYear()+'-'+parseInt(d.getMonth()+1)+'-'+d.getDate());
});

// 为获取当前日期定义变量
months = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12']
var d=new Date()
var day=d.getDate()
var month=months[d.getMonth()]
var year=d.getFullYear()

// 对筛选条件进行数据绑定
var vm = new Vue({
    el: "#query_condition",
    data: {
        // 获取查询后返回的条件, 以便对页面进行设置, 保持查询条件不被重置
        instrument: $("#instrument").attr('data-value') ? $("#instrument").attr('data-value')   : $("#instrument").val(),
        press:      $("#press").attr('data-value')      ? $("#press").attr('data-value')        : $("#press").val(),
        category:   $("#category").attr('data-value')   ? $("#category").attr('data-value')     : $("#category").val(),
        organizer:  $("#organizer").attr('data-value')  ? $("#organizer").attr('data-value')    : $("#organizer").val(),
        operator:   $("#operator").attr('data-value')   ? $("#operator").attr('data-value')     : $("#operator").val(),
        onshelf:    $("#onshelf").attr('data-value')    ? $("#onshelf").attr('data-value')      : $("#onshelf").val(),
        version:    $("#version").attr('data-value')    ? $("#version").attr('data-value')      : $("#version").val(),
        level:      $("#level").attr('data-value')      ? $("#level").attr('data-value')        : $("#level").val(),
        date:       $("#datepicker").attr('data-value') ? $("#datepicker").attr('data-value')   : year+'/'+month+'/'+day,
    }
})
