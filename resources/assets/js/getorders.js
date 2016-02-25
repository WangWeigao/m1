$(document).ready(function() {
    // 点击"查看"按钮
    $(".detail").each(function(index, el) {
        $(this).click(function() {
            $.get(
                '/order/' + $(el).attr("id"),
                function(data) {
                    $result =
                    "<tr><td>" + data.oid +
                    "</td><td>" + data.lid +
                    "</td><td>" + data.student_uid +
                    "</td><td>" + data.method +
                    "</td><td>" + data.lasts +
                    "</td><td>" + data.submit_time +
                    "</td><td>" + data.price +
                    "</td><td>" + data.status +
                    "</td></tr>";
                    $(".modal-body table tr:eq(1)").replaceWith($result);
                }
            );
        });
    });
});
