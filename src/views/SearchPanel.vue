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
                <b-form-select
                  @input="input_handler($event,'ed_Port')"
                  :value="ed_Port"
                  :options="ports"
                  class="mb-0"
                ></b-form-select>
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
              <b-button @click="btn_clicked_handler('getUsers')" class="mb-2" size="sm"  :class="{disabled: btn_clicked, 'btn-success': !btn_clicked,'btn-gray-dark': btn_clicked} " horizontal >
                <span v-if="btn_clicked" v-b-popover.hover="'Теперь мы автоматически обновляем данные'" title="Данные актуальны">
                  <img src="../img/loading.gif" class="icons-width">
                  Живые данные  &nbsp; 
                  <b-badge variant="primary">
                    <animateNumber :value="counts_all"/>
                  </b-badge>
                  </span> 
                <span v-else > 
                  <img src="../img/loading_static.png" class="icons-width"> 
                  Перестроить 
                </span>                 
              </b-button>
              </b-col>
              <b-col>
              <b-button v-if="btn_clicked" variant="outline-success" size="sm" class="mb-3" @click="btn_clicked_handler('toExport')">
                <span> 
                  <img src="../img/excel.png" class="icons-width"> 
                  Экспорт 
                </span>
              </b-button>
              </b-col>
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
import { ports } from "../assets/ports.js";

export default {
  components: { "input-date": inputDate, "input-time": inputTime },
  name: "search-panel",
  props:['counts_all'],
  data() {
    return {
      ed_Port: null,
      ed_DateFrom: null,
      timeFrom: { HH: "15", mm: "00" },
      timeTo: { HH: "15", mm: "00" },
      ports: ports,
      interval_id: null,
      btn_clicked: false
    };
  },
  mounted(){
    this.$emit('emit_data',this.$data);
  },
  methods: {
    input_handler(data, prop) {
      console.log(arguments);
      this[prop] = data;
      this.get_data('getUsers');
    },
    btn_clicked_handler(e) {
      this.btn_clicked = true;
      this.get_data(e);
    },
    get_data(e) {
      if (!this.btn_clicked) return;
      if (this.interval_id) clearInterval(this.interval_id);
      this.interval_id = setInterval(e => this.refresh_emit(), 5000);
      this.refresh_emit(e);
    },
    refresh_emit(e){
      this.$emit("graf_refresh", { data: this.$data, action: e } );
    }
  }
};
</script>

 <style scoped lang="scss">

 </style>