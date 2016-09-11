$(document).ready(function() {
    // 搜索关键字
    if (localStorage.keyword) {
        $("input[name=keyword]").val(localStorage.keyword);
    }

    // 按时间排序
    if (localStorage.field_date) {
        $("input[name=field_date]").prop('checked', true);
    }

    // 搜索当天结果
    if (localStorage.field_today) {
        $("input[name=field_today]").prop('checked', true);
    }

    $("button").click(function(event) {
        // 搜索关键字
        if ($("input[name=keyword]").val()) {
            localStorage.keyword = $("input[name=keyword]").val();
        } else {
            localStorage.removeItem('keyword');
        }

        // 按时间排序
        if ($("input[name=field_date]").prop('checked')) {
            localStorage.field_date = $("input[name=field_date]").val(true);
        } else {
            localStorage.removeItem('field_date');
        }

        // 搜索当天结果
        if ($("input[name=field_today]").prop('checked')) {
            localStorage.field_today = $("input[name=field_today]").val(true);
        } else {
            localStorage.removeItem('field_today');
        }

        // 点击"回复"按钮时,将对应的ID赋值给modal
        $(".operate_reply").each(function(index, el) {
            $(el).click(function(event) {
                $("#reply_ajax").val($(el).attr('data-value'));
                console.log($("#reply_ajax").val());
                event.preventDefault();
            });
        });

    });

});
var vm = new Vue({
    el: 'body',
    data: {
        reply_content: '请选择回复内容',
        manual_reply: '',
        reply_id: 0,
    },
    methods: {
        reply: function(id) {
            this.$http.put('/manage_feedback/' + $("#reply_ajax").val(), {
                _token: $("input[name=_token]").val(),
                reply_content: this.reply_content,
            })
                .then(function() {console.log('request success!'); $("reply_ajax").attr('dismiss', true)}, function(){});
        },
    }
});
