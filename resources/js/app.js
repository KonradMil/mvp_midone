import {createApp} from "vue";
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
import {createI18n} from 'vue-i18n'
import dayjs from "dayjs";
import VueFinalModal from 'vue-final-modal'
import Echo from 'laravel-echo';
import mitt from 'mitt'
import lazyPlugin from 'vue3-lazy'
import VueCookies from 'vue3-cookies'
import advancedFormat from 'dayjs/plugin/advancedFormat'
import locale from 'dayjs/esm/locale/pl';
import relativeTime from 'dayjs/esm/plugin/relativeTime';
import updateLocale from 'dayjs/esm/plugin/updateLocale';
import {VueReCaptcha} from "vue-recaptcha-v3";
import utc from 'dayjs/esm/plugin/utc';

const emitter = mitt();


const options = {};
const i18n = createI18n({
    locale: store.state.main.currentLang, // set locale
    fallbackLocale: 'en', // set fallback locale
    messages, // set locale messages
})
require('./bootstrap')

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    authEndpoint: '/api/broadcast/auth',
    broadcaster: 'pusher',
    key: '04989c27fdac187aad41',
    cluster: 'eu',
    wsHost: window.location.hostname,
    wsPort: 6001,
    forceTLS: false,
    disableStats: true,
});

// window.Echo = new Echo({
//     authEndpoint: '/api/broadcast/auth',
//     broadcaster: "socket.io",
//     host: 'localhost:6001',
//     wsHost: window.location.hostname,
//     wsPort: 6001,
//     forceTLS: false,
// });

const app = createApp(App)
globalComponents(app);
utils(app);

app.config.globalProperties.$dayjs = dayjs;
app.config.globalProperties.$axios = axios;
app.config.globalProperties.cash = cash;
app.config.globalProperties.emitter = emitter;
app.use(lazyPlugin, {
    loading: '/s3/twopointo/images/loader.gif',
    error: '/s3/screenshots/dbr_placeholder.jpeg'
})
router.beforeEach((to, from, next) => {
    // redirect to login page if not logged in and trying to access a restricted page
    const publicPages = ['login', 'register', 'terms', 'robochallenge', 'reset-password'];
    console.log('to', to);
    const authRequired = !publicPages.includes(to.name);
    console.log(store.state.login);
    if (!store.state.login.isLoggedIn) {
        console.log('NOT LOGGED, AUTH REQUIRED');
        if (authRequired) {
            next({path: '/login'})
        } else {
            next();
        }
    } else {
        next();
    }
})
app.use(VueCookies, {
    expireTimes: "1h",
});
dayjs.extend(relativeTime);
dayjs.extend(advancedFormat)
dayjs.extend(utc);
dayjs.extend(updateLocale);
dayjs.locale(locale);
app.use(VueFinalModal)
app.use(router)
app.use(store)
app.use(Toast, options);
app.use(i18n);
app.use(VueReCaptcha, {siteKey: process.env.MIX_RECAPTCHA_SITE_KEY});
app.mount('#app')
