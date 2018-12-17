<template>
  <div id="search-result" class="wrapper">

        <div  class="first-table overflow drag-to" :class="{over: over}"
              @dragover="dragover_handler" 
              @dragleave="dragleave_handler"
              @drag="drag_handler"
              @dragend="dragend_handler">
          <!--
          <div class='tr tr-th'>
            <div v-for="f in FIELDS" :key="f">  <b>{{f}}</b>  </div>
          </div>
          -->
          <div class="my-table"  v-show="items_any_available">
            <div class="table-content">
                  <div class="tr tr-th tr-th-main"> 
                    <div v-for="ff in FIELDS" :key="ff">{{ff}}</div>
                   </div>  
 
              <template v-for="itm_arr in items">
                <template v-for="(k,index) in parseKey(itm_arr.arr)">

                  <!--заголовки разделов-->
                  <div  class="tr tr-th tr-th-second" :key="JSON.stringify(k) +  JSON.stringify(itm_arr) +  index + 1">
                    <div v-if="index==0"><b>{{itm_arr.header}}</b></div>
                  </div>
                  <!-- даты -->
                  <div class="tr tr-th2" :key="JSON.stringify(k) + JSON.stringify(itm_arr) + index + 2"> <div style="text-align:left"><b>{{k}}</b></div>  </div>
                  <div class="tr tr-td" v-for="(e,i) in itm_arr.arr[k]" :key="JSON.stringify(e)+i+index+k + 2">
                    <div class="font-weight-bold">{{++i}}</div>
                    <div>{{e.CompanyName}}</div>
                    <div>{{e.CompanyName}}</div>
                    <div>{{e.DateEnter}}</div>
                    <div>{{e.DateEnter}}</div>
                    <div>{{e.DateEnter}}</div>
                    <div>{{e.DateEnter}}</div>
                    <div>{{e.Length}}</div>
                    <div>{{e.DateEnter}}</div>
                    <div>{{e.DateEnter}}</div>
                    <div>{{e.DateEnter}}</div>
                    <div>{{e.DateEnter}}</div>
                    <div>{{e.DateEnter}}</div>
                    <div>
                      <button @click="v_handler(e.EntID)">V</button>
                      <button @click="o_handler(e.EntID)">O</button>
                    </div>
                  </div>
                </template>
              </template>
            </div>
          </div>
        </div> 
  
        <div  class="second-table overflow drag-from"
                  
           >
          <div class="table table-bordered my-table"> 
              <div class="tr tr-th tr-th-footer"> <div>К перетаскиванию</div> </div>
              
                <div draggable="true"
                  @dragstart="dragstart_handler"
                  @dragend="dragend_handler($event,i)"
                  @drag="drag_handler"
                 class="drag tr" v-for="(e,i) in new Array(111).fill(11)" :key="i"> 
                 
                  <div v-for="(f,ii) in FIELDS" :key="f">
                      <span v-if="ii==0" class="font-weight-bold">{{f}}</span>
                      <span v-else>{{f}}</span>
                  </div>
                  
                </div>   
          </div> 
        </div>

      </div>
</template>

<script>
import { searchResultFields_test  } from "../assets/searchResultFields_test.js";
import { Drag, Drop } from 'vue-drag-drop';
export default {
    name: "search-result",
    components: { Drag, Drop }, 
    props: ["searchResult"],
    data() {
      return {
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
          },{
            header: "2. ВЫХОД В МОРЕ",
            arr: this.parseRow("second")
          },{
            header: "3. ВНУТРИПОРТОВЫЕ ПЕРЕМЕЩЕНИЯ",
            arr: this.parseRow("third")
          },{
            header: "4. ВЫХОД НА ВВП",
            arr: this.parseRow("fourth")
          },{
            header: "5. ТРАНЗИТ НА ВВП",
            arr: this.parseRow("fifth")
          },{
            header: "6. ЗАХОД С ВВП",
            arr: this.parseRow("sixth")
          }
        ];
      },
      items_any_available () {
        return ['first','second','third','fourth','fifth'].some(e=>typeof this.parseRow(e) === 'object' && (Object.keys(this.parseRow(e))).length)
      },
      items_first() {return this.parseRow("first");},
      items_second(){return this.parseRow("second");},
      items_third() {return this.parseRow("third");},
      items_fourth(){return this.parseRow("fourth");},
      items_fifth() {return this.parseRow("fifth");}, 
      keys_first() {return this.parseKey(this.items_first);},
      keys_second(){return this.parseKey(this.items_second);},
      keys_third() {return this.parseKey(this.items_third);},
      keys_fourth(){return this.parseKey(this.items_fourth);},
      keys_fifth() {return this.parseKey(this.items_fifth);},
  
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
        console.log('items watch')
        setTimeout(e=>resizer(),100);
        this.app_number = null;
      },
      searchActiveTab_computed: function() {
        this.tabs.map(tab => (tab.active = 0));
      }
    },
    mounted() {
      let resizer = window.resizer = e => { 
        let h = document.querySelector('.tr-th-main').offsetHeight;
        let d =  document.querySelectorAll('.tr-th-second');
        d.forEach(e=>e.style.top = h+'px ');
      }
      
      window.onresize = resizer;
      /*event.dataTransfer.dropEffect = "copy";
     
      jQuery.fn.bootstrapTable.defaults.formatNoMatches = () => {}; //удаляем ошибку при поиске  - баг? хз
      jQuery.fn.bootstrapTable.defaults.search = false;
      $('.my-table').bootstrapTable({   formatLoadingMessage: function() { return '';}    });
      */
    },
    updated() {},
    methods: {
      v_handler(e){ 
        alert('v=>'+e);
      },
      o_handler(e){
        alert("o=>"+e);
      },
      parseKey(key) {
        return typeof key == "object" ? Object.keys(key) : "";
      },
      parseRow(name) {
        let o = this.searchResult;
        return o && typeof o == "object" && name in o ? o[name] : [];
      }, 
        
      dragstart_handler(e){
        e.target.style.opacity = '0.4'; 
        e.dataTransfer.effectAllowed = 'all'; /*разрешенные события у драговера и энтера - значения е.dataTransfer.dropEffect */
        e.dataTransfer.setData('text',111);
        console.log(e.dataTransfer);
  //-> тащим иконку:
        let dragIcon = document.createElement('img');
        dragIcon.src = 'https://ru.seaicons.com/wp-content/uploads/2016/06/Files-Upload-File-icon.png';
        dragIcon.width = 100;
        e.dataTransfer.setDragImage(dragIcon, 0, 0);
      },

      dragend_handler(e,i){ //отпускаем в нужном месте, в "е" -- исходная(нужная) нода!
        e.target.style.opacity = '1'; 
        //e.target.classList.remove('over');
        this.over = false;
        this.delete_over(); // убираем бордюр 
        alert('перетащили -> '+i)
      },
      dragover_handler(e) {
        this.delete_over(); // убираем бордюр
        let t = e.target;
        if(t.classList.contains('tr')){
          t.classList.add('over')
          console.log(1);
        }
        else if(t.parentElement.classList.contains('tr')) {
          t.parentElement.classList.add('over');
          console.log(2);
        }
        else if(t.parentElement.parentElement.classList.contains('tr')){
          t.parentElement.parentElement.classList.add('over');
          console.log(3);
        }
        else if(t.parentElement.parentElement.parentElement.classList.contains('tr')){
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
.tr {
  display: flex;
  flex-direction: row;
  & > div {
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
