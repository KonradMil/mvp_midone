<template>
    <loading :active="isLoading" :is-full-page="fullPage"></loading>
        <router-view/>
</template>

<script>

import {useToast} from "vue-toastification";
import {onMounted, ref} from "vue";
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
const toast = useToast();

export default {
    name: "App",
    components: {
        Loading
    },
    setup() {
        const isLoading = ref(false);
        const fullPage = ref(true);
        const counter = ref(0);
        onMounted(() => {
            window.axios.interceptors.request.use(function (config) {
                isLoading.value = true;
                counter.value++;
                return config;
            }, function (error) {
                counter.value--;
                if(counter.value === 0) {
                    isLoading.value = false;
                }


                return Promise.reject(error);
            });

            axios.interceptors.response.use(function (response) {
                counter.value--;
                if(counter.value === 0) {
                    isLoading.value = false;
                }

                return response;
            }, function (error) {
                counter.value--;
                if(counter.value === 0) {
                    isLoading.value = false;
                }
                // console.log(counter.value)

                return Promise.reject(error);
            });
        })

        return {
            isLoading,
            fullPage,
            counter
        }
    },
    data() {
        return {
            isLoggedIn: false,
        }
    },
    created() {
        if (window.Laravel.isLoggedin) {
            this.isLoggedIn = true
        }
    },
    mounted() {
        window.addEventListener('load', () => {

            if(typeof window.error !== 'undefined' && window.error !== null) {
                toast.error(window.error);
            }

            if(typeof window.warning !== 'undefined' && window.warning !== null) {
                toast.warning(window.warning);
            }

            if(typeof window.info !== 'undefined' && window.info !== null) {
                toast.info(window.info);
            }

            if(typeof window.success !== 'undefined' && window.success !== null) {
                toast.success(window.success);
            }

        });
    },

    methods: {
        logout(e) {
            e.preventDefault()
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/logout')
                    .then(response => {
                        if (response.data.success) {
                            window.location.href = "/"
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        }
    },
}
</script>
