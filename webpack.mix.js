const { mix } = require('laravel-mix');

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
mix.js([
	'resources/assets/js/app.js',
], 'public/js/main.js').extract([
	'vue',
	'jquery',
	'cleave.js',
	'vuex',
	'dropzone',
	'algoliasearch',
	'vue-resource',
	'vee-validate',
	'vue-clickaway',
	'vue-js-modal',
	'vue-progressbar',
	'vue-router',
	'vuedraggable',
], 'public/js/vendor.js');

// mix.sass('resources/assets/sass/app.sass', 'public/css/main.css');
