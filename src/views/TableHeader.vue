<template>
  <div class="tr tr-th tr-th-main">
    <div
      v-for="(ff,i) in FIELDS"
      :key="ff"
      :class="{
        
                'first-colimn':i==0,

                'actions-colimn':i==FIELDS.length-1,

                'ShipOwner': ff=='Судовладелец'

              }"
    >{{ff}}</div>
  </div>
</template>

<script> 

export default { 
  name: "table-header", 
  data() {
    return {
      FIELDS: [
        "N пп",
        "Название судна",
        "Длина",
        "IMO",
        "Тип судна",
        "Судовладелец",
        "Флаг",
        "DWT",
        "Осадка",
        "Надводный габарит",
        "Время начала движ.",
        "Маршрут",
        "Причал/якорная стоянка",
        "Агентская компания",
        "Лоцм. обеспечение",
        "Груз",
        "Примечание",
        "Действия"
      ], 
    };
  }, 
};
</script>

 