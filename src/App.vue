<template>
  <div id="app"> 
    <SearchHeader :data="data" :ports="ports"/>
    <SearchPanel :ports="ports" :loading="loading" @graf_refresh="graf_refresh" @emit_data="data=$event" :counts_all="counts_all" />
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
  props: ['url'],
  components: { SearchPanel, SearchResult, SearchHeader },
  data () {
    return {
      loading: false,
      getUsersResult: null, 
      data: null,
      ports: null
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
  mounted(){
    this.loading = true;
    //import { ports } from "./assets/ports.js";
    let port = '';
      let url = `${this.url}?action=getPorts&port=${port}`;
      axios
      .get(url)
      .then(e=>{
        let d = e.data;  
        if(!(d instanceof Array) && d instanceof Object){ 
          //d = Object.keys(d).map( key => [ +key, d[key] ] );//преобразование в аррау
          d =  Object.keys(d).map( key => d[key] );
        }
        if(d instanceof Array && d.length>0){ ///[ {value: null,text:'все'}, {value:"RUAZO",text:"Азов"},..]
          this.ports = d;
        } else throw 'Пришли кривые данные!';
        this.loading = false;
     })
     .catch( err => {
          this.loading = false;
          console.warn('ОШИБКА в аксиосе => ', err);
          this.$toast.warning('Произошла ошибка при получении списка портов', 'Сетевая ошибка', this.notificationSystem.options.warning);
        })
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
      console.warn('=>',arguments);
      this.loading = true;
      this.data = data;
      let test = (e) => e?e:'';
      let p  = test(data.ed_Port)
      let ports  = test(this.ports)
      let hf = test(data.timeFrom.HH)
      let mf = test(data.timeFrom.mm)
      let ht = test(data.timeTo.HH)
      let mt = test(data.timeTo.mm)
      let df = test(data.ed_DateFrom) 
      let headers = {};

      if(action === 'toExport') headers = { responseType: 'blob' };
      
      if ( action == 'toSend' )  this.transferRows(data, 'toSend');
      else {

      let url = `${this.url}?action=${action}&port=${p}&HoursFrom=${hf}&MinsFrom=${mf}&HoursTo=${ht}&MinsTo=${mt}&ed_DateFrom=${df}`;
        console.log('ПРИНЯЛИ !graf_refresh')
        axios
        .get(url, headers)
        .then( res => {
          this.loading = false
          let data = res.data;
          if( typeof data == 'string' && data.match('SQL') != null ) throw 'MS SQL ERROR!' 
            if(action === 'toExport' ){console.log('toExport',data);
                var fileDownload = require('js-file-download'); 
                let prt = ports.filter( e => e.value == p );
                prt =  prt.length>0 ? prt[0].text : '';   
                fileDownload(data, `Export-${df} [${hf}-${mf} - ${ht}-${mt}]${p?'. '+prt:''}.xlsx`); 
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
      }
      },

      transferRows(obj, action) {
         let send_data = { ...this.data, ... obj }
        console.log('transferRows=>',arguments,'send_data=>',send_data)
        if( action === 'toSend' ) {
          send_data = {send_data, ...this.getUsersResult};//если суточная телега -подмешиваем существующими данными;
        }
        let url = `${this.url}?action=${action}`; 
        axios .post(url,send_data) 
              .then( e => this.graf_refresh({data: send_data, action: 'getUsers'}) )
              .catch(err=>{
                 this.loading = false;
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
