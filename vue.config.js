
const isDev = process.env.NODE_ENV == "development"
module.exports = {
  transpileDependencies: ['object-hash'],
  lintOnSave: isDev,
  devServer: {
    historyApiFallback: true, // noInfo: true,
    overlay: true,//вывод ошибок на экран
    open: false,
    hot: true,
    proxy: {
      '/api*': {//все запросы))
        target: 'https://portcall.marinet.ru/develop1/graf/db_grafics.php',// Это скажет серверу разработки проксировать любые неизвестные запросы (запросы, которые не соответствуют статическому файлу) на адрес http://localhost:4000.
        secure: false,
        changeOrigin: true,
        onProxyRes(proxyRes, req, res) {
          if (proxyRes.headers.location) { // Если есть заголовок со свойством location (Где храниться полный адрес запроса к локальному серверу)
            let location = proxyRes.headers.location; // Сохраняем адрес зоголовка location из ответа в переменную location
            console.log(`LOCATION: ${proxyRes.headers.location}`); // Выводит в консоль адрес до замены
            location = location.replace('anyships.site', 'anyships.site:3000'); // Заменяем адрес локального сервера на адрес webpack dev server'a
            proxyRes.headers.location = location; // Присваиваем в заголовок location подмененный адрес из переменной location
            console.log(`REPLACED: ${proxyRes.headers.location}`); // Выводит в консоль адрес после замены
          }
        },
        pathRewrite: { '^/api': '' }
      }
    }
  },
  //  publicPath: isDev ? './' : '././js/video-manager/dist',
  //baseUrl: isDev ? './' : '././graf/frontend/dist',
  baseUrl: isDev ? './' : '././',
  assetsDir: './',   // "./", //По умолчанию: '' - Каталог (относительно outputDir) для хранения сгенерированных статических ресурсов (js, css, img, fonts).
  outputDir: 'dist',   // "dist",
  indexPath: 'index.html',  // "index.html", //умолч -'index.html'-относительно outputDir
  filenameHashing: false,
}