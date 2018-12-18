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
              <b-button :class="{disabled: btn_clicked, 'btn-success': !btn_clicked,'btn-gray-dark': btn_clicked} " horizontal @click="btn_clicked_handler">
                <span v-if="btn_clicked"
                    v-b-popover.hover="'Теперь мы автоматически обновляем данные'" title="Данные актуальны"
                ><img src="../img/loading.gif" class="icons-width"> Живые данные</span> 
                <span v-else > <img src="../img/loading_static.png" class="icons-width"> Перестроить</span>                 
              </b-button>
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
  methods: {
    input_handler(data, prop) {
      console.log(arguments);
      this[prop] = data;
      this.get_data();
    },
    btn_clicked_handler() {
      this.btn_clicked = true;
      this.get_data();
    },
    get_data() {
      if (!this.btn_clicked) return;
      if (this.interval_id) clearInterval(this.interval_id);
      let that = this;
      this.interval_id = setInterval(e => that.graf_refresh("getInport"), 5000);
      this.graf_refresh("getUsers");
      this.graf_refresh("getInport");
    },
    graf_refresh(action) {
      console.log("graf_refresh=>", action);
      this.$emit("graf_refresh", { data: this.$data, action: action });
    }
  }
};
</script>

 <style>  
 .icons-width {
   width:30px;
 }
 .disabled {
   cursor: no-drop;
 }
 legend {
    min-width: 67px;
}
.legends {
  display: contents !important;
}
</style>
<style  >
.search-panel {
  padding: 33px !important;
  margin: 10px;
  text-align: center;
}

@media (max-width: 900px) {
  legend {
    text-align: left !important;
  }
  .btn {
    flex:10;
  }
  .graf_refresh {
    order: 5;
  }
  .timeTo {
    order: 4;
  }
  .timeFrom {
    order: 3;
  }
  .ed_Port {
    order: 2;
  }
  .ed_DateFrom {
    order: 1;
  }
}
.search-panel {
  /*min-width: 1500px;
    display: flex;
    justify-content: space-between;
    align-items: center;*/
}
.search-panel > div {
  /* display: flex;
    align-items: center;
    
    justify-content: center; 
    width: 100%; */
}
</style>
