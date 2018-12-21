<template>
  <div id="search-result" class="wrapper">

        <div class="first-table" :style="{overflow: overflow}">
          <!--
          <div class='tr tr-th'>
            <div v-for="f in FIELDS" :key="f">  <b>{{f}}</b>  </div>
          </div>
          -->
          <div class="my-table">
            <div class="table-content">
              <div class="tr tr-th tr-th-main"> 
                <div v-for="(ff,i) in FIELDS" :key="ff" :class="{'first-colimn':i==0,
                                                               'actions-colimn':i==FIELDS.length-1}">{{ff}}</div>
              </div> 

            <res-head
                      v-for="(itm_arr,itm_arr_i) in items"
                      :key="itm_arr_i"
                      :itm_arr_i="itm_arr_i"
                      :itm_arr="itm_arr"
                      @header_click="header_click"
                      @actions_handlers="$emit('actions_handlers',$event)"
            />
 
            
            <!--   <template v-for="(itm_arr,itm_arr_i) in items"> 
<!- -              <p class="drag-to" v-if="itm_arr.header=='1. ЗАХОД С МОРЯ'"
                  :class="{over: over}"
                  @dragover="dragover_handler" 
                  @dragleave="dragleave_handler"
                  @drag="drag_handler"
                  @dragend="dragend_handler" 
                 :key='itm_arr_i'>test {{itm_arr_i}}</p>
--> 
             <!--    <search-result-rows  
                  v-for="(k,index) in parseKey(itm_arr.arr)" :key="''+itm_arr_i + index"
                  :itm_arr="itm_arr"
                  :ROWS_headers="ROWS_headers"
                  @header_click="header_click" 
                  :itm_arr_i="itm_arr_i"
                  :index="index"
                  :k="k"
                /> 
              </template>--> 
            </div>
          </div>
        </div> 
  
      <div class="drag-from" :class="{'second-table-minimized': !show_draft,'second-table': show_draft}" :style="{overflow: overflow}"> 
  
  
          <div class="table-bordered my-table">
            <!--
              <div class="tr tr-th tr-th-footer"> <div>Внутрипортовые перемещения (черновики)</div> </div> 
                <div draggable="true"
                  @dragstart="dragstart_handler"
                  @dragend="dragend_handler($event,i)"
                  @drag="drag_handler"
                 class="drag tr" v-for="(e,i) in new Array(111).fill(11)" :key="i">  
                  <div v-for="(f,ii) in FIELDS" :key="f ">
                      <span v-if="ii==0" class="font-weight-bold">{{f}}</span>
                      <span v-else>{{f}}</span>
                  </div> 
                </div>   
            -->
              <div class="table-content"> 
                
        <div @click="show_draft=!show_draft" class="tr tr-th tr-th-main sections-header" :class="{'tr-th-main-draft': 1}">
          <div> <b>ЧЕРНОВИКИ</b> &nbsp; <b-badge variant="primary">{{!show_draft?'↑':'↓'}} {{items_inport_count}}</b-badge> </div>
        </div>
            <res-head v-show="show_draft"
                      v-for="(itm_arr,itm_arr_i) in items_inport"
                      :key="itm_arr_i"
                      :itm_arr_i="itm_arr_i"
                      :itm_arr="itm_arr"
                      @header_click="header_click"
                      :inport="true"
                      @actions_handlers="$emit('actions_handlers',$event)"
            />

              </div>
          </div> 
        </div>

      </div>
</template>

<script> 
import resHead from './SearchResult_head';
export default {
    name: "search-result",
    components: { 'res-head': resHead}, 
    props: ["getUsersResult"],
    data() {
      return {
        show_draft: 0,
        overflow:'auto',
        over: false,

        
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
          "Груз",
          "Примечание",
          "Действия"
        ],

        ROWS_headers: [
            {header: "1. ЗАХОД С МОРЯ", show: 0},
            {header: "2. ВЫХОД В МОРЕ", show: 0},
            {header: "3. ВНУТРИПОРТОВЫЕ ПЕРЕМЕЩЕНИЯ", show: 0},
            {header: "4. ВЫХОД НА ВВП", show: 0},
            {header: "5. ТРАНЗИТ НА ВВП", show: 0},
            {header: "6. ЗАХОД С ВВП", show: 0} 
        ],
        ROWS_headers_inport: 
          {header: "3. ВНУТРИПОРТОВЫЕ ПЕРЕМЕЩЕНИЯ (черновики)", show: 0}
        
      };
    },
    computed: { 
      items() {
        return ['first','second','third','fourth','fifth','sixth'].map((e,i) => {
          return {...this.ROWS_headers[i], ...{arr: this.parseRow(e)}};
        })
      },
      items_inport() {
        let out = ['first','second','third','fourth','fifth','sixth'].map((e,i) => {
          return {...this.ROWS_headers[i], ...{arr: this.parseRow(e)}};
        })
        window.out = out;
        return out;
      },
      items_inport_count(){
        let a = 0;
        this.items_inport.forEach(e1=>Object.keys(e1.arr).forEach(key=>a+=e1.arr[key].length))
        return a;
      },
      items_count(){
        let a = 0;
        this.items.forEach(e1=>Object.keys(e1.arr).forEach(key=>a+=e1.arr[key].length))
        return a;
      }
    }, 
    mounted() {
      this.$nextTick( () => {
      console.log('MOUNTED head date!')
        let resizer = window.resizer = e => { 
          let h      = document.querySelector('.tr-th-main').offsetHeight;
          let d =  document.querySelectorAll('.tr-th-second');
          d.forEach(e=>e.style.top = h+'px ');

          let hDraft = document.querySelector('.tr-th-main-draft').offsetHeight;
          let dDraft =  document.querySelectorAll('.tr-th-second-inport');
          dDraft.forEach(e=>e.style.top = hDraft+'px ');

        } 
        window.onresize = resizer;
      });
      if(!window.resizer_tm) window.resizer_tm = setTimeout(e=>resizer(),100); 
    },
    methods: { 
      header_click(e) {
        //this.ROWS_headers[e].show = !this.ROWS_headers[e].show;
        this.overflow = 'inherit';
        this.$nextTick( () => this.overflow = 'auto' );
      }, 
      parseKey(key) {
        let a =  typeof key == "object" ? Object.keys(key) : "";
        console.log('parse!!=>',key, a);
        return a;
      }, 
      parseRow(name) {
        let o = this.getUsersResult;
        return o && typeof o == "object" && name in o ? o[name] : [];
      },         
      dragstart_handler(e){
        e.target.style.opacity = '0.4'; 
        e.dataTransfer.effectAllowed = 'all'; /*разрешенные события у драговера и энтера - значения е.dataTransfer.dropEffect */
        e.dataTransfer.setData('text',111);
        console.log(e.dataTransfer);
  //-> тащим иконку:
      let dragIcon = document.createElement("img");
      dragIcon.src = "./img/arrow.png";
      dragIcon.width = 100;
      e.dataTransfer.setDragImage(dragIcon, 0, 0);
      },

      dragend_handler (e, i) { //отпускаем в нужном месте, в "е" -- исходная(нужная) нода!
        e.target.style.opacity = '1'; 
        //e.target.classList.remove('over');
        this.over = false;
        this.delete_over(); // убираем бордюр 
        alert( 'перетащили -> ' + i );
      },
      dragover_handler (e) {
        this.delete_over (); // убираем бордюр
        let t = e.target;
        if(t.classList.contains ('tr')) {
          t.classList.add ('over')
          console.log (1);
        }
        else if(t.parentElement.classList.contains('tr')) {
          t.parentElement.classList.add('over');
          console.log(2);
        }
        else if(t.parentElement.parentElement.classList.contains('tr')){
          t.parentElement.parentElement.classList.add('over');
          console.log(3);
        }
        else if(t.parentElement.parentElement.parentElement.classList.contains('tr')) {
          t.parentElement.parentElement.parentElement.classList.add('over');
          console.log(4);
        }
        e.preventDefault(); 
        e.dataTransfer.dropEffect = 'copy'; //none, copy, link, move.
        return false;
      },
      dragenter_handler(e) {
        e.target.classList.add('over'); 
        this.over = true;
      },
      dragleave_handler(e){
        e.target.classList.remove('over');
        this.over = false;
      },
      drag_handler(e){
        let s = e.target.stopPropagation;
        if(s) s()  // See the section on the DataTransfer object.
        return false;
      },
      delete_over(){
        document.querySelectorAll('.over').forEach(e=>e.classList.remove('over'))
      },
    }
  };
</script>
 

<style lang="scss">

</style>
