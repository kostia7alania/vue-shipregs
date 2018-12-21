
<template>
<!-- :on-change="selectHandler" -->
  <v-select
    class="my-select"
    v-model="localVal" 
    :searchable="true"
    :options="options"
    label="text"
  >
    <span slot="no-options">Нет результатов...</span>
    <!--<template slot="option" slot-scope="option">
      <b-row class="justify-content-md-center">
        <b-col>
          {{ option.text }}
          <b-badge pill variant="success">123</b-badge> 
        </b-col>
      </b-row>
    </template>-->
    
  </v-select>
</template>

<script>
export default {
  props: ["options","value"], // text,value
  name: "my-select",
  data() {
    return {
      localVal: null,
      options2: [
        {
          id: 0,
          class: "a1",
          title: "Бизнес",
          icon: "http://lorempixel.com/200/400/",
          desc: "Описние2", 
        },
        {
          id: 1,
          class: "a2",
          title: "Премиум",
          icon: "http://lorempixel.com/200/400/",
          desc: "Описание ", 
        }
      ]
    };
  },
  mounted() {},
  computed: {},
  watch: {
    localVal(e){
      console.log('localVal=>',arguments)
      this.$emit("input", e?e.value:e)
    }
  },
  methods: {
    selectHandler(e) {
      console.log(this.localVal)
      /*
      console.log('value ДО',this.value,'val=',e?e.value:e)

      this.$emit("input", e?e.value:e);
      console.log('value ПОСЛЕ',this.value)*/
    }
  }
};
</script>

<style lang="scss">
img {
  height: auto;
  max-width: 2.5rem;
  margin-right: 1rem;
}
.my-select {
  width: 100%;
  button.clear {
    display: none;
  }
}
</style>
