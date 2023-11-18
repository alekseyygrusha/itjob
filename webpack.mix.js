const mix = require('laravel-mix');
const webpack = require('webpack');
let path = require('path');
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

module.exports = {
    //...
    resolve: {
        alias: {
            Utilities: path.resolve(__dirname, 'src/utilities/'),
            Templates: path.resolve(__dirname, 'src/templates/'),
        },
    },
};

module.exports = {
    devServer: {
        compress: true,
        disableHostCheck: true,
    },
}
// mix.js('resources/js/app.js', 'public/js')
//     .postCss('resources/css/app.css', 'public/css', [
//         //
//     ]);

mix.js('resources/js/app.js', 'public/js').vue()
    .postCss('resources/css/app.css', 'public/css', [
        //
    ])
    .alias({
        '@': path.join(__dirname, 'resources/js')
    });
/*mix.js('resources/assets/js/app.js', 'public/js').vue({
    options: {
        compilerOptions: {
        isCustomElement: (tag) => ['md-linedivider'].includes(tag),
        },
    },
})*/

mix.sass('resources/css/app.scss', 'public/css');








