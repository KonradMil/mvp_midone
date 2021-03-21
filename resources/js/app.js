import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import globalComponents from "./global-components";
import utils from "./utils";
import "./libs";
import axios from 'axios'
import cash from "cash-dom";
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
const options = {

};

require('./bootstrap')


const app = createApp(App)
globalComponents(app);
utils(app);
app.config.globalProperties.$axios = axios;
app.config.globalProperties.cash = cash;
app.use(router)
app.use(store)
app.use(Toast, options);
app.mount('#app')


