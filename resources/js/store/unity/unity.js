const state = () => {
    return {
        allowedEdit: false,
        mode: 'edit',
        type: '',
        initialLoad: [],
        animationSave: '',
        owner: false
    };
};
// getters
const getters = {
    allowedEdit: state => state.allowedEdit,
    type: state => state.type,
    mode: state => state.mode,
    initialLoad: state => state.initialLoad,
    animationSave: state => state.animationSave,
    owner: state => state.owner,
};


// mutations
const mutations = {
    load(state, load) {
        state.initialLoad = load;
    }
};

export default {
    namespaced: true,
    state,
    getters,
    mutations
};
