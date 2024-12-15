const path = require("path");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const TerserPlugin = require("terser-webpack-plugin");
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");
const fs = require('fs');
const archiver = require('archiver');

const isProduction = process.env.NODE_ENV === "production";


module.exports = () => {

    const config = {
        devServer: {
            static: path.resolve(__dirname, "assets"),
            open: true,
            port: 3000,
            hot: true,
            watchFiles: ['includes', 'templates', 'template-parts'],
            proxy: [
                {
                    context: () => true,
                    target: 'http://koumparos.local',
                    changeOrigin: true,
                },
            ],

        },
        entry: {
            main: "./src/index.js",
            dashboard: "./src/dashboard.js",
        },
        output: {
            filename: isProduction ? "[name].bundle.min.js" : "[name].bundle.js",
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
                    test: /\.scss$/i,
                    use: [
                        MiniCssExtractPlugin.loader,
                        'css-loader',   // Process CSS files
                        'postcss-loader', // Apply PostCSS transformations
                        'sass-loader',  // Compile Sass to CSS
                    ],
                },
                {
                    test: /\.css$/i, // Match regular CSS files
                    use: [
                        MiniCssExtractPlugin.loader,
                        'css-loader',
                        'postcss-loader',
                    ],
                },
            ],
        },
        resolve: {
            extensions: [".jsx", ".js"],
        },
        plugins: [
            new MiniCssExtractPlugin({ filename: "style.min.css" })
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
    }

    if (isProduction) {
        config.plugins.push({
            apply: (compiler) => {
                compiler.hooks.afterEmit.tapAsync('ZipPlugin', (compilation, callback) => {
                    console.log('Creating ZIP file...');

                    const outputDir = path.resolve(__dirname, 'assets/dist');
                    const outputZip = path.resolve(outputDir, 'wedding-venue-listings.zip');
                    const themeDir = path.resolve(__dirname);

                    // Create ZIP file
                    const output = fs.createWriteStream(outputZip);
                    const archive = archiver('zip', { zlib: { level: 9 } });

                    output.on('close', () => {
                        console.log(`ZIP file created: ${outputZip} (${archive.pointer()} total bytes)`);
                        callback();
                    });

                    archive.on('error', (err) => {
                        throw err;
                    });

                    archive.pipe(output);
                    archive.glob('**/*', {
                        cwd: themeDir,
                        ignore: ['node_modules/**', '.git/**', 'assets/dist/wedding-venue-listings.zip'],
                    });
                    archive.finalize();
                });
            },
        });
    }

    return config

}
