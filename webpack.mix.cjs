const mix = require('laravel-mix');
const purgecss = require('@fullhuman/postcss-purgecss');
mix.js('resources/js/app.js', 'public/js')
.sass('resources/sass/app.scss', 'public/css')
.options({
    postCss: [
       purgecss({
          content: [
             './resources/views/**/*.blade.php',
             './resources/js/**/*.vue',
             './resources/js/**/*.js',
          ],
          defaultExtractor: content => content.match(/[\w-/:]+(?<!:)/g) || []
       })
    ]
});
