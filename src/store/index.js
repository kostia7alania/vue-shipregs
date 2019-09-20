


import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);

import mutations from './mutations.js';
import getters from './getters.js';
import actions from './actions.js';
import state from './state.js';


import searchPanel from './modules/search-panel'
import items from './modules/items'

window.store = new Vuex.Store({
    modules: { searchPanel, items },
    state,
    getters,
    mutations,
    actions
});

export default store;
