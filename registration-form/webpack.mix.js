const mix = require('laravel-mix');
const path = require('path');
const webpack = require('webpack');

mix.js('resources/js/app.js', 'public/js').vue().postCss('resources/css/app.css', 'public/css', [
    require('@tailwindcss/postcss'),
    require('autoprefixer'),
]);

mix.webpackConfig({
    watchOptions: {
        ignored: ['**/node_modules', '**/public'],

    },
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js/'),
        },
    },
    plugins: [
        new webpack.DefinePlugin({
            __VUE_PROD_HYDRATION_MISMATCH_DETAILS__: false,
        }),
    ],
});


