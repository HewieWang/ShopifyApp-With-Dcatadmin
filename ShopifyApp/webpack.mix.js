const mix = require('laravel-mix');

mix.js('resources/js/app.jsx', 'public/js')
   .react() // 添加这一行来支持 React
   .sass('resources/sass/app.scss', 'public/css')
   .sourceMaps();
