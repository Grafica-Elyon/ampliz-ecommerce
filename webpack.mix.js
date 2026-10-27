const mix = require('laravel-mix');
let path = require('path');
var fs = require('fs');
var webpack = require('webpack');
var SpritesmithPlugin = require('webpack-spritesmith');

// O app.css já é invalidado pela versão do plugin no wp_enqueue_style, mas as imagens
// referenciadas por url() dentro dele não — daí exportar a versão pro Sass carimbar as URLs
function versaoDoPlugin() {
	var conteudo = fs.readFileSync(path.resolve(__dirname, 'config/plugin.php'), 'utf8');
	var achado = conteudo.match(/'version'\s*=>\s*'([^']+)'/);

	return achado ? achado[1] : '0';
}

fs.writeFileSync(
	path.resolve(__dirname, 'front/assets/styles/global/_asset-version.scss'),
	'// GERADO PELO BUILD a partir de config/plugin.php — não editar à mão.\n' +
	'$asset-version: "' + versaoDoPlugin() + '";\n'
);

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
