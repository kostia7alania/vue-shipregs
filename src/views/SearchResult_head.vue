<template>
  <div>
    <!--заголовки разделов @click="$emit('header_click', itm_arr_i)"-->
 
      <div @click="show_handler"
            class="tr tr-th" :class="{'tr-th-second': !inport,'tr-th-second-inport': inport}">
          <div>
            <b>{{itm_arr.header}}</b> &nbsp; <b-badge variant="primary">{{show?'↑':'↓'}} {{items_count}}</b-badge>
             
          </div>
      </div>
      <res-head-date v-show="show && date_arr.length > 0" v-for="(date_arr, i) in itm_arr.arr" :key="i" :key_arr="i" :date_arr="date_arr" :class="{ height0: !show}" :inport="inport" @actions_handlers="$emit('actions_handlers',$event)"/>
       <div v-if="itm_arr.arr.length==0" :class="{ height0: !show}" :inport="inport">Нет элементов для отображения!</div>
  </div>
</template>

<script>

import resHeadDate from './SearchResult_head_date';

export default {
  components:{'res-head-date':resHeadDate},
  name: "search-result-head",
  props: ["itm_arr", "inport", "itm_arr_i"],
  data() {
    return { 
      show: false
    };
  },
  computed: {
    items_count(){
      let arr = this.itm_arr && this.itm_arr ? this.itm_arr.arr: [];
      let count = 0;
      Object.keys(arr).map ( e => count += arr[e].length )
      return count;
    }
  },
  watch: {},
  updated() {},
  beforeDestroy(){},
  methods: {
    show_handler(){
      this.show = !this.show;
      this.$emit('header_click'); 
    }
   }
};
</script>
 

<style lang="scss">

</style>
