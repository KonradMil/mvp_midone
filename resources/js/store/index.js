import { createStore } from "vuex";
import main from "./main";
import sideMenu from "./side-menu";
import login from "./login";
import createPersistedState from "vuex-persistedstate";
const store = createStore({
  modules: {
    main,
    sideMenu,
    login,
  },
    plugins: [createPersistedState()],
});

export function useStore() {
  return store;
}

export default store;
