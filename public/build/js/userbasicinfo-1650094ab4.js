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

     /**
      * 通知单个用户
      */
      $("#send_message").bind('click', function(event) {
          var ids = [$("#notifyuser").attr('data-value')];
          console.log($("#notifyuser").attr('data-value'));
          $confirm = confirm('确定要通知用户?');
          if ($confirm) {
              switch ($("#select_multi").val()) {
                  case '1':
                     var message = '账号到期';
                      break;
                  case '2':
                     var message = '资料到期';
                      break;
                  case '3':
                     var message = '违规与禁言';
                      break;
                  case '4':
                     var message = '重新提交资料:' + $("input[name='message']").val();
                      break;
                  default:
              }
              $.ajax({
                  url: '/user/notifyUsers',
                  type: 'POST',
                  dataType: 'json',
                  data: {
                      'user_id': ids,
                      'message': message
                  },
                  headers: {
                      'X-CSRF-TOKEN': $("input[name=_token]").val()
                  }
              })
              .done(function() {
                  alert("通知成功！");
                  // 关闭模态框
                  $(".m_notify_all").modal('hide');
                  // 取消所有的选中项
                  $("input[name='user_action[]']:checked").each(function(index, el) {
                      $(el).prop('checked', false);
                  });
              })
              .fail(function() {
                  alert('通知失败！');
                  // 关闭模态框
                  $(".m_notify_all").modal('hide');
                  // 取消所有的选中项
                  $("input[name='user_action[]']:checked").each(function(index, el) {
                      $(el).prop('checked', false);
                  });
              })
          }
      });
});

//# sourceMappingURL=userbasicinfo.js.map
