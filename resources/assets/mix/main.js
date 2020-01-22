const mix = require('laravel-mix');
const plugins = require('./plugins');

mix.disableNotifications()
    .extend('svg', new plugins.SvgLoader())
    .extend('clean', new plugins.Cleaner());

mix
    .setPublicPath('public/assets')
    .clean()
    .svg();

module.exports = mix;