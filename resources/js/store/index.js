import {createStore} from "vuex";
import main from "./main";
import createPersistedState from "vuex-persistedstate";

const store = createStore({
    modules: {
        main,
        unity
    },
    plugins: [createPersistedState()],
});

export function useStore() {
    return store;
}

export default store;
