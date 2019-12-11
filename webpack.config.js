var Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('./src/Resources/public/')
    .setPublicPath('./')
    .setManifestKeyPrefix('bundles/template')

    .cleanupOutputBeforeBuild()
    .enableSassLoader(function(sassOptions) {}, {
        resolveUrlLoader: false
    })
    .enablePostCssLoader()
    .enableSourceMaps(false)
    .enableVersioning(false)
    .disableSingleRuntimeChunk()
    .autoProvidejQuery()

    .configureBabel(() => {}, {
        useBuiltIns: 'usage',
        corejs: 3
    })
    .addEntry('app', './assets/js/app.js')
;

module.exports = Encore.getWebpackConfig();
