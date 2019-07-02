<template>
     <div>
      <!-- даты -->
      <div @click="show_handler" class="tr tr-th2 date-header">
        <div style="text-align:left"><b>{{key_arr}} <b-badge variant="primary">{{show?'↑':'↓'}} {{date_arr.length}}</b-badge> </b>  </div>
      </div>

        <transition-group name="bounce" tag="div">
        <template>
            <res-head-date-row v-if="show"
              v-for="(row,row_i) in date_arr"
              :row="row" :key="row.EntID"
              :row_i="row_i"
              :inport="inport"
              @actions_handlers="actions_handlers"
            />
        </template>
        </transition-group>

    </div>
</template>

<script>
import resHeadDateRow from "./SearchResult_head_date_row";

export default {
  components: { "res-head-date-row": resHeadDateRow },
  name: "search-result-head-date",
  props: ["date_arr", "key_arr", "inport"],
  data() {
    return {
      show: true //отображать по-умолчанию
    };
  },
  computed: {
    items_count() {
      let arr = this.itm_arr && this.itm_arr ? this.itm_arr.arr : [];
      let count = 0;
      Object.keys(arr).map(e => (count += arr[e].length));
      return count;
    }
  },
  watch: {},
  updated() {},
  beforeDestroy() {},
  methods: {
    actions_handlers(e) {
      this.$emit("actions_handlers", e);
      this.$nextTick(e => this.$forceUpdate());
    },
    show_handler() {
      this.show = !this.show;
      this.$emit("header_click");
    }
  }
};
</script>


<style lang="scss">
</style>
