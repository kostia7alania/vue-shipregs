<template>

  <div>
      <!-- содержимое разделов-->
      <res-head-date 
        v-for="(array_in_date, section_date) in items"
        :key="section_date" 
        :array_in_date="array_in_date"
        :menu_index="menu_index"
        :class="{ height0: !show}"
        :isDraft="isDraft"
      />
       <div v-if="array_in_date.arr.length==0" :class="{ height0: !show}">Нет элементов для отображения!</div>
  </div>

</template>

<script> 

export default {
  components: {
    "res-head-date":()=>import("./SearchResult_head_date")
  },
  name: "search-result-head",
  props: ["el", "isDraft", 'class'],
  data() {
    return { 
    };
  },
  computed: { 
  },
  watch: {},
  updated() {},
  beforeDestroy() {},
  methods: { 
  }
};
</script>


<style lang="scss">
</style>
