const Encore = require('@symfony/webpack-encore');

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    .setOutputPath('./src/Resources/public/')
    .setPublicPath('/bundles/template/')
    .setManifestKeyPrefix('bundles/template')

    .cleanupOutputBeforeBuild()
    .enableSassLoader(function(sassOptions) {}, {
        resolveUrlLoader: false
    })
    .enablePostCssLoader()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .disableSingleRuntimeChunk()
    .autoProvidejQuery()

    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = '3.38';
    })
    .addEntry('app', './assets/js/app.js')
    .addStyleEntry('webfont', './assets/css/webfont.scss')
    .copyFiles({
        from: './assets/images',
        to: 'images/[path][name].[hash:8].[ext]'
    })
    .copyFiles({
        from: './node_modules/@typo3/icons/dist',
        pattern: /\.(svg|json)$/,
        to: 'icons/[path][name].[hash:8].[ext]'
    })
;

module.exports = Encore.getWebpackConfig();
