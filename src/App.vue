<template>
  <div id="app">
    <SearchPanel @graf_refresh="graf_refresh"/>
    <SearchResult :searchResult="searchResult"/>
  </div>
</template>

<script>
import SearchPanel from './views/SearchPanel.vue'

import SearchResult from './views/SearchResult.vue'
import { searchResultItems_test } from "./assets/searchResultItems_test.js";

window.axios = require('axios');

export default {
  name: 'app',
  components: { SearchPanel, SearchResult },
  data(){
    return {
      searchResult: null,
      url: 'https://portcall.marinet.ru/grafics/graf/db_grafics.php'
    }
  },
  methods: {
    graf_refresh (data) {
      let test = (e) => e?e:'';
      let p = test(data.ed_Port)
      let hf = test(data.timeFrom.HH)
      let mf = test(data.timeFrom.mm)
      let ht = test(data.timeTo.HH)
      let mt = test(data.timeTo.mm)
      let df = test(data.ed_DateFrom)
      let url = `${this.url}?action=getUsers&port=${p}&HoursFrom=${hf}&MinsFrom=${mf}&HoursTo=${ht}&MinsTo=${mt}&ed_DateFrom=${df}`;
      
      this.searchResult =  searchResultItems_test
      if(1){ // test
        console.log('ПРИНЯЛИ !graf_refresh')
        axios.get(url)
        .then(res=>{ 
          let data = res.data;
          if(typeof data != 'object') throw 'данные не пришли';
          this.searchResult = data;  
        })
        .catch(err=>{
          console.warn('ОШИБКА в аксиосе => ', err);
          alert('Ошибка!')
        })
      }
    }
  }
}
</script>

<style>
button {
  background-color: #4CAF50; /* Green */
  border: none;
  color: white;
  padding: 5px 32px;
  margin:10px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  cursor: pointer;
}
button:hover{
  background:coral;
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
