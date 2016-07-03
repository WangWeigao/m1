<div class="modal fade" id="edit_info" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="">更新新版本信息</h4>
      </div>
      <div class="modal-body">
          {{ csrf_field() }}
          {{-- <div class="input-group"> --}}
            <label class="">版本号</label>
            <input type="text" class="form-control" placeholder="" name="version">
          {{-- </div>
          <div class="input-group"> --}}
            <label class="">url地址</label>
            <input type="text" class="form-control" placeholder="" name="url">
          {{-- </div>
          <div class="input-group"> --}}
            <label class="">详细信息</label>
            <input type="text" class="form-control" placeholder="" name="detail">
          {{-- </div>
          <div class="input-group"> --}}
            {{-- <label class="">类型</label>
            <select class="" name="info_type">
                <option value="0">Android</option>
                <option value="1">IOS</option>
            </select> --}}
          {{-- </div>
          <div class="input-group"> --}}
            <label class="">强制更新</label>
            <select class="form-control" name="force_update">
                <option value="1">是</option>
                <option value="0">否</option>
            </select>
          {{-- </div> --}}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button type="button" class="btn btn-primary" data-id="">更新</button>
      </div>
    </div>
  </div>
</div>
