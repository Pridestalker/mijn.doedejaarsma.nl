const mix = require('laravel-mix');

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
const purger = mix.inProduction() ?
	[
		require('@fullhuman/postcss-purgecss')({
			content: [
				'./resources/**/*.blade.php',
				'./resources/js/**/*.vue',
				'./resources/js/**/*.jsx',
				'./resources/styles/**/*.scss',
			]
		})
	]
	: [];

mix
    .js('resources/js/app.js', 'public/js')
    .ts('resources/vue/product/product.app.js', 'public/js')
    .js('resources/vue/admin/admin.app.js', 'public/js')
    .extract()
    .sass('resources/sass/app.scss', 'public/css')
	.sass('resources/styles/main.scss', 'public/css')
    .copyDirectory('resources/images', 'public/img')
	.options({
		processCssUrls: false,
		postCss: [
			require('tailwindcss'),
			...purger
		]
	})


if (!mix.inProduction()) {
    mix.sourceMaps();
}
