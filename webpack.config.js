var Encore = require('@symfony/webpack-encore');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .addEntry('app', './assets/js/app.js')
    .splitEntryChunks()
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .configureBabel(() => {}, {
        useBuiltIns: 'usage',
        corejs: 3
    })
    .enablePostCssLoader()
    .enableSassLoader(function (options) {}, {
      resolveUrlLoader: false
    })
;

if (Encore.isProduction()) {
  Encore.setPublicPath('https://cloud-project-eu-west-2-dev-assets.s3.eu-west-2.amazonaws.com');
  Encore.setManifestKeyPrefix('build/');
}

module.exports = Encore.getWebpackConfig();
