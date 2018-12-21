<template>
  <animated-number
    :value="value"
    :formatValue="formatToPrice"
    :duration="300"
    :translateX="[100, 200]"
    :round="1"
  />
</template>
<script>
import AnimatedNumber from "animated-number-vue";

export default {
  components: {AnimatedNumber},
  props: {
    isTime:{
      type: [Number,String,Boolean],
      default: () => false
    },
    value: {
      type: [Number, String],
      default: () => 0
    }
  },
  data() {
    return { };
  },
  methods: {
    formatToPrice(value) {
      //return value;
      let t = this.isTime;
      let out;
      if(value === null || isNaN(parseInt(value))) out = value;
      else if(t && value >= 0 && value < 10 ) out = `0${value.toFixed(0)}`;
      else out = `${value.toFixed(0)}`;
      console.log('value=>',value, 'out=>',out);
      return out;
    }
  }
};
</script>