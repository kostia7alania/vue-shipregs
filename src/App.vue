<template>
  <div id="app">
    <SearchHeader />
    <SearchPanel />
    <SearchResult :getUsersResult="getUsersResult" />
   </div>
</template>

<script> 

import { mixins } from "./mixins.js";
import { mapActions } from "vuex";

export default {
  mixins: [mixins],
  name: "app",
  props: ["props"],
  components: {
    'SearchPanel': () => import('./views/SearchPanel.vue'),
    'SearchResult': () => import('./views/SearchResult.vue'),
    'SearchHeader': () => import('./views/SearchHeader.vue'), 
  },
  data() {
    return {
      getUsersResult: null
    };
  },
  mounted() {
    this.initProps()
    this.$store.dispatch("searchPanel/GET_PORTS");
    this.$store.dispatch("searchPanel/GET_DICTIONARY_PORT_PLACE");
    this.$store.dispatch("searchPanel/GET_DICTIONARY_TYPE_PORT_PLACE");
  },
  methods: {
    initProps() {
      const p = this.props
      Object.keys(p).forEach(key => this.$store.commit('INIT_PARAM', {key, val: p[key]}))
    }  
  } 
};
</script>

<style lang="scss">
@import "./global_styles.scss";
</style>
