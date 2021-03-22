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
import messages from './locales/messages.json';
import { createI18n } from 'vue-i18n'

const options = {

};
const i18n = createI18n({
    locale: 'pl', // set locale
    fallbackLocale: 'en', // set fallback locale
    messages, // set locale messages
    // If you need to specify other options, you can set other options
    // ...
})
require('./bootstrap')


const app = createApp(App)
globalComponents(app);
utils(app);
app.config.globalProperties.$axios = axios;
app.config.globalProperties.cash = cash;
router.beforeEach((to, from, next) => {
    // redirect to login page if not logged in and trying to access a restricted page
    const publicPages = ['/login', '/register'];
    const authRequired = !publicPages.includes(to.path);
    console.log(to.path);
    console.log(store.state.login.isLoggedIn);
    console.log(authRequired);
    if(!store.state.login.isLoggedIn) {
        if(authRequired) {
            next({ path: '/login' })
        } else {
            next();
        }
    } else {
        next();
    }



})
app.use(router)
app.use(store)
app.use(Toast, options);
app.use(i18n);
app.mount('#app')


