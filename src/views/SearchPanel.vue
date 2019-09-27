<template>
  <div class="search-panel">

    <b-row class="search-filters">

      <b-col md="12">
        <b-row  class="search-filters">
          <b-col md="6" class="my-1 ed_DateFrom">
            <b-form-group label-cols label="Дата, с:" class="mb-0">
              <b-input-group>
                <input-date @input="input_handler($event,'ed_DateFrom')" :value="PARAMS.ed_DateFrom"/>
              </b-input-group>
            </b-form-group>
          </b-col>

          <b-col md="6"  class="my-1 timeFrom">
            <b-form-group align-items="center" label-cols label="Время, с:" class="mb-0 legends">
              <b-input-group>
                <input-time @input="input_handler($event,'timeFrom')" :value="PARAMS.timeFrom"/>
              </b-input-group>
            </b-form-group>
          </b-col>

          <b-col md="6" class="my-1 ed_Port">
            <b-form-group label-cols label="Порт" class="mb-0">
              <b-input-group>
                <my-select
                  :items="PORTS"
                  :value="PARAMS.ed_Port"
                  @input="input_handler($event,'ed_Port')"
                />
              </b-input-group>
            </b-form-group>
          </b-col>

          <b-col md="6" class="my-1 timeTo">
            <b-form-group label-cols label="Время, по:" class="mb-0">
              <b-input-group>
                <input-time @input="input_handler($event,'timeTo')" :value="PARAMS.timeTo"/>
              </b-input-group>
            </b-form-group>
          </b-col>


          <b-col md="6" class="my-1 ed_Port">
            <b-form-group label-cols label="Группировать" class="mb-0">
              <b-input-group>
                <my-select
                  :items="DICTIONARY_TYPE_PORT_PLACE"
                  :value="PARAMS.type_port_place"
                  @input="input_handler($event,'type_port_place')"
                />
              </b-input-group>
            </b-form-group>
          </b-col>

      <b-col class="btn-actions" offset-md="1" align-self="center" md="5" sm='12'>
        <b-row align-v="center" class="search-filters">
              <b-col  class="btn-to-request pl-0 pr-0">
                <b-button
                  :disabled="is_disabled_button"
                  @click="GET_ITEMS" class="mb-1" size="sm"
                  :class="{disabled: is_disabled_button, 'btn-gray-dark': !btn_clicked,'btn-success': btn_clicked}"
                  horizontal
                  v-b-popover.hover="LOADING && 'Загрузка' || btn_clicked&&'Данные актуальны'||'Получить данные'"
                >

                    <span v-if="LOADING">
                      <img :src="loading_img" class="icons-width">
                      Загрузка  &nbsp; <b-badge variant="primary"> <animateNumber :value="counts_all"/> </b-badge>
                    </span>

                     <span v-else>
                        <img :src="loading_static_img" class="icons-width">
                        Перестроить  &nbsp;
                        <b-badge variant="primary"> <animateNumber :value="counts_all"/> </b-badge>
                    </span>

                </b-button>
              </b-col>

              <b-col md="1" xs="1" class="btn-to-export pl-0 pr-0">
                <b-button variant="outline-success" size="sm" class="mb-1" :class="{disabled: LOADING}" @click="TO_EXPORT">
                  <span v-b-popover.hover="'Данное действие экспортирует в Excel отчет по текущим выбранным параметрам формы'" title="Экспорт в Excel">
                    <img :src="excel_img" class="icons-width">
                  </span>
                </b-button>
               </b-col>
        </b-row>
      </b-col>


        </b-row>
      </b-col>


    </b-row>

  </div>
</template>

<script>
export default {
  components: {
    "input-date": () => import("../components/input-date.vue"),
    "input-time": () => import("../components/input-time.vue"),
    "my-select": () => import("../components/my-select.vue")
  },

  name: "search-panel",

  data() {
    return {
      loading_img: require("@/img/loading.gif"),
      loading_static_img: require("@/img/loading_static.png"),
      excel_img: require("@/img/excel.png"),
      telegram_img: require("@/img/telegram.png"),
      btn_clicked: false
    };
  },
  computed: {
    params_is_valid() {
      return this.$store.getters["searchPanel/params_is_valid"];
    },
    counts_all() {
      return this.$store.getters["items/COUNT_MENU_ITEMS"];
    },
    PARAMS() {
      return this.$store.state.searchPanel.PARAMS;
    },
    is_disabled_button() {
      return this.LOADING || !this.params_is_valid;
    },
    LOADING() {
      return this.$store.state.items.LOADING;
    },
    PORTS() {
      return this.$store.state.searchPanel.PORTS;
    },
    DICTIONARY_TYPE_PORT_PLACE() {
      return this.$store.state.searchPanel.DICTIONARY_TYPE_PORT_PLACE;
    }
  },
  methods: {
    input_handler(val, key) {
      this.$store.commit("searchPanel/SET_PARAM", { val, key });
      if (!this.btn_clicked) return;
      this.GET_ITEMS();
    },
    TO_EXPORT() {
      if (this.LOADING) return;
      this.btn_clicked = true;
      this.$store.dispatch("items/GET_ITEMS", { action: "to-export" });
    },
    GET_ITEMS() {
      if (this.LOADING) return;
      this.btn_clicked = true;
      this.$store.dispatch("items/GET_ITEMS");
    }
  }
};
</script>

 <style scope lang="scss">
.search-filters {
  align-items: center;

  .btn-to-export {
    background: transparent;
    width: 50px;
  }
  .btn-to-request {
    button {
      width: 100%;
    }
  }
}
.disabled {
  color: red;
}
</style>