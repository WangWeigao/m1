$(document).ready(function() {
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
            $("#edit_title").val($(el).closest('tr').find('td:eq(0)').text());
            $("#edit_author").val($(el).closest('tr').find('td:eq(1)').text());
        });
    });
});
