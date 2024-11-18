const path = require("path");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const TerserPlugin = require("terser-webpack-plugin");
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");

const isProduction = process.env.NODE_ENV === "production";

module.exports = {
    entry: "./src/index.js",
    output: {
        filename: isProduction ? "main.bundle.min.js" : "main.bundle.js",
        path: path.resolve(__dirname, "assets/dist"),
        clean: true,
    },

    mode: isProduction ? "production" : "development",

    module: {
        rules: [
            {
                test: /\.(?:js|mjs|cjs|jsx)$/,
                exclude: /node_modules/,
                use: {
                    loader: "babel-loader",
                },
            },
            {
                test: /\.css$/i,
                use: [
                    isProduction ? MiniCssExtractPlugin.loader : 'style-loader',
                    {
                        loader: "css-loader",
                    },
                    {
                        loader: "postcss-loader"
                    },
                ],
            },
        ],
    },
    resolve: {
        extensions: [".jsx", ".js"],
    },
    plugins: [
        ...(isProduction ? [new MiniCssExtractPlugin({ filename: "styles.min.css" })] : []),
    ],

    optimization: {
        minimize: isProduction,
        minimizer: [
            new TerserPlugin({
                terserOptions: {
                    compress: true,
                },
            }),
            new CssMinimizerPlugin(),
        ],
    },

    devtool: isProduction ? "source-map" : "eval-source-map",
};
