// resources/js/store/index.js

import { createStore } from 'vuex';

export default createStore({
  state: {
    user: null,
  },
  mutations: {
    SET_USER(state, user) {
        // console.log('Memanggil mutation SET_USER dengan:', user);
      state.user = user;
    //   console.log('Memanggil mutation state.user', state.user);
    },
  },
  actions: {
    setUser({ commit }, user) {
        // console.log('Memanggil mutation SET_USER dengan:', user);
      commit('SET_USER', user);
    },
  },
  getters: {
    user: (state) => {
      // console.log('Getter user called, returning:', state.user);
      return state.user;
    },
}
});
