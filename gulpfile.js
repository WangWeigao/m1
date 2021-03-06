var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    // mix.sass('app.scss');

    /**
     * 合并css文件
     */
    // mix.styles([
    //     // 'font-awesome.min.css',         // font-awesome
    //     // 'google-font-lato.css',         // 谷歌字体
    //     // 'bootstrap.min.css',            // bootstrap主文件
    //     'bootstrap-datetimepicker.css', // 日历时间选择器
    //     'jquery.dataTables.min.css',    //表格排序
    //     // 'dataTables.jqueryui.min.css',  // 表格排序
    //     // 'dataTables.bootstrap.min.css', // 表格排序
    //     // 'jquery.dataTables_themeroller.css',    //表格排序
    // ])
    mix.styles(['bootstrap-datepicker.css', 'music.css'], 'public/css/music.css')
        .styles(['bootstrap-datepicker.css', 'user.css'], 'public/css/user.css')
        .styles('userrecordhistory.css', 'public/css/userrecordhistory.css')
        .styles('orderStatistics.css', 'public/css/orderStatistics.css')
        .styles(['bootstrap-datetimepicker.css', 'bootstrap.min.css', 'order.css'], 'public/css/order.css')
        .styles(['bootstrap-datetimepicker.css', 'bootstrap.min.css'], 'public/css/playRecords.css');

    /**
     * 合并js文件
     */
    // mix.scripts([
    //     // 'jquery.min.js',    // jquery核心文件
    //     // 'bootstrap.min.js', // bootstrap核心文件
    //     'jquery.dataTables.min.js',         // 表格排序
    //     'dataTables.jqueryui.min.js',       // 表格排序
    //     'dataTables.bootstrap.min.js',      // 表格排序
    //     'app.js',           // app模板的js文件
    //     'moment.min.js',    // 日历时间选择器需要
    //     'bootstrap-datetimepicker.min.js',  // 日历时间选择器
    //     'user.js',          // user页面的js
    //     'getusers.js',      // getusers页面的js
    //     'getTeachers.js',      // getTeachers页面的js
    //     'order.js',         // order页面的js
    //     'getorders.js',     // getorders页面的js
    //     'jquery.form.js',   // jquery表单提交插件
    //     'music.js',         // music页面的js
    //     'rbac_user.js',     // rbac中的user页面的js
    // ])

    mix.styles([
        '../bower/bootstrap/dist/css/bootstrap.css',
        '../bower/bootstrap-datepicker/dist/css/bootstrap-datepicker.css'
    ], 'public/css/app.css');
    mix.scripts([
        '../bower/jquery/dist/jquery.js',
        '../bower/bootstrap/dist/js/bootstrap.js',
        '../bower/bootstrap-datepicker/dist/js/bootstrap-datepicker.js',
        '../bower/bootstrap-datepicker/dist/locales/bootstrap-datepicker.zh-CN.min.js',
        'app.js'
    ], 'public/js/app.js');


    mix.scripts(['jquery.form.js', 'getUrlParam.js', 'vue.min.js', 'music.js'], 'public/js/music.js')
    .scripts(['musicStatistics.js'], 'public/js/musicStatistics.js')
    .scripts(['userUsageStatics.js'], 'public/js/userUsageStatics.js')
    .scripts(['dateSelector.js', 'jquery.form.js', 'getUrlParam.js', 'vue.min.js', 'user.js'], 'public/js/user.js')
    .scripts(['musicadd.js'], 'public/js/musicadd.js')
    .scripts(['userbasicinfo.js'], 'public/js/userbasicinfo.js')
    .scripts(['orderStatistics.js'], 'public/js/orderStatistics.js')
    .scripts(['vue.min.js', 'getUrlParam.js', 'order.js'], 'public/js/order.js')
    .scripts(['vue.min.js', 'getUrlParam.js', 'playRecords.js'], 'public/js/playRecords.js')
    .scripts(['vue.min.js', 'vue-resource.min.js', 'feedback.js'], 'public/js/feedback.js');
    /**
     * 添加时间戳
     */
    mix.version([
        'js/*.js',
        'css/*.css'
    ]);

    // mix.browserSync({
    //     proxy: 'homestead.app'
    // });
});
