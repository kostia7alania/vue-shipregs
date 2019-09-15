<template>
  <div id="search-header--wrapper" v-if="PARAMS">
    <div class="search-header">
      <span>График расстановки и движения судов
        <transition name="component-fade">
          <span v-if="PARAMS.ed_Port">в морском порту</span>
        </transition>
      </span>
      <span class="css-typing" v-if="PARAMS.ed_Port && CUR_PORT"> {{CUR_PORT}}</span>
      <span class="css-typing" v-if="!PARAMS.ed_Port">во всех морских портах</span>
    </div>

    <template v-if="PARAMS && compDate(2)  && PARAMS.ed_DateFrom && compDatePlus1() && PARAMS.timeTo.HH">
      <h6 class="first-h6"> с
        <animateNumber :value="PARAMS.timeFrom.HH" :isTime="true"/>:<animateNumber :value="PARAMS.timeFrom.mm" :isTime="true"/> <!--{{data.ed_DateFrom}}--> &nbsp; <animateNumber :value="compDate(0)"  :isTime="true"/>.<animateNumber :value="compDate(1)"  :isTime="true"/>.<animateNumber :value="compDate(2)"/></h6>
      <h6 class="second-h6"> по
       <animateNumber :value="PARAMS.timeTo.HH" :isTime="true"/>:<animateNumber :value="PARAMS.timeTo.mm" :isTime="true"/>  <!--{{getTODAY}}-->       &nbsp;    <animateNumber :value="compDatePlus1().dd"  :isTime="true"/>.<animateNumber :value="compDatePlus1().mm"  :isTime="true"/>.<animateNumber :value="compDatePlus1().yy"/></h6>

    </template>

  </div>
</template>

<script>
export default {
  name: "search-header", 
  data() {
    return { 
      CUR_PORT: null
    };
  },
  computed: {
    PARAMS() {
      return this.$store.state.searchPanel.PARAMS

    },
    getPORT() {
      let p = this.PARAMS.ed_Port;
      let ps = this.$store.state.searchPanel.PORTS
      if (!ps) return ""; //'Порты не приехали!';
      const res = ps.filter(e => e.value == p);
      return res.length > 0 ? res[0].text : false;
    },
    getTODAY() {
      let n = new Date();
      return `${new Date().getDate()}.${n.getMonth() + 1}.${n.getFullYear()}`;
    },

    compDatePlus1_comp() {
      let r = this.compDatePlus1();
      return typeof r === "object" ? r.dd : "";
    }
    
  },
  mounted() {
    this.CUR_PORT = this.getPORT
  },
  watch: {
    getPORT() {
      this.CUR_PORT = null;
      this.$nextTick(()=>this.CUR_PORT = this.getPORT)
    }
  },
  methods: {
    compDate(num) {
      let d = this.PARAMS;
      if (
        typeof d === "object" &&
        "ed_DateFrom" in d &&
        typeof d.ed_DateFrom == "string"
      )
        return d.ed_DateFrom.split(".")[num];
      //else return '';
    },
    compDatePlus1() {
      let d = this.PARAMS;
      if (
        typeof d === "object" &&
        "ed_DateFrom" in d &&
        typeof d.ed_DateFrom == "string"
      ) {
        let dd = d.ed_DateFrom.split(".")[0];
        let mm = d.ed_DateFrom.split(".")[1];
        let yy = d.ed_DateFrom.split(".")[2];
        let date = new Date(`${yy}-${mm}-${dd}`);
        date.setDate(date.getDate() + 1);
        return {
          dd: date.getDate(),
          mm: date.getMonth() + 1,
          yy: date.getFullYear()
        };
      } else return "";
    }
  }
};
</script>


<style lang="scss" scope>
.first-h6 { padding-left: 7px; }

.css-typing {
  width: 30em;
  white-space: nowrap;
  overflow: hidden;
  -webkit-animation: type 5s steps(50, end);
  animation: type 5s steps(50, end);
}

@keyframes type {
  from { width: 0; }
}

@-webkit-keyframes type {
  from { width: 0; }
}

.component-fade-enter-active { transition: all 0.3s ease; }
.component-fade-leave-active {
  transition: opacity 0.3s ease;
  transition: all 0.2s cubic-bezier(1, 0.5, 0.8, 1);
}
.component-fade-enter, .component-fade-leave-to
/* .component-fade-leave-active до версии 2.1.8 */ {
  transform: translateX(10px);
  opacity: 0;
}

.search-header { 
  display: flex;
  flex-direction: column;
  align-items: center;
  font-size: 2em;
}

</style>
