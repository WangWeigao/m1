$(document).ready(function() {
    // 使用js插件批量上传midi文件和属性
    var extraObj = $("#extraupload").uploadFile({
    url:"upload.php",
    fileName:"myfile",
    extraHTML:function()
    {
           var html = "<div><b>File Tags:</b><input type='text' name='tags' value='' /> <br/>";
           html += "<b>Category</b>:<select name='category'><option value='1'>ONE</option><option value='2'>TWO</option></select>";
           html += "</div>";
           return html;
    },
    autoSubmit:false
    });
    $("#extrabutton").click(function()
    {

       extraObj.startUpload();
    });
});

//# sourceMappingURL=musicadd.js.map
