/*
 * Created by Artyom Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

let mix = require('laravel-mix');
const cleanPlugin = require('clean-webpack-plugin');

// SVG inline encoding
class SvgLoader {
    webpackRules() {
        return {
            test: /\.svg/,
            loaders: [
                {loader: 'svg-url-loader'}
            ]
        }
    }
}

// Build directory cleaner
class Cleaner {
    webpackPlugins() {
        return new cleanPlugin();
    }
}

mix.disableNotifications();
mix.extend('svg', new SvgLoader());
mix.extend('clean', new Cleaner());

mix
    .setPublicPath('public/assets')

    // Clean assets build directory
    .clean()

    // SVG URL loader (image/data)
    .svg()

    .copyDirectory('resources/assets/static', 'public/assets/static')

    // JavaScript files
    .js('resources/assets/js/index.js', 'js/app.js')

    // Styles
    .sass('resources/assets/scss/style.scss', 'css/app.css');
