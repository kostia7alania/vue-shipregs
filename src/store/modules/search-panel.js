export default {
    namespaced: true,

    state: {
        LOADING: false,
        ERROR: false,
        PORTS: [],
        PARAMS: {
            ed_Port: "RUKZP",
            ed_DateFrom: '',
            timeFrom: { HH: "15", mm: "00" },
            timeTo: { HH: "15", mm: "00" },
            type_port_place: null,
        },
        DICTIONARY_PORT_PLACE: [],
        DICTIONARY_TYPE_PORT_PLACE: []
    },
    getters: {
        params_is_valid(state) {
            const p = state.PARAMS;
            return ['ed_Port', 'ed_DateFrom', 'type_port_place']
                .every(e => typeof p[e] == 'string' && p[e].length || typeof p[e] == 'number')
        }//['searchPanel/params_is_valid']
    },
    mutations: {
        SET_SEARCH_PANEL_LOADING_ON(state) { state.LOADING = true },
        SET_SEARCH_PANEL_LOADING_OFF(state) { state.LOADING = false },
        SET_PORTS(state, PORTS) { this._vm.$set(state, 'PORTS', PORTS) },
        SET_PARAM(state, { key, val }) { this._vm.$set(state.PARAMS, key, val) },
        SET_DICTIONARY_PORT_PLACE(state, DIC) { this._vm.$set(state, 'DICTIONARY_PORT_PLACE', DIC) },
        SET_DICTIONARY_TYPE_PORT_PLACE(state, DIC) { this._vm.$set(state, 'DICTIONARY_TYPE_PORT_PLACE', DIC) }
    },
    actions: {

        GET_PORTS({ state, commit, dispatch, getters, rootState }) {

            commit('SET_SEARCH_PANEL_LOADING_ON')
            const url = `${rootState.BACKEND_URL}action=get-ports`;
            axios.get(url)
                .then(e => {
                    if (e.data instanceof Array) commit('SET_PORTS', e.data)
                })
                .catch(err => {
                    console.warn("CATCH - GET_PORTS => ", err);
                    const title = err.response && err.response.status == 501 && 'Необходимо авторизоваться' || err.response.data && err.response.data.msg || 'Ошибка при получении портов';
                    Swal.fire({ type: 'error', title })

                })
                .finally(() => commit('SET_SEARCH_PANEL_LOADING_OFF'));

        },

        GET_DICTIONARY_PORT_PLACE({ state, commit, dispatch, getters, rootState }) {
            commit('SET_SEARCH_PANEL_LOADING_ON')
            const url = `${rootState.BACKEND_URL}action=get-dictionary-port-place`;
            axios
                .get(url)
                .then(e => {
                    if (e.data instanceof Array) return commit('SET_DICTIONARY_PORT_PLACE', e.data)
                    throw 'Wrong data .!.'
                })
                .catch(err => {
                    console.warn("CATCH - GET_DICTIONARY_PORT_PLACE => ", err);
                    const title = err.response && err.response.status == 501 && 'Необходимо авторизоваться' || err.response.data && err.response.data.msg || 'Ошибка при получении dictionary port place';
                    Swal.fire({ type: 'error', title })
                })
                .finally(() => commit('SET_SEARCH_PANEL_LOADING_OFF'));
        },

        GET_DICTIONARY_TYPE_PORT_PLACE({ state, commit, dispatch, getters, rootState }) {
            commit('SET_SEARCH_PANEL_LOADING_ON')
            const url = `${rootState.BACKEND_URL}action=get-dictionary-type-port-place`;
            axios
                .get(url)
                .then(e => {
                    if (e.data instanceof Array) return commit('SET_DICTIONARY_TYPE_PORT_PLACE', e.data)
                    throw 'Wrong data .!.'
                })
                .catch(err => {
                    console.warn("CATCH - GET_DICTIONARY_TYPE_PORT_PLACE => ", err);
                    const title = err.response && err.response.status == 501 && 'Необходимо авторизоваться' || err.response.data && err.response.data.msg || 'Ошибка при получении dictionary type port place';
                    Swal.fire({ type: 'error', title })
                })
                .finally(() => commit('SET_SEARCH_PANEL_LOADING_OFF'));
        }

    },

}