const path = require('path');
const fs = require('fs');
const nodeExternals = require('webpack-node-externals');

module.exports = {
    entry: './src/app.ts',
    target: 'node',
    output: {
        path: __dirname + '/build/',
        filename: 'index.js'
    },
    devtool: 'source-map',
    externals: [nodeExternals()],
    resolve: {
        // Add `.ts` and `.tsx` as a resolvable extension.
        extensions: ['.ts', '.tsx', '.js'],

        alias: {
            '@src': path.resolve(__dirname, '/src'),
            '@src/*': path.resolve(__dirname, '/src/*'),
            '@common': path.resolve(__dirname, '/src/common'),
            '@controller': path.resolve(__dirname, '/src/controller'),
        },
    },
    module: {
        rules: [
            // all files with a `.ts` or `.tsx` extension will be handled by `ts-loader`
            { test: /\.tsx?$/, loader: 'ts-loader' },
        ],
    },
};
