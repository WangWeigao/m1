$(document).ready(function() {
    var url = window.location.pathname;
    switch (url) {
        case '/home':
            $("#home").addClass('active');
            break;
        case '/user':
            $("#user-manager").addClass('active');
            break;
        case '/teacher':
            $("#teacher-manager").addClass('active');
            break;
        case '/order':
            $("#order-manager").addClass('active');
            break;

        default:

    }
    // $("div ul li").click(functon() {
    //     $(this).addClass('active');
    // });
});
