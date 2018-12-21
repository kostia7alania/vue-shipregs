
<template>  
     <VueTimepicker hide-clear-button class="input-time" v-model="timeValue" @change="$emit('input',timeValue)" />  
</template>

<script>  

import VueTimepicker from 'vue2-timepicker'
export default {  
  name: "input-time", 
  components:{VueTimepicker},
  props: { value: { type: null, default: () => '' }       }, 
  data() { 
    return { 
      timeValue: {  HH: null, mm: null }
      }
  },
  mounted(){
    this.timeValue = this.value;
  }
};
</script>
<style>
.input-time,
.time-picker input.display-time {
  width:100% !important;
  min-width: 50px;
}
select,
.input-date *,
.time-picker *:not(.time-picker-overlay){
  cursor:pointer;
}
</style>
<style scoped >
.list-complete-enter, .list-complete-leave-to
/* .list-complete-leave-active до версии 2.1.8 */ {
  opacity: 0;
  transform: translateY(30px);
}
.list-complete-leave-active {
  position: absolute;
}

span.input-time span {
    padding-top: 5px;
}

  .input-date {  width: 100%;  display: flex;  }
  .input-date,input {
    flex: 10; 
    display: flex; 
    width: 100%;
  }

  span.input-date {
    align-items: center;
  }

img {
  width: 25px !important;
  height: 25px !important;
  cursor:pointer;
  padding-left:5px;
  transition:0.2s;
}
img:hover{
  transform: scale(1.1);
}
  
</style>
