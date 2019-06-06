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

mix
    .js('resources/js/app.js', 'public/js')
    .js('resources/vue/product/product.app.js', 'public/js')
    .js('resources/vue/admin/admin.app.js', 'public/js')
    .ts('resources/vue/dashboard/designer/designer.dashboard.js', 'public/js')
    .extract(['vue', 'vuex', 'jquery', 'popper.js', 'lodash', 'axios']);

mix.sass('resources/sass/app.scss', 'public/css');

// mix.browserSync({
//     proxy: "localhost:8000"
// })
