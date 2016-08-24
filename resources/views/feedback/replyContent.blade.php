<div class="modal fade" id="replyContent" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="">回复内容</h4>
      </div>
      <div class="modal-body">
        <select class="form-control" name="replyContent" v-model="reply_content">
            <option>请选择回复内容</option>
            <option>谢谢您的反馈,我们会尽快完善曲库</option>
            <option>谢谢您的反馈,我们会尽快解决您的问题</option>
            <option>我们已添加您所需的曲目,请尽快享用</option>
            <option>手动回复</option>
        </select>
        <input type="text" class="form-control" v-model="manual_reply" v-if="reply_content=='手动回复'">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="reply_ajax" class="btn btn-primary" disabled="@{{ reply_content=='请选择回复内容' ? true : false}}" @click="reply(id)" data-dismiss="modal">回复</button>
      </div>
    </div>
  </div>
</div>
