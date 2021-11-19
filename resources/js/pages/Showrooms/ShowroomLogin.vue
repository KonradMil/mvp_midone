<template>
    <div class="min-h-full flex items-center justify-center py-12 px-4 mt-24 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <Box classes="mt-4 p-5" style="background-color: rgba(255,255,255,0.66)">
                <div content="pt-8" v-if="organization != undefined">
                    <img class="mx-auto h-20 w-auto" :src="organization.organization_logo" :alt="organization.name"/>
                </div>
                <form class="mt-8 space-y-6" action="#" method="POST">
                    <input type="hidden" name="remember" value="true" />
                    <div class="rounded-md shadow-sm -space-y-px">
                        <div>
                            <TerraInput type="text" placeholder="e-mail" v-model:val="email"></TerraInput>
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
import Box from "../../components-terraform/Box";
import cash from "cash-dom/dist/cash";
import TerraInput from "../../components-terraform/TerraInput";
import RequestHandler from "../../compositions/RequestHandler";

export default {
    name: "ShowroomLogin",
    components: {TerraInput, Box},
    props: {
        organization: {
            type: String
        }
    },
    setup(props, {emit}) {
        const email = ref('');
        const organization = ref();

        const login = () => {
            RequestHandler('showroom/login/' + organization.value.organization_slug, 'POST', {
               email: email.value
            }, () => {
                window.location.href = '/showroom/play/' + organization.value.organization_slug;
            });
        }

        const getData = () => {
            RequestHandler('showroom/' + props.organization + '/data', 'POST', {}, (response) => {
                organization.value = response.data.showroom;
            });
        }

        onMounted(() => {
            getData();
            cash('body').addClass('fanuc-bg');
            cash('html').addClass('fanuc-bg');
        });

        return {
            login,
            email,
            organization
        }
    }
}
</script>

<style scoped>

</style>
