
<template>

<div class="my-select-wrapper">

    <b-form-select 
      v-if="items.length"
      v-model="localVal" 
      :options="items" 
      size="xs"
      class="mt-3"
    />

   <!-- <v-select
      v-if="items.length"
      class="my-select"
      v-model="localVal"
      :searchable="true"
      :options="items"
      label="text"
      >
      <span slot="no-options">Нет результатов...</span>
     <! -- <template slot="option" slot-scope="option">
        <b-row class="justify-content-md-center">
          <b-col>
            {{ option.text }}
            <b-badge pill variant="success">123</b-badge>
          </b-col>
        </b-row>
      </template>
      -- >

    </v-select>-->
    <span v-else>
      Загрузка...
    </span>
  </div>
</template>

<script>
export default {
  components: { vSelect : ()=>import("vue-select")},
  props: ["items", "value",], // text,value
  name: "my-select",
  data() {
    return {  
      text: null
    };
  },
  watch: {
     value(neww) { this.init() },
     items() { this.init() }
  }, 
  computed: {
    localVal: {
      get() {
        return this.value
        /*if(!this.items || !this.items.length) return;
        const obj = this.items.filter( e => e.value == this.value )
        if(obj.length) return obj[0].text*/ 
      },
      set(e) { 
        this.$emit("input", e instanceof Object ? e.value : e);
      }
    }
  },
  methods: {
    init() {
    
     if(!this.value) this.localVal = this.items[0].value
    // debugger
      /*const obj = this.items.filter( e => e.value == this.value )[0]
      if(typeof obj == 'object') this.text = obj.text
      return this.text*/
    }
  }
};
</script>

<style scope lang="scss">
.my-select-wrapper,
.my-select {
  width: 100%;
  button.clear {
    display: none;
  }
  img {
    height: auto;
    max-width: 2.5rem;
    margin-right: 1rem;
  }
  .vs__selected-options {
    flex-wrap: nowrap;
  }
} 
</style>
