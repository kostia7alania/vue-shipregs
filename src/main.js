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

import VueIziToast from 'vue-izitoast';
import 'izitoast/dist/css/iziToast.css';//import 'izitoast/dist/css/iziToast.min.css';
Vue.use(VueIziToast); // Vue.use(VueIziToast, defaultOptionsObject);

import animateNumber from "./components/animate-number.vue"; Vue.component("animateNumber", animateNumber);

window.axios = require('axios');

Vue.config.devtools = true

window.init_grafics = grafics_url => {
  window.Vue = new Vue({
    render: h => h(App, { props: { url: grafics_url } })
  }).$mount('#app');
}
//init_grafics ('url-api');