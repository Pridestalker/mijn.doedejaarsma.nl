module.exports = {
  'devServer': {
    'proxy': 'https://mijn-doedejaarsma.lndo.site'
  },
  'publicPath': '/customers/app/',
  'outputDir': '../public/customers/app',
  'indexPath': '../../../resources/views/frontend/app.blade.php',
  'lintOnSave': process.env.NODE_ENV !== 'production',
  'parallel': require('os').cpus().length > 1 ? 4 : false,
  'transpileDependencies': [
    'vuetify'
  ],
}
