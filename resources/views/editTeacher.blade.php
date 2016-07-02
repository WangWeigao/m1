<div class="modal fade" id="edit_teacher" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="">编辑机构信息</h4>
      </div>
      <div class="modal-body">
          <form action="#" method="post" id="add_institution">
              {!! csrf_field() !!}
              {!! method_field('PUT') !!}

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
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button type="button" class="btn btn-primary" id="save_ins_info">保存</button>
      </div>
    </div>
  </div>
</div>
