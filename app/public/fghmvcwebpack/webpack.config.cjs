const path = require("path");
const BrowserSyncPlugin = require("browser-sync-webpack-plugin");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
module.exports = {
   mode: "development",
   entry: {
      main: "./src/source.js",
   },
   output: {
      path: path.resolve(
         __dirname,
         "../wp-content/themes/fghegc/assets/",
      ),
      filename: "[name].js",
   },
   module: {
      rules: [
         {
            test: /\.(s[ac]|c)ss$/i,
            use: [
               MiniCssExtractPlugin.loader,
               "css-loader",
               "postcss-loader",
               "sass-loader",
            ],
         },
      ],
   },
   plugins: [
      new BrowserSyncPlugin(
         {
            host: "localhost",
            port: 3000,
            proxy: "http://fgh000.local/",
            files: ["../wp-content/themes/**/*.php"],
            reload: false,
         },
      ),
      new MiniCssExtractPlugin(),
   ],
};
