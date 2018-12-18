<template>
  <div id="search-result" class="wrapper">

        <div class="first-table" :style="{overflow: overflow}">
          <!--
          <div class='tr tr-th'>
            <div v-for="f in FIELDS" :key="f">  <b>{{f}}</b>  </div>
          </div>
          -->
          <div class="my-table" v-show="items_any_available">
            <div class="table-content">
              <div class="tr tr-th tr-th-main"> 
                <div v-for="ff in FIELDS" :key="ff">{{ff}}</div>
              </div>

              <template v-for="(itm_arr,itm_arr_i) in items"> 
<!--              <p class="drag-to" v-if="itm_arr.header=='1. ЗАХОД С МОРЯ'"
                  :class="{over: over}"
                  @dragover="dragover_handler" 
                  @dragleave="dragleave_handler"
                  @drag="drag_handler"
                  @dragend="dragend_handler" 
                 :key='itm_arr_i'>test {{itm_arr_i}}</p>
--> 
                <search-result-rows 
                  v-for="(k,index) in parseKey(itm_arr.arr)" :key="''+itm_arr_i + index"
                  :itm_arr="itm_arr"
                  :ROWS_headers="ROWS_headers"
                  @header_click="header_click" 
                  :itm_arr_i="itm_arr_i"
                  :index="index"
                  :k="k"
                />

              </template>
            </div>
          </div>
        </div> 
  
        <div  class="second-table drag-from" :style="{overflow: overflow}">
          <div class="table table-bordered my-table">
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
                <search-result-rows 
                  v-for="(k,index) in parseKey(items_inport.arr)" :key="''+ index" 
                  :itm_arr="items_inport"
                  :itm_arr_i="0"
                  :index="index"
                  :k="k"
                  :ROWS_headers="[ROWS_headers_inport]"
                  :inport="true"
                /> 
              </div>
          </div> 
        </div>

      </div>
</template>

<script>
import { searchResultFields_test  } from "../assets/searchResultFields_test.js";
import { Drag, Drop } from 'vue-drag-drop';
import resRows from './SearchResult_ROWS';
export default {
    name: "search-result",
    components: { Drag, Drop,'search-result-rows': resRows}, 
    props: ["getUsersResult", "getInportResult"],
    data() {
      return {
        overflow:'auto',
        over: false,

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
          "Груз",
          "Примечание",
          "Действия"
        ],
        ROWS_headers: [
            {header: "1. ЗАХОД С МОРЯ", show: 0},
            {header: "2. ВЫХОД В МОРЕ", show: 0},
            {header: "4. ВЫХОД НА ВВП", show: 0},
            {header: "5. ТРАНЗИТ НА ВВП", show: 0},
            {header: "6. ЗАХОД С ВВП", show: 0} 
        ],
        ROWS_headers_inport: {header: "3. ВНУТРИПОРТОВЫЕ ПЕРЕМЕЩЕНИЯ (черновики)", show: 0}
      };
    },
    computed: {
      fields() {
        return searchResultFields_test;
      },
      items() {
        return ['first','second','third','fourth','fifth'].map((e,i) => {
          return {...this.ROWS_headers[i], ...{arr: this.parseRow(e)}};
        })
      },
      items_inport() { 
          return {...this.ROWS_headers_inport, ...{ arr: this.parseRow('Inport') } }; 
      },
      items_any_available () {
        return ['first','second','third','fourth','fifth'].some(e=>typeof this.parseRow(e) === 'object' && (Object.keys(this.parseRow(e))).length)
      },  
      itemsComputed() {
        //_rowVariant: 'danger'
        let itm = this.items;
        if (itm) {
          itm = itm.map((e, i) => {
            if (e.EntID == this.activeEntID) e._rowVariant = "info"; //выделение активной (нажатой) строки;
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
        console.log('items watch')
      },
      searchActiveTab_computed: function() {
        this.tabs.map(tab => (tab.active = 0));
      }
    }, 
    methods: { 
      header_click(e) {
        this.ROWS_headers[e].show = !this.ROWS_headers[e].show;
        this.overflow = 'inherit';
        this.$nextTick( () => this.overflow = 'auto' );
      }, 
      parseKey(key) {
        return typeof key == "object" ? Object.keys(key) : "";
      },
      parseRow(name) {
        let o;
        if(name == 'Inport') o = this.getInportResult;
        else o = this.getUsersResult;
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
.height0 {  
  height: 0px;;
  display: none;
  visibility: hidden;
  transition: opacity 0.3s, visibility 0s linear 0.3s;
}
.tr-th-second-inport,
.tr-th-second{
  cursor: pointer;
  transition: 1s; 
  &:hover {
    transform: zoom(1.2);
    background: red;
  }
}
.tr {
  display: flex;
  flex-direction: row;
  & > div {
    width: 33.3333%;
    flex-grow: 1;
    padding: 5px;
    word-break: break-all;
    flex:1;
    border: 1px solid;
  }
}
.div-header{
  display: flex;
  justify-content: space-between;
  & > div {
    flex:1;
    border: 1px solid;
  }
}
 
 .tr-th-footer,
 .tr-th-main {
  top: 0px;
 } 
.tr-th {
  position: -webkit-sticky;
  position: sticky;
  z-index: 1;
  background-color: rgb(27,30,36);
  color: rgb(220,220,220);
}


.wrapper {
	justify-content:space-between;
	flex-direction: column;
	display: flex;
	height: 100vh;
  margin: 0px !important;
}


.overflow { overflow: auto; }

.second-table {
  display: block;
  max-height:333px; 
  height:333px; 
  min-height:333px;  
}


  .wrapper {
    display: flex;
    flex-direction: column;
    &>.second-table {background: gray;}
  } 
    
.over { border: 2px dashed red !important;}
.drag-from { cursor: pointer; }
</style>
