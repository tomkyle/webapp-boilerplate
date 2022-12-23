var webpack = require("webpack"),
    path = require('path'),
    TerserPlugin   = require("terser-webpack-plugin");

const isProduction = (process.env.NODE_ENV === 'production');
console.log("process.env.NODE_ENV: ", process.env.NODE_ENV);
console.log("isProduction: ", isProduction);


const config = {

    // https://webpack.js.org/concepts/#mode
    mode: isProduction ? "production" : "development",


    // https://webpack.js.org/configuration/devtool/
    devtool: !isProduction ? "eval-source-map" : false,

    devServer: {
        contentBase: path.resolve(__dirname, 'public'),
    },

    entry: {
        "index" : path.resolve(__dirname, 'scripts/index'),
        // "serviceworker" : path.resolve(__dirname, 'scripts/serviceworker'),
    },

    output: {
        path: path.resolve(__dirname, 'public/assets'),
        publicPath: '/assets/',
        filename: "[name].mjs",
        clean: true
    },



    optimization: {
        chunkIds: 'named',
        minimize: true,
        minimizer: [new TerserPlugin({
            terserOptions: {
                compress: {
                    drop_console: true
                }
            }
        })],
    },

    module: {
        rules: [
            {
                test: /\.(m?js|jsx)$/,
                exclude: /node_modules/,
                use: 'babel-loader'
            },
            {
                test: /\.css$/i,
                use: ['style-loader', 'css-loader']
            },{
                test: /\.scss$/,
                use: [ 'style-loader', 'css-loader', 'sass-loader'],
            },
            {
                test: /\.(png|jpe?g|gif|svg|eot|ttf|woff|woff2)$/i,
                // More information here https://webpack.js.org/guides/asset-modules/
                type: 'asset/resource'
            }
        ],
    },


    resolve: {
        extensions: ['.js', '.jsx', '.mjs'],
        modules: [
          path.resolve(__dirname, 'scripts'),
          path.resolve(__dirname, 'styles'),
          path.resolve(__dirname, 'node_modules')
        ]
    }
};

module.exports = config;
