<template>
    <div class="min-h-full flex items-center justify-center py-12 px-4 mt-24 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <Box classes="mt-4 p-5" style="background-color: rgba(255,255,255,0.66)">
                <div content="pt-8">
                    <img class="mx-auto h-20 w-auto" src="/s3/logos/fanuc_logo.jpeg" alt="FANUC" />
                </div>
                <form class="mt-8 space-y-6" action="#" method="POST">
                    <input type="hidden" name="remember" value="true" />
                    <div class="rounded-md shadow-sm -space-y-px">
                        <div>
<!--                            <Label title="E-mail"/>-->
                            <Input type="text" placeholder="e-mail" v-model:val="email"></Input>
                        </div>
                    </div>
                    <div>
                        <button @click.prevent="login" style="background-color: #FEDC04; color: #BF1C1D; text-transform: uppercase; font-weight: bold;" type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white focus:outline-none focus:ring-2 focus:ring-offset-2">
                            Wejdź
                        </button>
                    </div>
                </form>
            </Box>
        </div>
    </div>
</template>

<script>
import {onMounted, ref} from "vue";
import Box from "../../../components-terraform/Box";
import cash from "cash-dom/dist/cash";
import Input from "../../../components-terraform/Input";
import RequestHandler from "../../../compositions/RequestHandler";

export default {
    name: "ShowroomLogin",
    components: {Input, Box},
    props: {
        organization: {
            type: String
        }
    },
    setup(props, {emit}) {
        const email = ref('');

        const login = () => {
            RequestHandler('showroom/login/fanuc', 'POST', {
               email: email.value
            }, () => {
                window.location.href = 'https://platform.dbr77.com/showroom/play/fanuc';
            });
        }

        onMounted(() => {
            cash('body').addClass('fanuc-bg');
            cash('html').addClass('fanuc-bg');
        });

        return {
            login,
            email
        }
    }
}
</script>

<style scoped>

</style>
