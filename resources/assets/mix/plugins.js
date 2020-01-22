const CleanWebpackPlugin = require('clean-webpack-plugin/dist/clean-webpack-plugin');

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
        return new CleanWebpackPlugin();
    }
}

module.exports = {
    SvgLoader,
    Cleaner
};