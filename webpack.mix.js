const mix = require('laravel-mix');
require('laravel-mix-alias');

mix
    .js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss','css')
    .alias({
        '@': '/resources/js',
        '~': '/resources/sass',
        'vendor': '/vendor',
    });
