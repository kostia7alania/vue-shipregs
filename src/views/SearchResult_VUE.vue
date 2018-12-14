<template>
    <div id="search-result"> 
    <b-container fluid >
   
  <div class="row">
    <b-table responsive @after-appear=""
          @row-clicked="row_clicked"
          @row-dblclicked="row_dblclicked"
          show-empty 
          small dark
          empty-text="Нет элементов для отображения"
          stacked="xl"
          striped hover
          caption-top	 
          :fields="fields" 
          :items="itemsComputed"
          @filtered="onFiltered"
          >

      <span slot="html" slot-scope="data" v-html="data.value"></span>
 
 
       <template slot="CompanyName" slot-scope="row">
        <!-- We use @click.stop here to prevent a 'row-clicked' event from also happening -->
        <b-button size="sm" @click.stop="info(row.item, row.index, $event.target)" class="mr-1">
          Info modal
        </b-button>
        <b-button size="sm" @mouseover=" ">
          {{ row.detailsShowing ? 'Hide' : 'Show' }} Details {{row-details}}
        </b-button>
      </template>
      <template slot="row-details" slot-scope="row">
        <b-card>
          SEX!
          <ul>
            <li v-for="(value, key) in row.item" :key="key">{{ key }}: {{ value}}</li>
          </ul>
        </b-card>
      </template>
 
    </b-table>
  </div>

    <b-row>
      <b-col md="6" class="my-1">
        <b-pagination :total-rows="totalRows" :per-page="perPage" v-model="currentPage" class="my-0" />
      </b-col>
    </b-row>
    
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
