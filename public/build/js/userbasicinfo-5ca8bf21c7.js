$(document).ready(function() {
    /**
     * 锁定用户
     */
     $(".lockuser").each(function(index, el) {
         $(el).click(function(event) {
             var id = $(el).attr('id');
             $.ajax({
                 url: '/user/lockuser/' + id,
                 type: 'GET',
                 dataType: 'json'
             })
             .done(function(data) {
                 if (data) {
                     $(el).attr('class', 'lockuser btn btn-danger');
                     $(el).text('锁定');
                     $("td:contains('状态')").next().text('正常');
                 } else {
                     $(el).attr('class', 'lockuser btn btn-info');
                     $(el).text('解锁');
                     $("td:contains('状态')").next().text('锁定');
                 }
             })
             .fail(function() {
                 console.log("error");
             })
             .always(function() {
                 console.log("complete");
             });

         });
     });


});

//# sourceMappingURL=userbasicinfo.js.map