export const searchResultFields =  {
  app_number: { label: "Номер заявки", sortable: true },
  acquisition_Channel: { 
    label: "Канал поступления", 
    sortable: true,
    formatter: (value, key, item) => { 
      let acq = item.acquisition_Channel; 
      return acq;
    }
  },
  stage: {
    key: "stage", //переопред ключа из айтэмов
    label: "Стадия",
    sortable: true,
    formatter: (value, key, item) => {  
        let stage = item.stage;
        stage = stageArr.filter(e => e.value === stage);
        return stage.length>0?stage[0].text:false;
        /*//Д,сорян, Антон, выпиливаю совсем твой код;
        try {stage = stageArr.filter(e => e.value === stage)[0].text;}
        catch (e) {console.error(`Не найдено свойство text для значения: "${stage}" в справочнике - Стадия заявки.` + "\n" + e);} 
        return stage;*/
    }
  },
  decision: { 
    label: "Решение",
    sortable: true,
    formatter: (value, key, item) => {  
      let decision = item.decision;
      decision = decisionArr.filter(e => e.value === decision);
      return decision.length>0?decision[0].text:false;
      /*//Д,сорян, Антон, выпиливаю совсем твой код;
      try {decision = decisionArr.filter(e => e.value === decision)[0].text;}
      catch (e) {console.error(`Не найдено свойство text для значения: "${decision}" в справочнике - Стадия заявки.` + "\n" + e);} 
      return decision;*/
  }
},
  cnum_Num: { label: "CNUM"},
  nameOrg: { 
    label: "Наименование организации / ФИО (для ИП)",
    formatter: (value, key, item) => {
      if(item.app_type=='LE')
        return item.full_name;
      if(item.app_type=='IE')
        return `${item.last_Name} ${item.first_Name} ${item.middle_Name}`;
    }
  },
  leadName: { 
    label: "ФИО заявителя / заемщика",
    formatter: (value, key, item) => {
      return `${item.last_Name} ${item.first_Name} ${item.middle_Name}`;
    }
  },
  obtain_City: { label: "Город", sortable: true},
  submission_Date: {
    label: "Дата подачи заявки",
    sortable: true,
    formatter: (value, key, item) => { 
      let date = new Date(item.submission_Date);
      if(!date) return item.submission_Date
      return`${date.getFullYear()}-${date.getMonth()+1}-${date.getDate()}`
    }
  },
  amount: { label: "Сумма", sortable: true },
  term: { label: "Срок", sortable: true },
  product_Type: {
    label:"Продукт",
    formatter: (value, key, item) => {  
      let product_Type = item.product_Type;
      product_Type = productArr.filter(e => e.value === product_Type);
      return product_Type.length>0?product_Type[0].text:false;
      /*//Д,сорян, Антон, выпиливаю совсем твой код;
      try {product_Type = productArr.filter(e => e.value === product_Type)[0].text;}
      catch (e) {console.error(`Не найдено свойство text для значения: "${product_Type}" в справочнике - Тип продукта.` + "\n" + e);} 
      return product_Type;*/
    }
  },
  decision_comment: {label: 'Комментарий по отказу'}
}
