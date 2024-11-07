const path = require("path");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const TerserPlugin = require("terser-webpack-plugin");
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");

const isProduction = process.env.NODE_ENV === "production";

module.exports = {
    entry: "./src/index.js",
    output: {
        filename: isProduction ? "main.bundle.min.js" : "main.bundle.js",
        path: path.resolve(__dirname, "dist"),
        clean: true,
    },

    mode: isProduction ? "production" : "development",

    module: {
        rules: [
            {
                test: /\.s[ac]ss$/i,
                use: [
                    isProduction ? MiniCssExtractPlugin.loader : 'style-loader',
                    {
                        loader: "css-loader",
                        options: {
                            sourceMap: !isProduction,
                        },
                    },
                    {
                        loader: "sass-loader",
                        options: {
                            sourceMap: !isProduction,
                            sassOptions: {
                                quietDeps: true,
                            },
                        },
                    },
                ],
            },
        ],
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


/*

const path = require("path");

module.exports = {
    entry: "./src/index.js",
    output: {
        filename: "main.bundle.js",
        path: path.resolve(__dirname, "dist"),
    },

    module: {
        rules: [
            {
                test: /\.s[ac]ss$/i,
                use: [
                    {
                        loader: 'style-loader',
                    },
                    {
                        loader: 'css-loader',
                        options: {
                            sourceMap: true,
                        },
                    },
                    {
                        loader: 'sass-loader',
                        options: {
                            sourceMap: true,
                            sassOptions: {
                                quietDeps: true,
                            },
                        },
                    },
                ],
            },
        ],

    },

};
*/
