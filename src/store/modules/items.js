
export default {
    namespaced: true,

    state: {
        MENU: {
            public: [],
            draft: [],
        },
        LOADING: false,
        ERROR: false,
        // ITEMS: [],
    },

    getters: {
        DRAFT_MENU: state => state.MENU.draft,
        PUBLIC_MENU: state => state.MENU.public,
        COUNT_MENU_ITEMS: state => {
            const p = state.MENU.public
            const d = state.MENU.draft
            if (!d && !d) return 0;
            let a = 0;
            p.forEach(e => a += e.items.length)
            d.forEach(e => a += e.items.length)
            return a
            //ОЛД: вариант еще и с разделением по датам .!.
            //Object.keys(p).forEach(key => Object.keys(d[key]).forEach(key2 => a += d[key][key2].length ) );
            //Object.keys(d).forEach(key => Object.keys(d[key]).forEach(key2 => a += d[key][key2].length ) );
            return a;
        }
    },

    mutations: {
        SET_ITEMS_LOADING_ON(state) { state.LOADING = true },
        SET_ITEMS_LOADING_OFF(state) { state.LOADING = false },
        SET_ITEMS(state, ITEMS) { this._vm.$set(state, 'ITEMS', ITEMS) },
        SET_MENU(state, MENU) { this._vm.$set(state, 'MENU', MENU) },
        /*   SET_MENU_ITEM(state, {isDraft, el, val} ) {
               let index;
               const arr = state.MENU[isDraft?'draft':'public'];
               arr.some( (e,i) => ( e.id == el.id && ( index = i )) );
               this._vm.$set(arr[index], 'items', val)
           },
           SET_MENU_ITEM_LOADING(state, {isDraft, el, val} ) {
               let index;
               const arr = state.MENU[isDraft?'draft':'public'];
               arr.some( (e,i) => ( e.id == el.id && ( index = i )) );
               this._vm.$set(arr[index], 'isLoading', val)
           }*/
    },

    actions: {

        /*  GET_MENU_ITEMS({ state, commit, dispatch, getters, rootState }, { isDraft, el } ) { //NEW WAY! 25.09.2019 !

              commit('SET_MENU_ITEM_LOADING', {isDraft, el, val: true} )
              debugger;
              let test = e => e ? e : "";
              const PARAMS = rootState.searchPanel.PARAMS
              let p = test(PARAMS.ed_Port);
              let hf = test(PARAMS.timeFrom.HH);
              let mf = test(PARAMS.timeFrom.mm);
              let ht = test(PARAMS.timeTo.HH);
              let mt = test(PARAMS.timeTo.mm);
              let df = test(PARAMS.ed_DateFrom);
                  const url = `${rootState.BACKEND_URL}action=get-menu-item&menu-item-param=${el.param}&port=${p}&HoursFrom=${hf}&MinsFrom=${mf}&HoursTo=${ht}&MinsTo=${mt}&ed_DateFrom=${df}&type_port_place=${PARAMS.type_port_place}`;
                  axios
                      .get(url)
                      .then(res => {
                          const data = res.data;
                          if (typeof data == "string" && !data.match("SQL")) throw "MS SQL ERROR!";
                          if (typeof data != "object") throw "данные не пришли";
                          commit('SET_MENU_ITEM', {isDraft, el, val: data} )
                      })
                      .catch(err => {
                          console.warn("ОШИБКА в аксиосе => ", err);
                          const title = err.response && err.response.status == 501 && 'Необходимо авторизоваться'  || err.response.data && err.response.data.msg || 'Ошибка при получении данных';
                          Swal.fire({ type: "error", title });
                      })
                      .finally(() =>  commit('SET_LOADING_OFF'));
          },*/

        GET_ITEMS({ state, commit, dispatch, getters, rootState }, props) { //OLD WAY !

            const action = typeof props == 'object' && props.action || '';
            commit('SET_ITEMS_LOADING_ON')
            let test = e => e ? e : "";
            const PARAMS = rootState.searchPanel.PARAMS
            let p = test(PARAMS.ed_Port);
            let hf = test(PARAMS.timeFrom.HH);
            let mf = test(PARAMS.timeFrom.mm);
            let ht = test(PARAMS.timeTo.HH);
            let mt = test(PARAMS.timeTo.mm);
            let df = test(PARAMS.ed_DateFrom);
            let headers = {};

            if (action === "to-export") headers = { responseType: "blob" };
            const url = `${rootState.BACKEND_URL}action=get-menu&port=${p}&HoursFrom=${hf}&MinsFrom=${mf}&HoursTo=${ht}&MinsTo=${mt}&ed_DateFrom=${df}&type_port_place=${PARAMS.type_port_place}`;
            axios
                .get(url, headers)
                .then(res => {
                    let data = res.data;
                    if (typeof data == "string" && !data.match("SQL")) throw "MS SQL ERROR!";
                    else if (action === "to-export") {
                        var fileDownload = require("js-file-download");
                        let prt = rootState.searchPanel.PORTS.filter(e => e.value == p);
                        prt = prt.length > 0 ? prt[0].text : "";
                        fileDownload(data, `Export-${df} [${hf}-${mf} - ${ht}-${mt}]${p ? ". " + prt : ""}.xlsx`);
                        return;
                    }
                    else if (typeof data != "object") throw "данные не пришли";
                    else commit('SET_MENU', data)
                })
                .catch(err => {
                    console.warn("ОШИБКА в аксиосе => ", err);
                    const title = err.response && err.response.status == 501 && 'Необходимо авторизоваться' || err.response.data && err.response.data.msg || 'Ошибка при получении данных';
                    Swal.fire({ type: "error", title });
                })
                .finally(() => commit('SET_ITEMS_LOADING_OFF'));
        },

        TRANSFER_ITEMS({ state, commit, dispatch, getters, rootState }, { row, action }) {

            commit('SET_ITEMS_LOADING_ON')
            const send_data = { ...row }; //если суточная телега -подмешиваем существующими данными;
            // в беке юзаем поля: EntID, FlagStatus, ed_Port
            const url = `${rootState.BACKEND_URL}action=${action}`;
            axios
                .post(url, send_data)
                .then(e => dispatch('GET_ITEMS'))
                .catch(err => {
                    console.warn("Ошибка при ПОСТе => ", err);
                    Swal.fire({
                        type: "error",
                        title: "Ошибка при отправке данных"
                    });
                })
                .finally(() => commit('SET_ITEMS_LOADING_OFF'));
        },


    },

}