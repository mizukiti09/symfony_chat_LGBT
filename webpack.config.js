// webpack.config.js
var Encore = require('@symfony/webpack-encore');

Encore
    // バンドルされたアセットが出力されるディレクトリ
    .setOutputPath('public/build/')

    // `outputPath`の公開版パス (プロジェクトのドキュメントルートからの相対パスを指定)
    .setPublicPath('/build')

    // ビルドする前に`outputPath`に指定したディレクトリを空にする
    .cleanupOutputBeforeBuild()

    // エントリファイルの指定、バンドルされたファイルは`web/build/app.js`として出力される
    .addEntry('app', './assets/js/app.js')
    .addStyleEntry('main', './assets/css/main.scss')

    // sass-loaderを有効化
    .enableSassLoader()

    // jQueryをProvidePluginでグローバルに利用できるようにするかどうか
    .autoProvidejQuery()

    .enableSingleRuntimeChunk()

    .enableSourceMaps(!Encore.isProduction())
;

// export the final configuration
module.exports = Encore.getWebpackConfig();