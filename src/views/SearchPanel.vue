<template>
  <div class="search-panel">

    <b-row class="search-filters">

      <b-col md="9">
        <b-row  class="search-filters">
          <b-col md="6" class="my-1 ed_DateFrom">
            <b-form-group horizontal label="Дата, с:" class="mb-0">
              <b-input-group>
                <input-date @input="input_handler($event,'ed_DateFrom')" :value="ed_DateFrom"/>
              </b-input-group>
            </b-form-group>
          </b-col>

          <b-col md="6"  class="my-1 timeFrom">
            <b-form-group align-items="center" horizontal label="Время, с:" class="mb-0 legends">
              <b-input-group>
                <input-time @input="input_handler($event,'timeFrom')" v-model="timeFrom"/>
              </b-input-group>
            </b-form-group>
          </b-col>

          <b-col md="6" class="my-1 ed_Port">
            <b-form-group horizontal label="Порт" class="mb-0">
              <b-input-group>
<!--                <b-form-select
                  @input="input_handler($event,'ed_Port')"
                  :value="ed_Port"
                  :options="ports"
                  class="mb-0"
                ></b-form-select>
            -->    
            <mySelect  
                  v-if="ports"
                  @input="input_handler($event,'ed_Port')"
                  :value="ed_Port"
                  :ports="ports"
                  :options="ports"
                  />

              </b-input-group>
            </b-form-group>
          </b-col>

          <b-col md="6" class="my-1 timeTo">
            <b-form-group horizontal label="Время, по:" class="mb-0">
              <b-input-group>
                <input-time @input="input_handler($event,'timeTo')" :value="timeTo"/>
              </b-input-group>
            </b-form-group>
          </b-col>
        </b-row>
      </b-col>

      <b-col  align-self="center" md="3">
        <b-row class="search-filters">
          <b-col md="12" class="graf_refresh">
            <b-input-group>
              <b-col>

              <b-button @click="btn_clicked_handler({action:'getUsers'})" class="mb-1" size="sm"  :class="{disabled: loading, 'btn-gray-dark': !btn_clicked,'btn-success': btn_clicked}" horizontal >
                  <span v-if="btn_clicked && 0" v-b-popover.hover="'Теперь мы автоматически обновляем данные'" title="Данные актуальны">
                    <img :src="loading_img" class="icons-width">
                    Живые данные  &nbsp; <b-badge variant="primary"> <animateNumber :value="counts_all"/> </b-badge>
                  </span>
                <template v-else >
                  <span v-if="loading" v-b-popover.hover="'Подождите, мы обновляем данные...'" title="Загрузка">
                    <img :src="loading_img" class="icons-width">
                    Загрузка  &nbsp; <b-badge variant="primary"> <animateNumber :value="counts_all"/> </b-badge>
                  </span>
                  <span  v-else >
                    <img :src="loading_static_img" class="icons-width"> 
                    Перестроить  &nbsp; <b-badge variant="primary"> <animateNumber :value="counts_all"/> </b-badge>
                   </span>
                </template>                 
              </b-button>
 

              </b-col>

              <b-col>
              <b-button v-if="btn_clicked" variant="outline-success" size="sm" class="mb-1" :class="{disabled: loading}" @click="btn_clicked_handler({action:'toExport'})">
                <span v-b-popover.hover="'Данное действие экспортирует в Excel отчет по текущим выбранным параметрам формы'" title="Экспорт в Excel"> 
                  <img :src="excel_img" class="icons-width"> 
                  Экспорт 
                </span>
              </b-button>
              </b-col>

               <!--
              <b-col>
              <b-button v-if="btn_clicked" variant="outline-success" size="sm" class="mb-1" :class="{disabled: loading}" @click="btn_clicked_handler({action:'toSend'})">
                <span v-b-popover.hover="'Данное действие отправит суточный график на сервер'" title="Суточный график"> 
                  <img :src="telegram_img" class="icons-width"> 
                  Суточный график 
                </span>
              </b-button>
              </b-col>
              -->

            </b-input-group>
          </b-col>
        </b-row>
      </b-col>

    </b-row>

  </div>
</template>

<script>
import inputDate from "../components/input-date.vue";
import inputTime from "../components/input-time.vue";

import mySelect from "../components/my-select.vue"; 
 
export default {
  components: { "input-date": inputDate, "input-time": inputTime, mySelect },
  name: "search-panel",
  props:['counts_all', 'loading', 'ports'],
  data() {
    return {
      loading_img: require('@/img/loading.gif'),
      loading_static_img: require('@/img/loading_static.png'),
      excel_img: require('@/img/excel.png'),
      telegram_img: require('@/img/telegram.png'),
      ed_Port: 'RUAZO',
      ed_DateFrom: null,
      timeFrom: { HH: "15", mm: "00" },
      timeTo: { HH: "15", mm: "00" }, 
      interval_id: null,
      btn_clicked: false
    };
  },
  watch:{
    ports(){
      let ps = this.ports;
      if(ps instanceof Array) { 
        this.input_handler(ps[0].value,'ed_Port')//первый элемент из списка ПОРТОВ всегда автоматом селектитьСЯ будет
     //   alert(ps[1].value)
        this.$forceUpdate();        
      }
    }
  },
  mounted(){
    this.$emit('emit_data',this.$data);
  },
  methods: {
    input_handler(data, prop) {
    ///  console.log(arguments);
      this[prop] = data;
      this.get_data( {action:'getUsers'} );
    },
    btn_clicked_handler(obj) {
      if(this.loading) return;
      this.btn_clicked = true;
      this.get_data(obj);
    },
    get_data(obj) {
      if (!this.btn_clicked) return;
      if (this.interval_id) clearInterval(this.interval_id);
     // this.interval_id = setInterval(e => this.refresh_emit(), 5000);
      this.refresh_emit(obj);
    },
    refresh_emit(obj){
    //  console.warn('dddd', { ...this.$data, ...{ports: this.ports} });
      this.$emit("graf_refresh", { data: this.$data, ...obj, ...{ports: this.ports} } );
    }
  }
};
</script>

 <style   lang="scss">
.search-filters {
  .form-row {
    align-items: center;
  }
}
 </style>