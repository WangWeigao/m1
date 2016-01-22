$(document).ready(function() {
    $("#lockuser").click(function () {
        $.get(
            '/lockuser/' + $("#user_id").html(),
            function(data) {
                if (data == 1) {
                    $("#lockuser").html('解锁');
                    $("#lockuser").attr('class', 'btn btn-danger');
                    $("#isactive").html('已锁定');
                }else {
                    $("#lockuser").html('锁定');
                    $("#lockuser").attr('class', 'btn btn-warning');
                    $("#isactive").html('未锁定');
                }
            }
        );
    });


});
