<template>
    <div id="search-result"> 
    <b-container fluid > 
     <table class="table table-bordered">
  <thead> <tr> <th scope="col" v-for="f in FIELDS" :key="f">{{f}}</th>  </tr> </thead>
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
  
</template> 

<script> 
import { searchResultFields_test } from '../assets/searchResultFields_test.js';


export default {  
  name: "search-result",
  props:['searchResult'],
  data() {
    return {  
      activeEntID:null, 
      currentPage: 1,
      perPage: 5,
      totalRows: 0,
      pageOptions: [ 5, 10, 15 ],

      FIELDS:[
        'N пп',
        'Название судна, длина',
        'Тип судна',
        'Флаг',
        'Осадка',
        'Надводный габарит',
        'Время начала движ.',
        'Маршрут',
        'Причал/якорная стоянка',
        'Агентская компания',
        'Лоцм. обеспечение',
        'Примечание'
      ]
    };
  }, 
  computed: { 
    fields() { return searchResultFields_test },
    items() {
      let o = this.searchResult;
      if (o && typeof  o == 'object' && 'first' in o) return o.first
    },
    itemsComputed() {//_rowVariant: 'danger'  
      let itm = this.items;
      if(itm){
        itm =  itm.map( (e,i) => {
          if (e.EntID==this.activeEntID) e._rowVariant = 'info' //выделение активной (нажатой) строки;
          else  e._rowVariant = '';
          e.i = ++i
          return e
        }) 
        return itm
      }
    } 
  },
  watch:{  
    items(){this.app_number = null;},
    searchActiveTab_computed: function(){this.tabs.map(tab=>tab.active = 0);},
   },
  mounted() {}, 
  updated() {},
  methods: {  
    row_clicked(e){ this.activeEntID = e.EntID; console.log('row_clicked=>',e);   },
    row_dblclicked(e){
      console.log('row dblclicked e,this',e,this);
    },
    onFiltered (filteredItems) {
      // Trigger pagination to update the number of buttons/pages due to filtering
      this.totalRows = filteredItems.length
      this.currentPage = 1
    }
  }
};
</script>

<style>#search-result thead {background: #ccc !important;}td{cursor:pointer;}
* {box-sizing: border-box;}
</style>

<style scoped  >


@media (max-width:723px){
  .order1-845{order:1;}
  .order0-845{order:0; margin-bottom: 10px;}
}

.row.justify-content-left.my-col.m-10.show-1500px-m.align-items-center { width: 100%; }
 
 .my-btns button {
    padding: 7px 10px;
    margin-right: 10px;
    border-radius: 6px;
    border: none;
  }
.my-btns { 
  display: flex;
  margin-right:0px;
  min-width: 400px !important;  
}
.padding-left0{padding-left:0px;}

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
