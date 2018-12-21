<template>
  <div id="search-header" v-if="data">
    <h1>График</h1>
    <h2>Расстановки и движения судов 
      <transition name="component-fade">
        <span v-if="data.ed_Port">в морском порту</span>
      </transition>
      <p v-if="data.ed_Port" class="css-typing" >{{getPORT}}</p> 
         
      <p class="css-typing" v-if="!data.ed_Port">во всех морских портах</p>
      
    
    </h2>
    <h6 class="first-h6"> с <animateNumber :value="data.timeFrom.HH" :isTime="true"/>:<animateNumber :value="data.timeFrom.mm" :isTime="true"/> <!--{{data.ed_DateFrom}}--> &nbsp; <animateNumber :value="compDate(0)"  :isTime="true"/>.<animateNumber :value="compDate(1)"  :isTime="true"/>.<animateNumber :value="compDate(2)"/></h6>
    <h6 class="second-h6">по <animateNumber :value="data.timeTo.HH" :isTime="true"/>:<animateNumber :value="data.timeTo.mm" :isTime="true"/>  <!--{{getTODAY}}-->       &nbsp;   <animateNumber :value="new Date().getDate()"  :isTime="true"/>.<animateNumber :value="new Date().getMonth()+1"  :isTime="true"/>.<animateNumber :value="new Date().getFullYear()"/></h6>
    
    
  </div>
</template>

<script> 
export default {
    name: "search-header", 
    props: ["data"],
    data() {
      return {} 
    },
    computed: {
      getPORT(){
        let p = this.data.ed_Port;
        let res = this.data.ports.filter(e=>e.value==p);
        return res.length>0?res[0].text:false;
      },
      getTODAY(){
        let n = new Date();
        return `${new Date().getDate()}.${n.getMonth()+1}.${n.getFullYear()}`
      }
    }, 
    methods: { 
      compDate(num){
        let d = this.data
        if(typeof d === 'object' && 'ed_DateFrom' in d && typeof d.ed_DateFrom == 'string') return d.ed_DateFrom.split('.')[num];
        else return '';        
      }
     }
  };
</script>
 

<style lang="scss">
.first-h6 {
  padding-left: 7px;
}
  

.css-typing
{
    width: 30em;
    white-space:nowrap;
    overflow: hidden;
    -webkit-animation: type 5s steps(50, end);
    animation: type 5s steps(50, end);
}
 
@keyframes type{
    from { width: 0; }
}
 
@-webkit-keyframes type{
    from { width: 0; }
}
 
.component-fade-enter-active{
  transition: all .3s ease;
}
.component-fade-leave-active {
  transition: opacity .3s ease; 
  transition: all .2s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}
.component-fade-enter, .component-fade-leave-to
/* .component-fade-leave-active до версии 2.1.8 */ {
  transform: translateX(10px);
  opacity: 0;
}


h2 { 
    display: flex; 
    flex-direction: column;
    align-items: center; 
}
</style>
