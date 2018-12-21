<template>
  <div>
    <!--заголовки разделов @click="$emit('header_click', itm_arr_i)"-->
    <div
        @click="show_handler"
        class="tr tr-th" :class="{'tr-th-second': !inport,'tr-th-second-inport': inport}"
        :key="itm_arr.header + itm_arr_i + index + 1"
      >
      <div v-if="index==0">
        <b>{{itm_arr.header}}</b> ({{items_count}})
      </div>
    </div>
     <div v-show="show" :class="{ height0: !show}">
      <!-- даты -->
      <div class="tr tr-th2" :key="k + itm_arr + index + 2">
        <div style="text-align:left"> `<b>{{k}}</b>  </div>
      </div>
      <div class="tr tr-td" v-for="(e,i) in itm_arr.arr[k]" :key="e + i + index + k + 2">
        <div class="font-weight-bold">{{++i}}</div>
        <div>{{e.rShipName}} ({{e.Length}})</div>
        <div>{{e.ShipTypeNameRus}}</div>
        <div>{{e.CountryNameRus}}</div>
        <div>{{e.DepositStern}}</div>
        <div>{{e.SurfaceDimension}}</div>
        <div>{{e.HourMinute}}</div>
        <div>{{e.Route}}</div>
        <div>{{e.Terminal}}</div>
        <div>{{e.CompanyName}}</div>
        <div>{{e.NeedForEmerg}}</div>
        <div>
          <p v-if="e.Enter_Cargo">Грузы: <span v-html="e.Enter_Cargo"></span></p>
          <p v-if="e.Enter_Cargo_Danger">Опасные грузы: <span v-html="e.Enter_Cargo_Danger"></span></p>
        </div>
        <div>{{e.Note}}</div>
        <div>
          <b-button v-if="!inport" @click="v_handler(e)">V</b-button>
          <b-button v-if="!inport" @click="o_handler(e)">O</b-button>
          <img  v-if=" inport" @click="$emit('inportAdd_handler', e)" class="icons-width" src="../img/adding.png">
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "search-result-rows",
  props: ["itm_arr", "ROWS_headers", "itm_arr_i", "index", "k", "inport"],
  data() {
    return {
      overflow: "auto",
      show: false
    };
  },
  computed: {
    items_count(){
      window.c = this
      let arr = this.itm_arr && this.itm_arr ? this.itm_arr.arr: [];
      let count = 0;
      Object.keys(arr).map ( e => count += arr[e].length )
      return count;
    }
  },
  watch: {},
   mounted() {
     this.$nextTick( () => {
        
     console.log('MOUNTED rows!')
      let resizer = window.resizer = e => { 
        let h = document.querySelector('.tr-th-main').offsetHeight;
        let d =  document.querySelectorAll('.tr-th-second');
        d.forEach(e=>e.style.top = h+'px ');
      } 
      window.onresize = resizer;
     });
      if(!window.resizer_tm) window.resizer_tm = setTimeout(e=>resizer(),100);

      if(this.inport) this.show = true;
    }, 
  updated() {},
  beforeDestroy(){
    clearInterval(window.resizer_tm);
  },
  methods: {
    show_handler(){
      this.show = !this.show;
      this.$emit('header_click');
    },
    v_handler(e) {
      alert("v=>" + e);
    },
    o_handler(e) {
      alert("o=>" + e);
    },
    parseKey(key) {
      return typeof key == "object" ? Object.keys(key) : "";
    } 
  }
};
</script>
 

<style lang="scss">

</style>
