var Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('./src/Resources/public/')
    .setPublicPath('/bundles/template/')
    .setManifestKeyPrefix('bundles/template')

    .cleanupOutputBeforeBuild()
    .enableSassLoader(function(sassOptions) {}, {
        resolveUrlLoader: false
    })
    .enablePostCssLoader()
    .enableSourceMaps(false)
    .enableVersioning(true)
    .disableSingleRuntimeChunk()
    .autoProvidejQuery()

    .configureBabel(() => {}, {
        useBuiltIns: 'usage',
        corejs: 3
    })
    .addEntry('app', './assets/js/app.js')
    .addStyleEntry('webfont', './assets/css/webfont.scss')
    .copyFiles({
        from: './assets/images',
        to: 'images/[path][name].[ext]'
    })
;

module.exports = Encore.getWebpackConfig();
