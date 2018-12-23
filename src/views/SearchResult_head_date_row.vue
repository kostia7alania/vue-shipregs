<template>
      <div class="tr data-row">
        <div class="font-weight-bold first-colimn"><div>{{row_i+1}}</div></div>
        <div>{{row.rShipName}} ({{row.Length}})</div>
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
            <b-button v-if="!inport" @click="$emit('actions_handlers', {action: 'toDraft', data: row})">V</b-button>
            <b-button v-if="!inport" @click="$emit('actions_handlers', {action: 'edit', data: row})">O</b-button>
            <img v-if="inport" @click="$emit('actions_handlers', {action: 'toProd', data: row})" class="icons-width" src="../img/adding.png">
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
  methods: { }
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
