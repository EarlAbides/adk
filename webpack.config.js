const path = require("path");
const webpack = require("webpack");

module.exports = {
	entry: "./build/messages.ts",
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
			}
		]
	},
	vue: {
		// vue-loader options go here
		esModule: true
	},
	resolve: {
		//alias: {
		//	"vue$": "vue/dist/vue.common.js"
		//},
		extensions: ["", ".js", ".vue"]
	},
	devServer: {
		historyApiFallback: true,
		noInfo: true
	},
	target: "web",
	devtool: "#eval-source-map"
}

if (process.env.NODE_ENV === "production") {
	module.exports.devtool = "#source-map";
	// http://vue-loader.vuejs.org/en/workflow/production.html
	// module.exports.plugins = (module.exports.plugins || []).concat([
	// 	new webpack.DefinePlugin({
	// 		"process.env": {
	// 			NODE_ENV: ""production""
	// 		}
	// 	}),
	// 	new webpack.optimize.UglifyJsPlugin({
	// 		sourceMap: true,
	// 		compress: {
	// 			warnings: false
	// 		}
	// 	})
	// ]);
}
