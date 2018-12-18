
<template>  
  <span class="input-date">  
     <vue-pikaday  
        :value="value" 
        @change="change_handler($event)"
        :options="{format:'DD.MM.YYYY'}"
        v-p-visible="visible"
      />
      <transition-group name="list-complete">
        <img :key=1 v-if="value" @click="$emit( 'input', null );" class="delete_img" src="../img/delete.png">
        <img :key=2 v-else @click="visible=!visible" src="../img/calendar.png">
     </transition-group>
      
<!-- <date-picker width="100%"
                   :lang="'ru'" :format="date_mask" 
                   :value="value"
                   @input="input_handler"
                   type="text"
                   :disabled="disabled"
                  :first-day-of-week="1"></date-picker> -->
  </span>  
</template>

<script>  
export default {  
  props: {  
       value: { 
       }
     }, 
  name: "input-date", 
  data() { return {visible: false } },
  methods:{  
    change_handler(e){  
      let j = e.target.value;
      console.log( '==========',j, e,new Date(j)  )
      if( j && !isNaN( new Date(j) ) ) {
        this.$emit( 'input', j ); 
      } else {
        console.log('else emit to date -> NULL!!')
        this.$emit('input',null);
      }
     }
  } 
};
</script>

<style scoped >

.list-complete-enter, .list-complete-leave-to
/* .list-complete-leave-active до версии 2.1.8 */ {
  opacity: 0;
  transform: translateY(30px);
}
.list-complete-leave-active {
  position: absolute;
}

span.input-date span {
    /*padding-top: 5px;*/
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
