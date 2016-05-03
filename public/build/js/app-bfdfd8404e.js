$(document).ready(function() {
    var url = window.location.pathname;
    var patt = new RegExp('\d');
    switch (url) {
        case '/home':
            $("#home").addClass('active');
            break;
        case '/music':
        case '/music/musicStatistics':
            $("#music").addClass('active');
            break;
        case '/user':
        case '/user/usageStatistics':
        case '/user/playRecords':
            $("#user-manager").addClass('active');
            break;
        case '/teacher':
        case '/getteachers':
            $("#teacher-manager").addClass('active');
            break;
        case '/order':
        case '/order/statistics':
            $("#order-manager").addClass('active');
            break;
        case '/lesson':
            $("#lesson-manager").addClass('active');
        default:

    }
    // $("div ul li").click(functon() {
    //     $(this).addClass('active');
    // });
});

//# sourceMappingURL=app.js.map
