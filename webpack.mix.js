let mix = require('laravel-mix');
const path = require('path');

mix.js('resources/js/app.js', 'public/js').vue().postCss('resources/css/app.css', 'public/css', [
    require('@tailwindcss/postcss'),
    require('autoprefixer'),
]);

mix.browserSync({
    proxy: "localhost:8000",
});

mix.webpackConfig({
    watchOptions: {
        ignored: ['**/node_modules', '**/public'],

    },
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js'),
        },
    },
});

