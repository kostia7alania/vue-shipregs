<template>
  <div>
    <!--заголовки разделов-->
    <div
      class="tr tr-th" :class="{'tr-th-second': !inport,'tr-th-second-inport': inport}"
      @click="$emit('header_click',itm_arr_i)"
      :key="itm_arr.header + itm_arr_i + index + 1"
      >
      <div v-if="index==0">
        <b>{{itm_arr.header}}</b>
      </div>
    </div>

    <div :class="{height0: ROWS_headers[itm_arr_i].show}">
      <!-- даты -->
      <div class="tr tr-th2" :key="JSON.stringify(k) + JSON.stringify(itm_arr) + index + 2">
        <div style="text-align:left">
          <b>{{k}}</b>
        </div>
      </div>
      <div class="tr tr-td" v-for="(e,i) in itm_arr.arr[k]" :key="JSON.stringify(e)+i+index+k + 2">
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
          <button @click="v_handler(e.EntID)">V</button>
          <button @click="o_handler(e.EntID)">O</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { Drag, Drop } from "vue-drag-drop";
export default {
  name: "search-result-rows",
  props: ["itm_arr", "ROWS_headers", "itm_arr_i", "index", "k", "inport"],
  data() {
    return {
      overflow: "auto"
    };
  },
  computed: {},
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
    }, 
  updated() {},
  beforeDestroy(){
    clearInterval(window.resizer_tm);
  },
  methods: {
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
.height0 {
  height: 0px;
  display: none;
  visibility: hidden;
  transition: opacity 0.3s, visibility 0s linear 0.3s;
}
.tr-th-second {
  cursor: pointer;
  transition: 1s;
  &:hover {
    transform: zoom(1.2);
    background: red;
  }
}
.tr {
  display: flex;
  flex-direction: row;
  & > div {
    width: 33.3333%;
    flex-grow: 1;
    padding: 5px;
    word-break: break-all;
    flex: 1;
    border: 1px solid;
  }
}
.div-header {
  display: flex;
  justify-content: space-between;
  & > div {
    flex: 1;
    border: 1px solid;
  }
}

.tr-th {
  position: -webkit-sticky;
  position: sticky;
  z-index: 1;
  background-color: rgb(27, 30, 36);
  color: rgb(220, 220, 220);
}

.wrapper {
  justify-content: space-between;
  flex-direction: column;
  display: flex;
  height: 100vh;
  margin: 0px !important;
}

.second-table {
  display: block;
  max-height: 333px;
  height: 333px;
  min-height: 333px;
}

.wrapper {
  display: flex;
  flex-direction: column;
  & > .second-table {
    background: gray;
  }
}

.over {
  border: 2px dashed red !important;
}
.drag-from {
  cursor: pointer;
}
</style>
