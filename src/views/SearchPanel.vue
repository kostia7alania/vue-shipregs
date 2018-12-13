<template>
    <b-container fluid>
  <div class="search-panel">
    <div>Порт: <select v-model="ed_Port">
        <option value>все</option>
        <option value="RUAZO">RUAZO - Азов</option>
        <option value="RUSAK">RUSAK - Александровск-Сахалинский</option>
        <option value="RUAMD">RUAMD - Амдерма</option>
        <option value="RUDYR">RUDYR - Анадырь</option>
        <option value="RUAAQ">RUAAQ - Анапа</option>
        <option value="RUARH">RUARH - Архангельск</option>
        <option value="RUASF">RUASF - Астрахань</option>
        <option value="RUBEM">RUBEM - Беломорск</option>
        <option value="RUBER">RUBER - Беринговский</option>
        <option value="RUBKN">RUBKN - Большой Камень</option>
        <option value="RUBOS">RUBOS - Бошняково</option>
        <option value="RUVNN">RUVNN - Ванино</option>
        <option value="RUVAR">RUVAR - Варандей</option>
        <option value="RUVIT">RUVIT - Витино</option>
        <option value="RUVVO">RUVVO - Владивосток</option>
        <option value="RUVYP">RUVYP - Восточный</option>
        <option value="RUVYG">RUVYG - Выборг</option>
        <option value="RUVYS">RUVYS - Высоцк</option>
        <option value="RUGDZ">RUGDZ - Геленджик</option>
        <option value="RUDKA">RUDKA - Де-Кастри</option>
        <option value="RUDKS">RUDKS - Диксон</option>
        <option value="RUDUD">RUDUD - Дудинка</option>
        <option value="RUZKA">RUZKA - Евпатория-Каламитский залив</option>
        <option value="RUZKB">RUZKB - Евпатория-Озеро Донузлав</option>
        <option value="RUZKC">RUZKC - Евпатория-Озеро Панское</option>
        <option value="RUYEY">RUYEY - Ейск</option>
        <option value="RUZAR">RUZAR - Зарубино</option>
        <option value="RUIAA">RUIAA - Игарка</option>
        <option value="RUKZP">RUKZP - Кавказ</option>
        <option value="RUKGD">RUKGD - Калининград</option>
        <option value="RUKAN">RUKAN - Кандалакша</option>
        <option value="RUKEH">RUKEH - Керчь</option>
        <option value="RUKOR">RUKOR - Корсаков</option>
        <option value="RUKRB">RUKRB - Крабозаводск</option>
        <option value="RUKRS">RUKRS - Красногорск</option>
        <option value="RUKRO">RUKRO - Кронштадт</option>
        <option value="RUKUI">RUKUI - Курильск</option>
        <option value="RULOM">RULOM - Ломоносов</option>
        <option value="RUGDX">RUGDX - Магадан</option>
        <option value="RUMAL">RUMAL - Малокурильское</option>
        <option value="RUMCX">RUMCX - Махачкала</option>
        <option value="RUMEZ">RUMEZ - Мезень</option>
        <option value="RUMVO">RUMVO - Москальво</option>
        <option value="RUMMK">RUMMK - Мурманск</option>
        <option value="RUKMN">RUKMN - Мыс Каменный</option>
        <option value="RULAZ">RULAZ - Мыс Лазарева</option>
        <option value="RUNAB">RUNAB - Набиль</option>
        <option value="RUNNM">RUNNM - Нарьян-Мар</option>
        <option value="RUNJK">RUNJK - Находка</option>
        <option value="RUNJO">RUNJO - Находка-нефтепорт</option>
        <option value="RUNEV">RUNEV - Невельск</option>
        <option value="RUNIL">RUNIL - Неизвестен на момент выхода</option>
        <option value="RUNIA">RUNIA - Николаевск-на-Амуре</option>
        <option value="RUNVS">RUNVS - Новороссийск</option>
        <option value="RUOLB">RUOLB - Ольга</option>
        <option value="RUOYA">RUOYA - Оля</option>
        <option value="RUONG">RUONG - Онега</option>
        <option value="RUKOT">RUKOT - Остров Котельный</option>
        <option value="RUOHO">RUOHO - Охотск</option>
        <option value="RUPWE">RUPWE - Певек</option>
        <option value="RUPKC">RUPKC - Петропавловск-Камчатский</option>
        <option value="RUKPY">RUKPY - Петропавловск-Камчатский, участок Кировский</option>
        <option value="RUKRT">RUKRT - Петропавловск-Камчатский, участок Крутогорово</option>
        <option value="RUMAN">RUMAN - Петропавловск-Камчатский, участок Манилы</option>
        <option value="RUNIK">RUNIK - Петропавловск-Камчатский, участок Никольское</option>
        <option value="RUOZR">RUOZR - Петропавловск-Камчатский, участок Озерновский</option>
        <option value="RUOKB">RUOKB - Петропавловск-Камчатский, участок Октябрьский</option>
        <option value="RUOSS">RUOSS - Петропавловск-Камчатский, участок Оссора</option>
        <option value="RUPAL">RUPAL - Петропавловск-Камчатский, участок Палана</option>
        <option value="RUPAH">RUPAH - Петропавловск-Камчатский, участок Пахачи</option>
        <option value="RUTIG">RUTIG - Петропавловск-Камчатский, участок Тигиль</option>
        <option value="RUTIL">RUTIL - Петропавловск-Камчатский, участок Тиличики</option>
        <option value="RUUKK">RUUKK - Петропавловск-Камчатский, участок Усть-Камчатск</option>
        <option value="RUHRV">RUHRV - Петропавловск-Камчатский, участок Усть-Хайрюзово</option>
        <option value="RUPTN">RUPTN - Пластун</option>
        <option value="RUPRN">RUPRN - Поронайск</option>
        <option value="RUPSE">RUPSE - Посьет</option>
        <option value="RUPGN">RUPGN - Пригородное</option>
        <option value="RUPRI">RUPRI - Приморск</option>
        <option value="RUPRA">RUPRA - Приморско-Ахтарск</option>
        <option value="RUPVS">RUPVS - Провидения</option>
        <option value="RURND">RURND - Ростов-на-Дону</option>
        <option value="RURDP">RURDP - Рудная Пристань</option>
        <option value="RUSAB">RUSAB - Сабетта</option>
        <option value="RULED">RULED - Санкт-Петербург</option>
        <option value="RUSVE">RUSVE - Светлая</option>
        <option value="RUSVP">RUSVP - Севастополь</option>
        <option value="RUSVK">RUSVK - Северо-Курильск</option>
        <option value="RUSKA">RUSKA - Славянка</option>
        <option value="RUSOG">RUSOG - Советская Гавань</option>
        <option value="RUSOL">RUSOL - Соловки</option>
        <option value="RUAER">RUAER - Сочи</option>
        <option value="RUTAG">RUTAG - Таганрог</option>
        <option value="RUTAM">RUTAM - Тамань</option>
        <option value="RUTMR">RUTMR - Темрюк</option>
        <option value="RUIKS">RUIKS - Тикси</option>
        <option value="RUTUA">RUTUA - Туапсе</option>
        <option value="RUUGL">RUUGL - Углегорск</option>
        <option value="RUULU">RUULU - Усть-Луга</option>
        <option value="RUFEO">RUFEO - Феодосия</option>
        <option value="RUHTG">RUHTG - Хатанга</option>
        <option value="RUKHO">RUKHO - Холмск</option>
        <option value="RUCHA">RUCHA - Чажма</option>
        <option value="RUSHA">RUSHA - Шахтерск</option>
        <option value="RUEGV">RUEGV - Эгвекинот</option>
        <option value="RUDEE">RUDEE - Южно-Курильск</option>
        <option value="RUYAL">RUYAL - Ялта</option>
      </select>
    </div>
    <div> Дата, с: <input-date v-model="ed_DateFrom"/> </div> 
    <div> Время, с: <input-time v-model="timeFrom"/> </div> 
    <div> Время, по: <input-time v-model="timeTo"/> </div>    
   <div>
     <button type="button" @click="$emit('graf_refresh',$data)">Перестроить</button>
   </div> 
   
  </div>
    </b-container>
</template>

<script>
import inputDate from "../components/input-date.vue";
import inputTime from "../components/input-time.vue";
export default {
  components: { "input-date": inputDate, "input-time": inputTime },
  name: "search-panel",
  data() {
    return {
      ed_Port: null,
      ed_DateFrom: null, 
      timeFrom: null,
      timeTo:null
    };
  }
};
</script>
 
<style scoped>
 
select {
    width: 100%;
}
.search-panel {
      min-width: 1500px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.search-panel>div {
    display: flex;
    align-items: center;
    
    justify-content: center; 
    width: 100%;
    padding: 0 10px;
}
</style>
