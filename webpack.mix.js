/*
 * Created by Artyom Manchenkov
 * artyom@manchenkoff.me
 * manchenkoff.me © 2019
 */

const mix = require('./resources/assets/mix/main');

/**
 * Mix common API
 *
 * 1. JavaScript
 *
 * mix.js(src, output);
 * mix.js([src1, src2, ...], output);
 * mix.extract(['vue', 'jquery']);
 *
 * 2. Styles & Preprocessors
 *
 * mix.sass(src, output);
 * mix.less(src, output);
 * mix.stylus(src, output);
 * mix.postCss(src, output);
 *
 * 3. Files and folders
 *
 * mix.combine(files, destination);
 * mix.copy(from, to);
 * mix.copyDirectory(fromDir, toDir);
 * mix.minify(file);
 *
 * 4. Webpack API
 *
 * mix.autoload({}); <-- Will be passed to Webpack's ProvidePlugin.
 * mix.webpackConfig({}); <-- Override webpack.config.js, without editing the file directly.
 * mix.then(function () {}) <-- Will be triggered each time Webpack finishes building.
 * mix.extend(name, handler) <-- Extend Mix's API with your own components.
 *
 * 5. Others
 *
 * mix.sourceMaps();
 * mix.version();
 * mix.disableNotifications();
 * mix.setPublicPath('path/to/public');
 *
 */

mix
    .copy('resources/assets/static', 'public/assets/static')
    .js('resources/assets/js/app.js', 'js/app.js')
    .sass('resources/assets/scss/style.scss', 'css/app.css');
