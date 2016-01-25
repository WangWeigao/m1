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
});
