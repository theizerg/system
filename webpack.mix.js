let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
    /* js */
    mix.js('resources/assets/js/app.js', 'public/js');

    /* css */
    mix.sass('resources/assets/sass/app.scss', 'public/css/app.css')
    .sass('resources/assets/sass/system.scss', 'public/css/system.css');
