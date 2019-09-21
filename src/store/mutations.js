const mutations = {

  SET_LOADING_ON(state) {
    this._vm.$set(state, 'LOADING', true)
  },
  SET_LOADING_OFF(state) {
    this._vm.$set(state, 'LOADING', false)
  },
  INIT_PARAM(state, {key, val}) {
    this._vm.$set(state, key, val)
  }


}

export default mutations;