<template>
  <div>
    <!--заголовки разделов-->

      <div @click="show_handler"
            class="tr tr-th" :class="{'tr-th-second': !isDraft,'tr-th-second-inport': isDraft}">
          <div>
            <b>{{el.name}}</b> &nbsp; <b-badge variant="primary">{{show?'↑':'↓'}} {{items_count}}</b-badge>
          </div>
      </div>
  
    <div>
          <!-- содержимое разделов-->
          <res-head-date 
            v-for="(item, menu_index) in el.items"
            :key="menu_index" 
            :item="item"
            :menu_index="menu_index"
            :class="{ height0: !show}"
            :isDraft="isDraft"
          />
          <div v-if="el.items.length==0" :class="{ height0: !show}">Нет элементов для отображения!</div>
      </div>
      

  </div>
</template>

<script> 

export default {
  components: {
    "res-head-date":()=>import("./SearchResult_head_date")
  },
  name: "search-result-head",
  props: ["el", "isDraft"],
  data() {
    return { show: false };
  },
  computed: {
    items_count() { 
      return this.el.items.length
      /*
      let arr = this.el && this.el ? this.el.items : [];
      let count = 0;
      Object.keys(arr).map(e => (count += arr[e].length));
      return count;
      */
    }
  },
  watch: {},
  updated() {},
  beforeDestroy() {},
  methods: {
    show_handler() {
      this.show = !this.show;
      this.$emit("header_click");
    //  this.$store.dispatch('items/GET_MENU_ITEMS', { isDraft: this.isDraft, el: this.el})
    }
  }
};
</script>


<style lang="scss">
</style>
