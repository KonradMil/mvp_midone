const mix = require('laravel-mix');
let tailwind = require('tailwindcss');
let postcssImport = require('postcss-import');
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
// mix.options({
//     hmrOptions: {
//         host: 'staging.appworks-dev.pl',
//         port: '8080'
//     }
// });
mix.webpackConfig(webpack => {
    return {
        module: {
            rules: [
                {
                    // disabled hash for using preload fonts
                    test: /(\.(woff2?|ttf|eot|otf)$|font.*\.svg$)/,
                    use: [
                        {
                            loader: "file-loader",
                        }
                    ]
                },
            ]
        },
        plugins: [
            new webpack.ProvidePlugin({
                cash: "cash-dom",
                Popper: "@popperjs/core"
            })
        ]
    };
});

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css').options({
    processCssUrls: false,
    postCss: [
        tailwind("tailwind.config.js"),
        [postcssImport]
        ]
});
// mix.browserSync('homestead.test');
mix.version();
    //
    // [ tailwind("tailwind.config.js"),
    //     postcssImport()
    // ]);
