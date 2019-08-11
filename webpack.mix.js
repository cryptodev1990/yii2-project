/*
 * Created by Artyom Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

let mix = require('laravel-mix');
let plugins = require('./resources/assets/mix/plugins');

mix.disableNotifications();
mix.extend('svg', new plugins.SvgLoader());
mix.extend('clean', new plugins.Cleaner());

mix
    .setPublicPath('public/assets')
    .clean()
    .svg()
    .copyDirectory('resources/assets/static', 'public/assets/static')

    // JavaScript files
    .js('resources/assets/js/index.js', 'js/app.js')

    // Styles
    .sass('resources/assets/scss/style.scss', 'css/app.css');
