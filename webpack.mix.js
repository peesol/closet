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
	'axios',
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
mix.styles([
	'resources/assets/css/general.css',
	'resources/assets/css/misc.css',
	'resources/assets/css/navigation.css',
	'resources/assets/css/second-navigation.css',
	'resources/assets/css/icon-style.css',
	'resources/assets/css/product-show.css',
	'resources/assets/css/shop.css',
	'resources/assets/css/collection.css',
	'resources/assets/css/toastr.css',
	'resources/assets/css/category.css',
	'resources/assets/css/filter.css',
	'resources/assets/css/home.css',
	'resources/assets/css/table.css',
	'resources/assets/css/menu.css',
	], 'public/css/all.css');
