const mix = require('laravel-mix');

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

mix.js(['resources/js/app.js', 
         'resources/js/bootstrap.js', 
         'resources/js/jquery-3.6.0.min.js',
         'resources/js/jquery.japan-map.js'],
         'public/js/all.js')
   .sass('resources/sass/app.scss', 'public/css')
   .styles(['resources/css/app.css',
         'resources/css/japanmap.css',
         'resources/css/bbs/sticky-footer.css'], 
         'public/css/all.css')
   .version();
