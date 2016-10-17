var elixir = require('laravel-elixir');

require('laravel-elixir-vueify');

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


config.css.autoprefix.options.browsers =  ['last 15 versions'];


elixir(function(mix) {
    mix
    	.sass('admin.scss', 'public/styles/admin.css')
    	.sass('client.scss', 'public/styles/client.css')
      .browserify('admin.js', 'public/scripts/admin.js')
      .browserify('client.js', 'public/scripts/client.js');
});