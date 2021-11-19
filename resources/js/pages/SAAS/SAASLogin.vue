<template>
    <div class="min-h-full flex items-center justify-center py-12 px-4 mt-24 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <Box classes="mt-4 p-5" style="background-color: rgba(255,255,255,0.66)">
                <div content="pt-8" v-if="organization != undefined">
                    <img class="mx-auto h-20 w-auto" :src="organization.organization_logo" :alt="organization.name"/>
                </div>
                <form class="mt-8 space-y-6" action="#" method="POST">
                    <div class="rounded-md shadow-sm -space-y-px">
                        <div class="input-group mt-2">
                            <TerraInput type="text" placeholder="e-mail" v-model:val="email"></TerraInput>
                            <div v-if="organization != undefined" class="input-group-text">{{ organization.email_regexp }}</div>
                        </div>
                    </div>
                    <template v-if="registerShow">
                        <div class="rounded-md shadow-sm -space-y-px" >
                            <div class="input-group mt-2">
                                <TerraInput type="password" placeholder="Hasło" v-model:val="password"></TerraInput>
                            </div>
                        </div>
                        <div class="rounded-md shadow-sm -space-y-px" >
                            <div class="input-group mt-2">
                                <TerraInput type="password" placeholder="Powtórz hasło" v-model:val="password_repeat"></TerraInput>
                            </div>
                        </div>
                    </template>
                    <template v-if="!registerShow">
                    <div>
                        <button @click.prevent="login" style="background-color: #5e50ac; color: #fff; text-transform: uppercase; font-weight: bold;" type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white focus:outline-none focus:ring-2 focus:ring-offset-2">
                            Wejdź
                        </button>
                        <button @click.prevent="register" style="background-color: #5e50ac; color: #fff; text-transform: uppercase; font-weight: bold;" type="submit" class="mt-2 group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white focus:outline-none focus:ring-2 focus:ring-offset-2">
                            Zarejestruj
                        </button>
                    </div>
                    </template>
                    <template v-if="registerShow">
                        <button @click.prevent="registerMe" style="background-color: #5e50ac; color: #fff; text-transform: uppercase; font-weight: bold;" type="submit" class="mt-2 group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white focus:outline-none focus:ring-2 focus:ring-offset-2">
                            Rejestruj
                        </button>
                    </template>
                </form>
            </Box>
        </div>
    </div>
</template>

<script>
import {onMounted, ref} from "vue";
import Box from "../../components-terraform/Box";
import cash from "cash-dom/dist/cash";
import TerraInput from "../../components-terraform/TerraInput";
import RequestHandler from "../../compositions/RequestHandler";
import {useToast} from "vue-toastification";
import router from "../../router";

export default {
    name: "SAASLogin",
    components: {TerraInput, Box},
    props: {
        organization: {
            type: String
        }
    },
    setup(props, {emit}) {
        const email = ref('');
        const password = ref('');
        const password_repeat = ref('');
        const organization = ref();
        const registerShow = ref(false);
        const toast = useToast();
        const login = () => {
            RequestHandler('saas/login/' + props.organization, 'POST', {
                email: email.value
            }, () => {
                window.location.href = '/playground/saves';
            });
        }

        const getData = () => {
            RequestHandler('saas/' + props.organization + '/data', 'POST', {}, (response) => {
                console.log(response);
                console.log(response.data);
                organization.value = response.data.saas;
            });
        }

        const registerMe = () => {
            if(password.value !== password_repeat.value) {
                toast.error('Hasła nie są takie same');
            } else {
                RequestHandler('saas/register/' + props.organization, 'POST', {
                    email: email.value + organization.value.email_regexp,
                    password: password.value
                }, () => {
                    router.push({path: '/kreator'});
                });
            }
        }

        const register = () => {
            registerShow.value = true;
        }

        onMounted(() => {
            getData();
            cash('body').addClass('saas-bg');
            cash('html').addClass('saas-bg');
        });

        return {
            login,
            email,
            organization,
            password,
            password_repeat,
            register,
            registerShow,
            registerMe
        }
    }
}
</script>

<style scoped>

</style>
