const path = require("path");
const webpack = require("webpack");

module.exports = {
	entry: "./src/js/messages.js",
	output: {
		path: path.resolve(__dirname, "./js"),
		publicPath: "/js/",
		filename: "messages.js"
	},
	module: {
		loaders: [
			{
				test: /\.vue$/,
				loader: "vue-loader"
			},
			{
				test: /.js?$/,
				loader: 'babel-loader',
				exclude: /node_modules/,
				query: {
					presets: ['es2015']
				}
			}
		]
	},
	vue: {
		esModule: true
	},
	resolve: {
		//alias: {
		//	"vue$": "vue/dist/vue.common.js"
		//},
		extensions: ["", ".js"]
	},
	target: "web",
	devtool: "#eval"
}

//if (process.env.NODE_ENV === "production") {
//	module.exports.devtool = "#source-map";
//	// http://vue-loader.vuejs.org/en/workflow/production.html
//	// module.exports.plugins = (module.exports.plugins || []).concat([
//	// 	new webpack.DefinePlugin({
//	// 		"process.env": {
//	// 			NODE_ENV: ""production""
//	// 		}
//	// 	}),
//	// 	new webpack.optimize.UglifyJsPlugin({
//	// 		sourceMap: true,
//	// 		compress: {
//	// 			warnings: false
//	// 		}
//	// 	})
//	// ]);
//}
