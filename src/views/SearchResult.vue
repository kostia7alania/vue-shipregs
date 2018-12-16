<template>
  <div id="search-result">
  
    <div class="wrapper">
      <div class="content">
        <b-container fluid>
          <table class="my-table">
            <thead class="table-header">
              <tr>
                <th v-for="f in FIELDS" :key="f">{{f}}</th>
              </tr>
            </thead>
            <tbody class="table-content">
              <template v-for="itm_arr in items">
              <template v-for="(k,index) in parseKey(itm_arr.arr)">
                <!--заголовки разделов-->
                <tr v-if="index==0" :key="JSON.stringify(k) +  JSON.stringify(itm_arr) +  index + 1"> <td colspan="12" ><b>{{itm_arr.header}}</b></td></tr>
                <!-- даты -->
                <tr :key="JSON.stringify(k) + JSON.stringify(itm_arr) + index + 2"> <td style="text-align:left" colspan="12"><b>{{k}}</b></td>  </tr>
                <tr v-for="(e,i) in itm_arr.arr[k]" :key="JSON.stringify(e)+i+index+k + 2">
                  <td class="font-weight-bold">{{++i}}</td>
                  <td>{{e.CompanyName}}</td>
                  <td>{{e.CountryNameRus}}</td>
                  <td>{{e.DateEnter}}</td>
                  <td>{{e.DateEnter}}</td>
                  <td>{{e.DateEnter}}</td>
                  <td>{{e.DateEnter}}</td>
                  <td>{{e.Length}}</td>
                  <td>{{e.DateEnter}}</td>
                  <td>{{e.DateEnter}}</td>
                  <td>{{e.DateEnter}}</td>
                  <td>{{e.DateEnter}}</td>
                </tr>
</template>
          </template>
        </tbody>
      </table>
    </b-container>

    </div>
 <div class="footer">
    <b-container fluid>
     <table class="table table-bordered">
       <tbody>
        <tr> <th :colspan="FIELDS.length">1. ЗАХОД С МОРЯ</th> </tr>
        <tr> <th class="text-left" :colspan="FIELDS.length">14.11.2018</th> </tr>
        
        <tr v-for="(e,i) in new Array(111).fill(11)" :key="i"> 
          <td v-for="(f,ii) in FIELDS" :key="f">
            <span v-if="ii==0" class="font-weight-bold">{{f}}</span>
            <span v-else>{{f}}</span>
          </td>
        </tr> 
        
      </tbody>
    </table>

    </b-container>
    </div>
      </div> 
      
  </div>



  
  </div>
 


</template>

<script>
  import {
    searchResultFields_test
  } from "../assets/searchResultFields_test.js";
  
  export default {
    name: "search-result",
    props: ["searchResult"],
    data() {
      return {
        activeEntID: null,
        currentPage: 1,
        perPage: 5,
        totalRows: 0,
        pageOptions: [5, 10, 15],
  
        FIELDS: [
          "N пп",
          "Название судна, длина",
          "Тип судна",
          "Флаг",
          "Осадка",
          "Надводный габарит",
          "Время начала движ.",
          "Маршрут",
          "Причал/якорная стоянка",
          "Агентская компания",
          "Лоцм. обеспечение",
          "Примечание"
        ]
      };
    },
    computed: {
      fields() {
        return searchResultFields_test;
      },
      items() {
        //return ['first','second','third','fourth','fifth'].map(e=>this.parseRow(e))
        return [{
            header: "1. ЗАХОД С МОРЯ",
            arr: this.parseRow("first")
          },
          {
            header: "2. Переход на МОРЯ",
            arr: this.parseRow("second")
          },
          {
            header: "3. Подкат к МОРЯ",
            arr: this.parseRow("third")
          }
        ];
      },
      items_first() {
        return this.parseRow("first");
      },
      items_second() {
        return this.parseRow("second");
      },
      items_third() {
        return this.parseRow("third");
      },
      items_fourth() {
        return this.parseRow("fourth");
      },
      items_fifth() {
        return this.parseRow("fifth");
      },
  
      keys_first() {
        return this.parseKey(this.items_first);
      },
      keys_second() {
        return this.parseKey(this.items_second);
      },
      keys_third() {
        return this.parseKey(this.items_third);
      },
      keys_fourth() {
        return this.parseKey(this.items_fourth);
      },
      keys_fifth() {
        return this.parseKey(this.items_fifth);
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
    mounted() {
      jQuery.fn.bootstrapTable.defaults.formatNoMatches = () => {}; //удаляем ошибку при поиске  - баг? хз
      jQuery.fn.bootstrapTable.defaults.search = true;
  
      $('.my-table').bootstrapTable({
  
        formatLoadingMessage: function() {
          return '';
        }
      });
  
  
  
    },
    updated() {},
    methods: {
      parseKey(key) {
        return typeof key == "object" ? Object.keys(key) : "";
      },
      parseRow(name) {
        let o = this.searchResult;
        return o && typeof o == "object" && name in o ? o[name] : [];
      },
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
 

<style scoped lang="scss">
  .wrapper {
    display: flex;
    flex-direction: column;
    &>.footer {background: gray;}
  }
  
  
  /*.table-row,
    .table-header {
      display: flex;
      &>* {
        padding: 4px;
        margin: 0px;
        border: 1px solid;
      }
    }
    
    .my-table {
      display: flex;
      flex-direction: column;
      ;
    }
    */
  
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
