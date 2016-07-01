<div class="modal fade add_teacher" id="" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="">添加教师</h4>
      </div>
      <div class="modal-body">
          <form action="/teacher" method="post" id="add_teacher">
              {!! csrf_field() !!}
              <div class="form-group">
                  <label for="">教师名:</label>
                  <input type="text" name="teacher_name" value="" placeholder="" class="form-control">
              </div>

              <div class="form-group">
                  <label for="">联系电话:</label>
                  <input type="text" name="cell_phone" value="" placeholder="" class="form-control">
              </div>

              <div class="form-group">
                  <label for="">电子邮箱:</label>
                  <input type="text" name="email" value="" placeholder="" class="form-control">
              </div>

              <button type="button" id="generate_invite_code" class="btn btn-info" style="margin-bottom: 5px;">生成邀请码</button>

              <div class="form-group">
                  <label for="">邀请码编号:</label>
                  <input class="form-control" id="disabledInput" type="text" placeholder="" readonly="readonly" name="disabledInput">
                  <input type="hidden" name="invite_code" value="">
              </div>

              <div class="form-group">
                  <label for="">交易方式:</label>
                  <input type="text" name="bank_name" value="" placeholder="银行/支付宝 名称" class="form-control">
                  <input type="text" name="payment_account" value="" placeholder="帐号" class="form-control">
              </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="save_teacher">保存</button>
      </div>
  </form>
    </div>
  </div>
</div>
