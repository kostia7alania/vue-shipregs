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

window.Swal = require('sweetalert2')

import animateNumber from "./components/animate-number.vue"; Vue.component("animateNumber", animateNumber);

window.axios = require('axios');

Vue.config.devtools = true

import store from "./store";

window.init_grafics = props => {
  window.Vue = new Vue({
    store,
    render: h => h(App, { props: { props } })
  }).$mount('#app');
} 