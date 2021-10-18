<template>
    <div id="confirm"></div>
        <router-view/>
</template>

<script>

import {useToast} from "vue-toastification";

const toast = useToast();

export default {
    name: "App",
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
