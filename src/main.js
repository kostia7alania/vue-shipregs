import '@enrian/vue-pikaday/dist/vue-pikaday.min.css' 
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

import Vue from 'vue'
import App from './App.vue'
import VuePikaday from '@enrian/vue-pikaday'
import BootstrapVue from 'bootstrap-vue'

Vue.use(BootstrapVue)
Vue.use(VuePikaday)
Vue.config.productionTip = false


window.$ = window.jQuery = require('jquery'); 
window.bootstrapTable = require('bootstrap-table');
 
window.axios = require('axios');
new Vue({
  render: h => h(App),
}).$mount('#app')
