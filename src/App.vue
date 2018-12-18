<template>
  <div id="app">
    <SearchPanel @graf_refresh="graf_refresh"/>
    <SearchResult :getUsersResult="getUsersResult" :getInportResult="getInportResult" />
  </div>
</template>

<script>
import SearchPanel from './views/SearchPanel.vue'

import SearchResult from './views/SearchResult.vue'
import { searchResultItems_test } from "./assets/searchResultItems_test.js";


export default {
  name: 'app',
  components: { SearchPanel, SearchResult },
  data(){
    return {
      getUsersResult: null,
      getInportResult: null,
      url: 'https://portcall.marinet.ru/grafics/graf/db_grafics.php'
    }
  }, 
  methods: { //actions => 'getInport'; 'getUsers';
    graf_refresh ({data, action}) {
      let test = (e) => e?e:'';
      let p = test(data.ed_Port)
      let hf = test(data.timeFrom.HH)
      let mf = test(data.timeFrom.mm)
      let ht = test(data.timeTo.HH)
      let mt = test(data.timeTo.mm)
      let df = test(data.ed_DateFrom) 
      let url = `${this.url}?action=${action}&port=${p}&HoursFrom=${hf}&MinsFrom=${mf}&HoursTo=${ht}&MinsTo=${mt}&ed_DateFrom=${df}`;
        console.log('ПРИНЯЛИ !graf_refresh')
        axios.get(url)
        .then( res => {
          let data = res.data;
          if(typeof data == 'string' && data.match('SQL')!=null ) throw 'MS SQL ERROR!'
          window.data = data; 
          try{data = JSON.parse(data.replace(/&quot;/gim,'"'))}catch(e){console.log('[catch] [err] ->',e);throw 'Невозможно спарсить данные, пришедшие с сервера!'}
          if( typeof data != 'object' ) throw 'данные не пришли';
          if(action == 'getUsers'){
            this.getUsersResult = null; 
            this.getUsersResult = data;            
          }
          if(action == 'getInport'){
            this.getInportResult = null;
            this.getInportResult = data;
          }
        }).catch( err => {
          console.warn('ОШИБКА в аксиосе => ', err);
          alert('Ошибка ' + err)
        })
      } 
  }
}
</script>

<style>

#app {
	justify-content:space-between; 
	flex-direction: column;
	display: flex; 
	height: 100vh;
  margin: 0px !important;
}
 
input, select {
  min-width: 100px;
}
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
