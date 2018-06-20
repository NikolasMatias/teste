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

mix.autoload({
    'jquery': ['$', 'window.jQuery', 'jQuery'],
    'tether': ['window.Tether', 'Tether'],
    'axios': ['window.axios', 'axios'],
    'vue': ['window.Vue', 'Vue'],
    'vee-validate': ['window.VeeValidate', 'VeeValidate'],
    'node-waves': ['window.Waves', 'Waves']
});

mix.js('resources/assets/js/app.js', 'public/js/app.js');
mix.sass('resources/assets/sass/app.scss', 'public/css/app.css');

mix.js('resources/assets/js/home.js', 'public/js/home.js');
mix.sass('resources/assets/sass/home.scss', 'public/css/home.css');

if (mix.inProduction()) {
    mix.version();
}