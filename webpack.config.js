module.exports = {
    entry: './src/app.ts',

    output: {
        path: __dirname + '/build',
        filename: 'bundle.js'
    },

    resolve: {
        extensions: ['.ts', '.tsx', '.js', '.json'],
        alias: {
            '@src': path.resolve(__dirname, 'src')
        }
    },

    module: {
        loaders: [
            {
                test: /\.js$/,
                loader: 'babel',
                exclude: /node_modules/,
                query: {
                    cacheDirectory: true,
                    presets: ['es2015', 'react']
                }
            }
        ]
    }
};
