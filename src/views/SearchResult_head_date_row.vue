<template>
      <div class="tr data-row">
        <div class="font-weight-bold first-colimn"> {{row_i+1}} </div>
        <div>
          <a href="#" @click="goShipById_handler(row)"> {{row.rShipName}} ({{row.Length}}) </a>
        </div>
        <div>{{row.IMO}}</div>
        <div>{{row.ShipTypeNameRus}}</div>
        <div>{{row.CountryNameRus}}</div>
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
            <b-button v-if="!inport" @click="actions_row_handler({action: 'toDraft', data: row})">
              <span v-b-popover.hover="'Данное действие перенесет запись в черновики'" title="В черновики">
              ↓
              </span> 
            </b-button>
            <!--<b-button v-if="!inport" @click="$emit('actions_handlers', {action: 'edit', data: row})">O</b-button>-->
              <b-button v-if="inport" @click="actions_row_handler({action: 'toProd', data: row})">
              <span v-b-popover.hover="'Данное действие перенесет запись из черновика'" title="Из черновиков">
               ↑ <!-- <img class="icons-width" src="../img/adding.png">-->
              </span> 
            </b-button> 
          </div>
        </div>
      </div> 
</template>

<script>

export default {
  name: "search-result-head-date-row",
  props: ['row', 'row_i', 'inport'],
  data() {
    return {};
  },
  computed: { 
  },
  watch: {},
  mounted() {},
  updated() {},
  beforeDestroy() {},
  methods: {
    goShipById_handler(e){
      //console.log('shipID->',e.ShipID);
      window.top.goShipByID(e.ShipID,2);
      //http://window.top.goShipById('shipId',2)
    },
    actions_row_handler({action, data}){
   //   console.log('0---actions_row_handler=>',arguments,data.EntID )
      this.$emit('actions_handlers', {action: action, data: data});
      this.$nextTick ( () => this.$forceUpdate() );
    }
   }
};
</script>
 

<style lang="scss">
.first-colimn { 
  max-width: 44px;
}
.actions-colimn { 
  max-width: 80px;
} 
  .first-colimn,
  .actions-colimn { 
    align-items: center;
  } 
</style>
