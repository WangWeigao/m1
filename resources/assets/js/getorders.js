$(document).ready(function() {
    $(".lockorder").each(function (index, domEle) {
        $(domEle).click(function () {
            $.get(
                '/lockorder/' + $(domEle).attr('id'),
                function(data) {
                    if (data == 1) {

                    }
                }
            );
        });
    });

    // 点击"查看"按钮
    $(".detail").click(function () {
        window.location.replace( '/orderdetail/' + $(this).attr('id') );
    });
});
