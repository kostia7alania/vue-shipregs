<template>
      <div class="tr data-row">
        <div class="font-weight-bold first-colimn"> {{row_i+1}} </div>
        <div>
          <a href="#" @click="goShipById_handler(row)"> {{row.rShipName}}</a>
        </div>
        <div><b>{{row.Length}}</b></div><!-- new 2.6.19-->
        <div>{{row.IMO}}</div>
        <div>{{row.ShipTypeNameRus}}</div>
        <div class="ShipOwner">
          <p v-for="el in ShipOwnerComputed" :key="el.Company">{{el.Company}}</p>
        </div><!-- new 2.6.19-->
        <div>{{row.CountryNameRus}}</div>
        <div>{{row.DWT}}</div><!-- new 2.6.19-->
        <div>{{row.DepositStern}}</div>
        <div>{{row.SurfaceDimension}}</div>
        <div>{{row.HourMinute}}</div>
        <div>{{row.Route}}</div>
        <div>{{row.Terminal}}</div>
        <div>{{row.CompanyName}}</div>
        <div>{{row.NeedForEmerg}}</div>
        <div>
          <p v-if="row.Enter_Cargo">Грузы: <span v-html="row.Enter_Cargo"></span></p>
          <p v-if="row.Enter_Cargo_Danger">Опасные грузы: <span v-html="row.Enter_Cargo_Danger"></span></p>
        </div>
        <div>{{row.Note}}</div>
        <div class="actions-colimn">
          <div>
            <b-button v-if="!isDraft" @click="to_draft">
              <span v-b-popover.hover="'Данное действие перенесет запись в черновики'" title="В черновики">
              ↓
              </span>
            </b-button>
            <!--<b-button v-if="!isDraft" @click="$emit('actions_handlers', {action: 'edit', data: row})">O</b-button>-->
              <b-button v-if="isDraft" @click="to_prod">
              <span v-b-popover.hover="'Данное действие перенесет запись из черновика'" title="Из черновиков">
               ↑ <!-- <img class="icons-width" src="../img/adding.png">-->
              </span>
            </b-button>
          </div>
        </div>
      </div>
</template>

<script>
import { mapActions } from "vuex";
export default {
  name: "search-result-head-date-row",
  props: ["row", "row_i", "isDraft"],
  data() {
    return {};
  },
  computed: {
    ShipOwnerComputed() {
      const s = this.row.ShipOwner;
      if (typeof s == "string" && s.trim().length) {
        return JSON.parse(s);
      }
      return [];
    }
  },
  beforeDestroy() {},
  methods: { 
    to_prod() {
      this.$store.dispatch("items/TRANSFER_ITEMS", { action: "to-prod", row: this.row } )
    },
    to_draft() {
      this.$store.dispatch("items/TRANSFER_ITEMS", { action: "to-draft", row: this.row } )
    },
    goShipById_handler(e) {
      //console.log('shipID->',e.ShipID);
      (window.top &&
        window.top.goShipByID &&
        window.top.goShipByID(e.ShipID, 2)) ||
        console.warn("не объявлена глобальная функция window.top.goShipByID");
      //http://window.top.goShipById('shipId',2)
    },
    actions_row_handler({ action, data }) {
      //   console.log('0---actions_row_handler=>',arguments,data.EntID )
      this.$emit("actions_handlers", { action, data: data });
      this.$nextTick(() => this.$forceUpdate());
    }
  }
};
</script>


<style lang="scss">
.first-colimn { max-width: 44px; }
.first-colimn, .actions-colimn { align-items: center; }
.actions-colimn { max-width: 80px; }
</style>
