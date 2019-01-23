
<template>
  <span class="input-date">
    <vue-pikaday 
      readonly
      v-model.lazy="val_comp" 
      :options="options"
      v-p-visible="visible"/>
    <!--:options="{format:'DD.MM.YYYY'}"-->
    <transition-group name="list-complete">
      <img 
        :key="1"
        v-if="visible"
        @click="visible=!visible" 
        class="delete_img"
        :src="del_img"
      >
      <img :key="2" v-else @click="visible=!visible" :src="calendar_img">
    </transition-group>

    <!-- <date-picker width="100%"
                   :lang="'ru'" :format="date_mask" 
                   :value="value"
                   @input="input_handler"
                   type="text"
                   :disabled="disabled"
    :first-day-of-week="1"></date-picker>-->
  </span>
</template>

<script>
export default {
  props: {
    value: {
      type: null,
      default: () => null
    }
  },
  name: "input-date",
  data() {
    return { 
      del_img: require('@/img/delete.png'),
      calendar_img: require('@/img/calendar.png'),
      visible: false,
      val: null,
      options: {
        // опции тут: https://github.com/Pikaday/Pikaday#configuration и  https://github.com/Pikaday/Pikaday
        format: "DD.MM.YYYY",
        maxDate: new Date(),
        firstDay: 1,
        showWeekNumber: true,
        i18n: {
          previousMonth: "Предыдущий месяц",
          nextMonth: "Следующий месяц",
          months: [
            "Январь",
            "Февраль",
            "Март",
            "Апрель",
            "Май",
            "Июнь",
            "Июль",
            "Август",
            "Сентябрь",
            "Октябрь",
            "Ноябрь",
            "Декабрь"
          ],
          weekdays: [
            "Воскресенье",
            "Понедельник",
            "Вторник",
            "Среда",
            "Четверг",
            "Пятница",
            "Суббота"
          ],
          weekdaysShort: ["Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб"]
        }
      }
    };
  },
  mounted() {
 //   console.log('ДО',this.value)
    this.val_comp = new Date();
    this.$emit('input',this.val_comp)
    this.$nextTick( () => {
 //     console.log('ПОСЛЕ',this.value)
    }) ;
  },
  computed: {
    val_comp: {
      get() {
        return this.val 
      },
      set(e) { 
  //      console.log('set',e)
        this.val = e;
        if(!e) this.$emit("input", e); 
        else this.$emit('input', `${e.getDate()}.${(e.getMonth())+1}.${e.getFullYear()}`)
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

.input-date {
  width: 100%;
  display: flex;
}
.input-date,
input {
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
  cursor: pointer;
  padding-left: 5px;
  transition: 0.2s;
}
img:hover {
  transform: scale(1.1);
}
</style>
