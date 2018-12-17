<template>
    <b-container class="search-panel"> 

    <b-row class="search-filters">  
      
      <b-col md="6" class="my-1 ed_DateFrom">
        <b-form-group horizontal label="Дата, с:" class="mb-0">
          <b-input-group> 
            <input-date v-model="ed_DateFrom"/>
          </b-input-group>
        </b-form-group>
      </b-col>

      <b-col md="6" class="my-1 timeFrom">
        <b-form-group horizontal label="Время, с:" class="mb-0 legends">
          <b-input-group>
           <input-time v-model="timeFrom"/>
          </b-input-group>
        </b-form-group>
      </b-col>


      <b-col md="6" class="my-1 ed_Port">
        <b-form-group horizontal label="Порт" class="mb-0">
          <b-input-group> 
          <b-form-select v-model="ed_Port" :options="ports" class="mb-3" >
          </b-form-select> 
          </b-input-group>
        </b-form-group>
      </b-col>
 
 
      <b-col md="6" class="my-1 timeTo">
        <b-form-group horizontal label="Время, по:" class="mb-0">
          <b-input-group>
           <input-time v-model="timeTo"/>
          </b-input-group>
        </b-form-group>
      </b-col>
      

      <b-col md="12" class="my-0 graf_refresh"> 
         <b-input-group> 
            <b-button horizontal variant="success" @click="$emit('graf_refresh',$data)">Перестроить</b-button>
          </b-input-group> 
       </b-col>
    </b-row>
 
     
    
    </b-container>
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
      timeFrom: {HH:"00", mm:"00"},
      timeTo: {HH:"23", mm:"59"},
      ports: ports
    };
  }
};
</script>

 <style>
  .legends{ display: contents !important; }
 </style>
<style scoped>
.search-panel {
  padding:33px !important;
  margin:10px;
  text-align:center;
}

@media (max-width: 767px) {
  .graf_refresh {order: 5; }
  .timeTo { order: 4; }
  .timeFrom { order: 3; }
  .ed_Port { order: 2; }
  .ed_DateFrom { order: 1;}
}
.search-panel {
   /*min-width: 1500px;*/
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.search-panel>div {
    display: flex;
    align-items: center;
    
    justify-content: center; 
    width: 100%; 
}
</style>
