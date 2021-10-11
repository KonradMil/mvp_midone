<template>
    <div class="intro-y box lg:mt-5">
        <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">
                {{$t('profiles.changePassword')}}
            </h2>
        </div>
        <form @submit.prevent="changePassword">
            <div class="p-5">
                <div>
                    <label for="change-password-form-1" class="form-label">{{$t('profiles.oldPassword')}}</label>
                    <input
                        id="change-password-form-1"
                        type="password"
                        class="form-control"
                        placeholder=""
                        v-model="password"
                    >
                </div>
                <div class="mt-3">
                    <label for="change-password-form-2" class="form-label">{{$t('profiles.newPassword')}}</label>
                    <input
                        id="change-password-form-2"
                        type="password"
                        class="form-control"
                        placeholder=""
                        v-model="passwordNew"
                    >
                </div>
                <div class="mt-3">
                    <label for="change-password-form-3" class="form-label">{{$t('profiles.newPasswordConfirm')}}</label>
                    <input
                        id="change-password-form-3"
                        type="password"
                        class="form-control"
                        placeholder=""
                        v-model="passwordNewConfirm"
                    >
                </div>
                <button type="submit" class="btn btn-primary mt-4" @click="changePassword">{{ $t('profiles.changePassword') }}</button>
            </div>
        </form>
    </div>

</template>

<script>
import DarkModeSwitcher from "../../components/dark-mode-switcher/Main";
import {useToast} from "vue-toastification";

import store from "../../store";

const toast = useToast();

export default {
    components: {
        DarkModeSwitcher,
    },
    setup() {
        const user = window.Laravel.user;
        return {
            user,
        };
    },
    data() {
        return {
            error: null,
            password: '',
            passwordNew: '',
            passwordNewConfirm: ''
        }
    },
    methods : {
        changePassword() {
            if (this.passwordNew === this.passwordNewConfirm) {
                this.$axios.get('/sanctum/csrf-cookie').then(response => {
                    this.$axios.post('api/profile/change-password', {
                        password: this.password,
                        passwordNew: this.passwordNew,
                    })
                        .then(response => {

                            if (response.data.success) {
                                let user = response.data.payload;
                                store.dispatch('login/login', {
                                    user
                                });
                                toast.success(response.data.message);

                            } else {
                                toast.error(response.data.message);
                            }
                        })
                })
            }
        },
    },
    created() {
        if (window.Laravel.user) {
            // this.user = window.Laravel.user;
            this.avatar_path = window.Laravel.user.avatar;
        }
    },
}
</script>

<style scoped>

</style>
