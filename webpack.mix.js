const mix = require('laravel-mix');
let path = require('path');
var webpack = require('webpack');
var SpritesmithPlugin = require('webpack-spritesmith');

// BABEL config
mix.webpackConfig({
	module: {
		rules: [
			{
				test: /\.scss/,
				loader: 'import-glob-loader'
			}
		],
	},
	plugins: [
		new SpritesmithPlugin({
			src: {
				cwd: path.resolve('./front/assets/imgs/icons'),
				glob: '*.png'
			},
			target: {
				image: path.resolve('./front/assets/imgs/sprite.png'),
				css: path.resolve('./front/assets/styles/global/_sprite.scss')
			},
			apiOptions: {
				cssImageRef: "../assets/imgs/sprite.png"
			}
		}),
		new webpack.ProvidePlugin({
			$: "jquery",
			jQuery: "jquery",
			"window.jQuery": "jquery"
		})
	]
});

mix
.js('front/assets/scripts/app.js', 'front/dist')
.js('admin/assets/scripts/admin.js', 'admin/dist')
.sass('front/assets/styles/app.scss', 'front/dist')
.sass('admin/assets/styles/admin.scss', 'admin/dist')
.sourceMaps()
.options({
	processCssUrls: false
});
