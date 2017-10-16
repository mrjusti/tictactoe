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

mix
    .copy('node_modules/material-design-lite/src/images', 'public/img')
    .js('resources/assets/js/app.js', 'public/js')
    .sass('resources/assets/sass/app.scss', 'public/css')
    .options({
        postCss: [
            require('postcss-discard-comments')({
                removeAll: true
            })
        ]
    })


    .version(
        [
            'public/css/app.css',
            'public/js/app.js'
        ]
    );
