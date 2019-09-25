<template>
  <div>
    <!--заголовки разделов-->

      <div @click="show_handler"
            class="tr tr-th" :class="{'tr-th-second': !isDraft,'tr-th-second-inport': isDraft}">
          <div>
            <b>{{el.name}}</b> &nbsp; <b-badge variant="primary">{{show?'↑':'↓'}} {{items_count}}</b-badge>
          </div>
      </div>
  
    <search-result-head-get-items v-if="show"/>

  </div>
</template>

<script> 

export default {
  components: {
    "search-result-head-get-items": () => import("./SearchResult_head-get-items")
  },
  name: "search-result-head",
  props: ["el", "isDraft"],
  data() {
    return { show: false };
  },
  computed: {
    items_count() {
      return '-0'
      let arr = this.el && this.el ? this.el.arr : [];
      let count = 0;
      Object.keys(arr).map(e => (count += arr[e].length));
      return count;
    }
  },
  watch: {},
  updated() {},
  beforeDestroy() {},
  methods: {
    show_handler() {
      this.show = !this.show;
      this.$emit("header_click");
      this.$store.dispatch('items/GET_MENU_ITEMS', { isDraft: this.isDraft, el: this.el})
    }
  }
};
</script>


<style lang="scss">
</style>
