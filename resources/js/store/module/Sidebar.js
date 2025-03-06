// store/modules/dropdown.js

const state = {
    saledropdownVisible: false, // Menyimpan status visibility dropdown Sales
    maindropdownVisible: false, // Menyimpan status visibility dropdown Main
    oprdropdownVisible: false, // Menyimpan status visibility dropdown Main
  };
  
  const mutations = {
    // Mutation untuk toggle Sales dropdown
    TOGGLE_SALE_DROPDOWN(state) {
      state.saledropdownVisible = !state.saledropdownVisible;
    },
  
    // Mutation untuk toggle Main dropdown
    TOGGLE_MAIN_DROPDOWN(state) {
      state.maindropdownVisible = !state.maindropdownVisible;
    },
    TOGGLE_OPERATIONAL_DROPDOWN(state) {
      state.oprdropdownVisible = !state.oprdropdownVisible;
    },
  
    // Mutation untuk set visibility Sales dropdown
    SET_SALE_DROPDOWN(state, visibility) {
      state.saledropdownVisible = visibility;
    },
  
    // Mutation untuk set visibility Main dropdown
    SET_MAIN_DROPDOWN(state, visibility) {
      state.maindropdownVisible = visibility;
    },
    SET_OPERATIONAL_DROPDOWN(state, visibility) {
      state.oprdropdownVisible = visibility;
    }
  };
  
  const actions = {
    toggleSaleDropdown({ commit }) {
      commit('TOGGLE_SALE_DROPDOWN');
    },
  
    toggleMainDropdown({ commit }) {
      commit('TOGGLE_MAIN_DROPDOWN');
    },
    toggleOprDropdown({ commit }) {
      commit('TOGGLE_OPERATIONAL_DROPDOWN');
    },
  
    setSaleDropdown({ commit }, visibility) {
      commit('SET_SALE_DROPDOWN', visibility);
    },
  
    setMainDropdown({ commit }, visibility) {
      commit('SET_MAIN_DROPDOWN', visibility);
    },
    setOprDropdown({ commit }, visibility) {
      commit('SET_OPERATIONAL_DROPDOWN', visibility);
    }
  };
  
  const getters = {
    getSaleDropdownVisible(state) {
      return state.saledropdownVisible;
    },
  
    getMainDropdownVisible(state) {
      return state.maindropdownVisible;
    },
    getOprDropdownVisible(state) {
      return state.oprdropdownVisible;
    }
  };
  
  export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
  };
  