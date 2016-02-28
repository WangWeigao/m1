$(document).ready(function() {
    $("table").dataTable();
    // 根据按钮的不同含义, 指定不同的CSS样式
    $(".lockteacher").each(function (index, domEle) {
        // if ($(this).text() == '解锁') {
        //     $(this).attr('class', 'btn btn-danger');
        // }else {
        //     $(this).attr('class', 'btn btn-success');
        // }

        $(domEle).click(function () {
            $.get(
                '/lockteacher/' + $(domEle).attr('id'),
                function(data) {
                    if (data == 1) {
                        // alert( $(domEle).attr('id') );
                        $(domEle).text('解锁');
                        $(domEle).attr('class', 'btn btn-danger btn-sm');
                        $(domEle).parent().parent().next().text('已锁定');
                    }else {
                        $(domEle).text('锁定');
                        $(domEle).attr("class", "btn btn-success btn-sm");
                        $(domEle).parent().parent().next().text('未锁定');
                    }
                }
            );
        });
    });


});
