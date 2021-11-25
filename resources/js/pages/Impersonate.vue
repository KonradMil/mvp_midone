<template>
    <div class="intro-y grid grid-cols-12 gap-6 mt-5 p-6">
        <div class="intro-y col-span-12 box p-5 pl-2 py-5 text-theme-1 dark:text-theme-10 font-medium">
            <h2 class="mt-5">Logowanie jako inny użytkownik</h2>
            <TerraInput v-model:val="email" class="mt-5" type="email" placeholder="Adres e-mail"/>
            <button class="btn btn-primary mt-5" @click="impersonate">Zaloguj</button>
        </div>
    </div>
</template>

<script>
import {ref} from 'vue';
import TerraInput from '../components-terraform/TerraInput';
import RequestHandler from '../compositions/RequestHandler';

export default {

    name: "Impersonate",

    components: {
        TerraInput
    },

    setup() {

        let email = ref('');

        const impersonate = () => {

            RequestHandler(
                'user/impersonate',
                'POST',
                {
                    email: email.value
                },
                function(response){
                    window.location = '/dashboard';
                }
            );

        }

        return {
            email,
            impersonate
        };

    },

    mounted() {

        if(
            typeof window.Laravel.user === undefined ||
            typeof window.Laravel.user.can_impersonate === undefined ||
            window.Laravel.user.can_impersonate !== 1
        ) {
            location.href = '/dashboard';
        }

    }
}
</script>
