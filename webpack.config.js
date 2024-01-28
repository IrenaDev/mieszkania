const glob = require('glob');
const path = require('path');
const entryPlus = require('webpack-entry-plus');
const entryFiles = [
	{
		entryFiles: glob.sync('./web/app/themes/**/parts/**/*index.js'),
		outputName (item) {
			return item.replace('./web', '').replace('index.js', 'index'); 
		},
	},
	{
		entryFiles: glob.sync('./web/app/themes/**/js/script.js'),
		outputName (item) {
			return item.replace('./web', '').replace('script.js', 'bundle');
		},
	},
];
const settings = {
	entry: entryPlus(entryFiles),
	output: {
		path: path.resolve(__dirname, 'web'),
		filename: '[name].min.js',
	},
	resolve: {
		extensions: ['.js'],
		alias: { Base: path.resolve(glob.sync('web/app/themes/**/js')[0]) },
		modules: [path.resolve(glob.sync('web/app/themes/**/js')[0]), path.resolve(__dirname, 'node_modules')],
	},
	module: {
		rules: [
			{
				test: /\.js$/,
				exclude: /node_modules/,
				use: {
					loader: 'babel-loader',
					options: {
						plugins: [
							[
								'@babel/plugin-proposal-class-properties',
								{ loose: true },
							],
							[
								'@babel/plugin-proposal-object-rest-spread',
								{ loose: true },
							],
						],
					},
				},
			},
		],
	},
	mode: 'development',
};
module.exports = settings;
