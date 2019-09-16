
<template> 
  <v-select
    class="my-select"
    v-model="localVal"
    :searchable="true"
    :options="items"
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
  components: { vSelect : ()=>import("vue-select")},
  props: ["items", "value",], // text,value
  name: "my-select",
  data() {
    return {  
    };
  },
  mounted() {
    this.$nextTick(() => {
      this.localVal = this.items.filter(e => e.value == this.value)[0];
    });
  }, 
  computed: { 
    localVal: {
      get() {
        return this.text
      },
      set(e) {
        this.$emit("input", e instanceof Object ? e.value : e);
      }
    }
  }  
};
</script>

<style lang="scss">

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
