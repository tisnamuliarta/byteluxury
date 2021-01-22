const mix = require('laravel-mix');
const VueAutoRoutingPlugin = require('vue-auto-routing/lib/webpack-plugin')

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

mix.js('resources/js/app.js', 'public/js')
  .sass('resources/sass/app.scss', 'public/css')
  .version();

mix.setResourceRoot(process.env.MIX_BASE_PATH);

mix.webpackConfig({
  output: {
    publicPath: process.env.MIX_BASE_PATH,
  },
  resolve: {
    alias: {
      '@': path.join(__dirname,'/resources/assets/js/'),
      '~': path.join(__dirname, '/resources/assets/sass/'),
    }
  },
  plugins: [
    new VueAutoRoutingPlugin({
      // Path to the directory that contains your page components.
      pages: 'src/pages',
      // A string that will be added to importing component path (default @/pages/).
      importPrefix: '@/pages/'
    })
  ]
});
