const state = () => {
    return {
        user: null,
        isLoggedIn: false
    };
};
// getters
const getters = {
    user: state => state.user,
    isLoggedIn: state => state.isLoggedIn
};

// actions
const actions = {
    login({dispatch, commit}, {user}) {
        commit('login', user);
    },
    logout({commit}) {
        commit('logout');
    },
};

// mutations
const mutations = {
    login(state, user) {
        state.isLoggedIn = true;
        state.user = user;
    },
    logout(stat) {
        state.isLoggedIn = false;
        state.user = null;
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
