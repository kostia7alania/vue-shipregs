module.exports = {
  baseUrl: process.env.NODE_ENV === 'production' ? './' : '',
  filenameHashing: false,
  devServer: {
    proxy: 'http://localhost:4000'
  }
}
