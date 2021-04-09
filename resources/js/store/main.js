import * as types from "./mutation-types";

const state = () => {
  return {
    darkMode: false,
      currentLang: 'pl'
  };
};
// getters
const getters = {
  darkMode: state => state.darkMode,
    currentLang: state => state.currentLang
};

// actions
const actions = {
  setDarkMode({ commit }, darkMode) {
    commit(types.SET_DARK_MODE, { darkMode });
  },
    setCurrentLang({commit}, lang) {
      commit('SetLang', {lang})
    }
};

// mutations
const mutations = {
  [types.SET_DARK_MODE](state, { darkMode }) {
    state.darkMode = darkMode;
  },
    SetLang(state, {lang}) {
      state.currentLang = lang;
    }
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
};
