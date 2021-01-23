const mix = require('laravel-mix');

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

  ]
});
