let mix = require('laravel-mix');

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
});

