<template>
  <div class="myTable">
    <div class="myTable_rows" v-for="(row,i) in rows" :key="i">
      <div class="myTable_cols">{{row.ShipTypeNameRus}}</div>
      <div class="myTable_cols">{{row.CompanyName}}</div>
      <div class="myTable_cols">{{row.DepositStern}}</div>
      <div class="myTable_cols">{{row.HourMinute}}</div>
      <div class="myTable_cols">{{row.Note}}</div>
      <!-- ВСЕ ПОДРЯД ==> <div class="myTable_cols" v-for="(col,ii) in row" :key="ii">{{col}}</div> -->
      <hr><hr><hr>
    </div>
  </div>
</template> 

<script>
export default {
  name: "my-table",
  components: {},
  props: {
    rows: {
      type: [Boolean,Object],
      default:()=>[]
    }
  },
  data() {
    return {};
  },
  computed: {},
  watch: {},
  mounted() {},
  updated() {},
  methods: {
    row_clicked(e) {
      this.activeEntID = e.EntID;
      console.log("row_clicked=>", e);
    },
    row_dblclicked(e) {
      console.log("row dblclicked e,this", e, this);
    }
  }
};
</script>
 


<style scoped  >
.myTable {
  min-width: 1500px;
  display: flex;
  flex-direction: column;
  align-self: center;
} 

.myTable_cols {
  display: flex;
  align-items: center;
  justify-content: center;
  flex: 10;
  border: 1px solid black;
  margin: 0px !important;
}

.myTable_cols:nth-child(1) {
  flex: 2;
} 
</style>
