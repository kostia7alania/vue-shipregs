<template>
     <div>
      <!-- даты -->
      <div @click="show_handler" class="tr tr-th2 date-header">
        <div style="text-align:left"><b>{{menu_index}} <b-badge variant="primary">{{show?'↑':'↓'}} {{items.length}}</b-badge> </b>  </div>
      </div>

        <transition-group name="bounce" tag="div">
  
            <res-head-date-row v-if="show"
              v-for="(row,row_i) in items"
              :row="row" :key="row.EntID"
              :row_i="row_i"
              :isDraft="isDraft"
            />  
            
        </transition-group>

    </div>
</template>

<script> 
export default {
  components: {
    "res-head-date-row": ()=>import("./SearchResult_head_date_row")
  },
  name: "search-result-head-date",
  props: ["items", "menu_index", "isDraft"],
  data() {
    return {
    };
  },  
  methods: {
    show_handler() {
      this.show = !this.show;
      this.$emit("header_click");
    }
  }
};
</script>


<style lang="scss">
</style>
