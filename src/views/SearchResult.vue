<template>
  <div id="search-result">
    <b-container fluid>
      
      <div class="myTable">
        <div class="myTHeader">
          <div class="myTHeader_cols" v-for="th in theaders" :key="th">{{th}}</div>
        </div>
        <div class="myTHeader myTHeader_row"><span>1. ЗАХОД С МОРЯ</span></div>
        <MyTable :rows="first"/>
      </div>
      
    </b-container>
  </div>
</template> 

<script>
import { searchResultFields_test } from "../assets/searchResultFields_test.js";
import { VueGoodTable } from "vue-good-table";
import MyTable from './MyTable';

export default {
  name: "search-result",
  components: { VueGoodTable, MyTable},
  props: ["searchResult"],
  data() {
    return {
      activeEntID: null,
      currentPage: 1,
      perPage: 5,
      totalRows: 0,
      pageOptions: [5, 10, 15],

      theaders: ['N пп', 'Название судна, длина', 'Тип судна','Флаг','Осадка','Надводный габарит','Время начала движ.','Маршрут','Причал/якорная стоянка','Агенсткая компания','Лоцм. обеспечение','Примечание']
   
    };
  },
  computed: {
    first(){
      let s = this.searchResult; 
      return s && s!=null && typeof s == 'object' && 'first' in s ? s.first: false;
    },
    fields() {
      return searchResultFields_test;
    },
    items() {
      let o = this.searchResult;
      if (o && typeof o == "object" && "first" in o) return o.first;
    },
    itemsComputed() {
      //_rowVariant: 'danger'
      let itm = this.items;
      if (itm) {
        itm = itm.map((e, i) => {
          if (e.EntID == this.activeEntID) e._rowVariant = "info";
          //выделение активной (нажатой) строки;
          else e._rowVariant = "";
          e.i = ++i;
          return e;
        });
        return itm;
      }
    }
  },
  watch: {
    items() {
      this.app_number = null;
    },
    searchActiveTab_computed: function() {
      this.tabs.map(tab => (tab.active = 0));
    }
  },
  mounted() {},
  updated() {},
  methods: {
    row_clicked(e) {
      this.activeEntID = e.EntID;
      console.log("row_clicked=>", e);
    },
    row_dblclicked(e) {
      console.log("row dblclicked e,this", e, this);
    },
    onFiltered(filteredItems) {
      // Trigger pagination to update the number of buttons/pages due to filtering
      this.totalRows = filteredItems.length;
      this.currentPage = 1;
    }
  }
};
</script>
 


<style scoped  >

.myTable {
    min-width:1500px;
    display: flex;
    flex-direction: column;
}
.myTHeader {
  display: flex;
  justify-content: space-between;
  font-weight:666;
  padding: 0 10px;
  margin:0px;
}

.myTHeader_cols { 
    display: flex;
    align-items: center;
    justify-content: center; 
  flex:10;
  border: 1px solid black;
  margin: 0px !important;
} 

.myTHeader_cols:nth-child(1){
  flex:2;
}
.myTHeader_row{
  align-self: center;
}




@media (max-width: 723px) {
  .order1-845 {
    order: 1;
  }
  .order0-845 {
    order: 0;
    margin-bottom: 10px;
  }
}

.row.justify-content-left.my-col.m-10.show-1500px-m.align-items-center {
  width: 100%;
}

.my-btns button {
  padding: 7px 10px;
  margin-right: 10px;
  border-radius: 6px;
  border: none;
}
.my-btns {
  display: flex;
  margin-right: 0px;
  min-width: 400px !important;
}
.padding-left0 {
  padding-left: 0px;
}

@media (min-width: 1300px) {
  .show-1500px-m {
    display: none;
  }
  .show-1500px-p {
    display: block;
  }
}
@media (max-width: 1300px) {
  .show-1500px-m {
    display: block;
  }
  .show-1500px-p {
    display: none;
  }
}
</style>
