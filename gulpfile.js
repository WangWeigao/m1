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
    mix.styles([
        'font-awesome.min.css',
        'google-font-lato.css',
        'bootstrap.min.css',
        'bootstrap-datetimepicker.css'
    ]);

    /**
     * 合并css文件
     */
    mix.scripts([
        'jquery.min.js',
        'bootstrap.min.js',
        'app.js',
        'moment.min.js',
        'bootstrap-datetimepicker.min.js',
        'user.js',
        'getusers.js',
        'order.js',
        'getorders.js'
    ]);

    /**
     * 添加时间戳
     */
    mix.version([
        'css/all.css',
        'js/all.js',
    ]);

});
