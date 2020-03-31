const path = require('path');
const webpack = require('webpack');
const CleanWebpackPlugin = require('clean-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const StyleLintPlugin = require('stylelint-webpack-plugin');
const fs = require('fs');
const autoprefixer = require('autoprefixer');
const { VueLoaderPlugin } = require('vue-loader');
const Dotenv = require('dotenv-webpack');
const CopyWebpackPlugin = require('copy-webpack-plugin');

module.exports = () => {
  const config = {
    entry: {
      admin: './src/admin.js',
    },
    output: {
      path: path.resolve(__dirname, 'dist'),
      publicPath: 'http://localhost:8081/',
      filename: 'js/[name].js',
    },
    module: {
      rules: [
        {
          test: /\.vue$/,
          loader: 'vue-loader',
        },
        {
          test: /\.js$/,
          loader: 'babel-loader',
          options: {
            cacheDirectory: true,
          },
        },
        {
          test: /\.js|\.vue$/,
          use: [
            {
              loader: 'eslint-loader',
              options: {
                configFile: path.resolve(__dirname, '.eslintrc.json'),
              },
            },
          ],
          enforce: 'pre',
          exclude: /node_modules/,
        },
      ],
    },
    plugins: [
      new Dotenv({
        path: path.resolve(process.cwd(), '.env.development')
      }),
      new CleanWebpackPlugin(['dist'], {
        root: path.resolve(__dirname, './'),
        verbose: true,
      }),
      new webpack.LoaderOptionsPlugin({
        options: {
          postcss: [autoprefixer()],
          context: '/',
        },
      }),
      new StyleLintPlugin({
        configFile: path.resolve(__dirname, '.stylelintrc.json'),
        syntax: 'scss',
        files: ['**/*.s?(a|c)ss', '**/*.vue'],
        emitErrors: false,
        lintDirtyModulesOnly: process.env.NODE_ENV !== 'production',
      }),
      new VueLoaderPlugin(),

      new CopyWebpackPlugin([
        {from: 'src/img', to: 'images'},
        {from: 'src/css/toplevel-menu.css', to: 'css'}
      ])
    ],
    devtool: 'eval-source-map',
    externals: {
      jquery: 'jQuery',
    },
  };

  if (process.env.NODE_ENV === 'production') {
    config.output = {
      path: path.resolve(__dirname, 'dist'),
      publicPath: '',
      filename: 'js/[name].js',
    };

    config.module.rules.push({
      test: /\.(s)?css$/,
      use: [
        MiniCssExtractPlugin.loader,
        {
          loader: 'css-loader',
          options: {
            sourceMap: true,
          },
        },
        {
          loader: 'postcss-loader',
          options: {
            sourceMap: true,
          },
        },
        {
          loader: 'sass-loader',
          options: {
            sourceMap: true,
          },
        },
      ],
    });
    config.module.rules.push({
      test: /\.png|\.jpg|\.gif|\.svg|\.eot|\.ttf|\.woff|\.woff2$/,
      loader: 'file-loader',
      query: {
        name: '[hash].[ext]',
        outputPath: 'static/',
        publicPath: '../static/',
      },
      exclude: /node_modules/,
    });

    config.devtool = '#source-map';

    config.plugins = (config.plugins || []).concat([
      new MiniCssExtractPlugin({
        filename: 'css/[name].css',
      }),
      new webpack.DefinePlugin({
        'process.env': {
          NODE_ENV: '"production"',
        },
      }),
      new webpack.LoaderOptionsPlugin({
        minimize: true,
      }),
    ]);
  } else {
    config.module.rules.push({
      test: /\.(s)?css$/,
      use: [
        {
          loader: 'vue-style-loader',
          options: {
            sourceMap: true,
          },
        },
        {
          loader: 'css-loader',
          options: {
            sourceMap: true,
          },
        },
        {
          loader: 'postcss-loader',
          options: {
            sourceMap: true,
          },
        },
        {
          loader: 'sass-loader',
          options: {
            sourceMap: true,
          },
        },
      ],
    });
    config.module.rules.push({
      test: /\.png|\.jpg|\.gif|\.svg|\.eot|\.ttf|\.woff|\.woff2$/,
      loader: 'file-loader',
      query: {
        name: '[hash].[ext]',
      },
      exclude: /node_modules/,
    });

    config.devServer = {
      hot: true,
      host: '0.0.0.0',
      disableHostCheck: true,
      port: 8081,
      headers: {
        'Access-Control-Allow-Origin': '*',
      },
    };

    config.plugins = (config.plugins || []).concat([
      new webpack.DefinePlugin({
        'process.env': {
          NODE_ENV: '"development"',
          VUE_APP_API_URL: process.env.API_URL
        },
      }),
      new webpack.HotModuleReplacementPlugin(),
    ]);
  }

  return config;
};
