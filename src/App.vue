<template>
  <div id="app"> 
    <SearchHeader :data="data"/>
    <SearchPanel :loading="loading" @graf_refresh="graf_refresh" @emit_data="data=$event" :counts_all="counts_all" />
    <SearchResult :getUsersResult="getUsersResult" @actions_handlers="actions_handlers"/>
   </div>
</template>

<script>
import SearchPanel from './views/SearchPanel.vue'
import SearchHeader from './views/SearchHeader.vue' 
import SearchResult from './views/SearchResult.vue'
 

import {mixins} from './mixins.js';

export default {
  mixins:[mixins],
  name: 'app',
  components: { SearchPanel, SearchResult, SearchHeader },
  data () {
    return {
      loading: false,
      getUsersResult: null,
      url: 'https://portcall.marinet.ru/grafics/graf/db_grafics.php',
      data: null
    }
  },
  computed: {
    counts_all() {
    let d = this.getUsersResult, a = 0;
    window.d = d; 
    if(!d) return 0;
    Object.keys(d).forEach(key=>{
      Object.keys(d[key]).forEach(key2=>{
        a += d[key][key2].length;
      })
    });
    return a;
    }
  },
  methods: {
    actions_handlers({action,data}) {
        console.log('actions_handlers',arguments)
      if      ( action == 'toProd' ) this.transferRows(data, 'toProd');
      else if ( action == 'toDraft') this.transferRows(data, 'toDraft');
      else if ( action == 'edit'   ) this.edit   ();
    },
    edit(){
      console.log('edit!');
      this.$toast.warning('Правим!)', 'Редактируем', this.notificationSystem.options.warning);

    },
    graf_refresh ({data, action = 'getUsers'}) { //actions => 'getInport'(уже нету!); 'getUsers';
      this.loading = true;
      this.data = data;
      let test = (e) => e?e:'';
      let p  = test(data.ed_Port)
      let hf = test(data.timeFrom.HH)
      let mf = test(data.timeFrom.mm)
      let ht = test(data.timeTo.HH)
      let mt = test(data.timeTo.mm)
      let df = test(data.ed_DateFrom) 
      let headers = {};
      if(action === 'toExport') headers = { responseType: 'blob' };
      let url = `${this.url}?action=${action}&port=${p}&HoursFrom=${hf}&MinsFrom=${mf}&HoursTo=${ht}&MinsTo=${mt}&ed_DateFrom=${df}`;
        console.log('ПРИНЯЛИ !graf_refresh')
        axios.get(url, headers)
        .then( res => {
          this.loading = false
          let data = res.data;
          if( typeof data == 'string' && data.match('SQL') != null ) throw 'MS SQL ERROR!'
            window.data = data;
            if(action === 'toExport' ){
                var fileDownload = require('js-file-download');
                console.log('toExport',data)
                fileDownload(data, 'filename.xlsx'); 
              return;
            }
          try{data = JSON.parse(data.replace(/&quot;/gim,'"'))}catch(e){console.log('[catch] [err] ->',e);throw 'Невозможно спарсить данные, пришедшие с сервера!'}
          if( typeof data != 'object' ) throw 'данные не пришли';

            this.getUsersResult = data;
        }).catch( err => {
          this.loading = false;
          console.warn('ОШИБКА в аксиосе => ', err);
          this.$toast.warning('Произошла ошибка при получении данных', 'Сетевая ошибка', this.notificationSystem.options.warning);
        })
      },

      transferRows(obj, action) {
         let send_data = { ...this.data, ... obj }
        console.log('transferRows=>',arguments,'send_data=>',send_data)
        let url = `${this.url}?action=${action}`;
        axios .post(url,send_data) 
              .then( e => this.graf_refresh({data: send_data, action: 'getUsers'}) )
              .catch(err=>{
                console.log('Ошибка при ПОСТе => ',err);
                this.$toast.warning('Произошла ошибка при отправке данных', 'Сетевая ошибка', this.notificationSystem.options.warning);
              });
      }

  }
}
</script>

<style lang="scss">
@import './global_styles.scss'
</style>
