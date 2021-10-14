<template>
    <div class="intro-y box pt-5">
        <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">
                Bezpieczeństwo
            </h2>
        </div>

            <div class="p-5">
                <div class="flex flex-col-reverse xl:flex-row flex-col">
                    <div class="flex-1 mt-6 xl:mt-0">
                        <div class="grid grid-cols-12 gap-x-5">
                            <div class="col-span-12 xxl:col-span-12" v-if="qr != ''">
                                <img :src="qr" class="w-1/2 h-100"/>
                            </div>
                            <div class="col-span-12 xxl:col-span-12">
                                <div class="mt-3">
                                    <label for="input-wizard-2" class="form-label w-full">Telefon</label>
                                    <br/>
                                    <input
                                        id="input-wizard-2"
                                        type="text"
                                        class="form-control w-64"
                                        v-model="user.phone"
                                    />
                                </div>
                            </div>
                            <div class="col-span-12 xxl:col-span-12 mt-3">
                                <div class="form-check" v-if="twofa">
                                    <input id="checkbox-switch-7" class="form-check-switch" type="checkbox" @change="changeTwoFa"  checked/>
                                    <label class="form-check-label" for="checkbox-switch-7">Logowanie dwuetapowe</label>
                                </div>
                                <div class="form-check" v-if="!twofa">
                                    <input id="checkbox-switch-8" class="form-check-switch" type="checkbox" @change="changeTwoFa"/>
                                    <label class="form-check-label" for="checkbox-switch-8">Logowanie dwuetapowe</label>
                                </div>

                            </div>
                        </div>
                        <button class="btn btn-primary w-20 mt-3" type="submit" @click.prevent="save">{{ $t('global.save') }}</button>
                    </div>
                </div>
            </div>
    </div>
</template>

<script>
import {defineComponent, onMounted, ref} from "vue";
import DarkModeSwitcher from "../../components/dark-mode-switcher/Main.vue";
import cash from "cash-dom";
import GetTeams from "../../compositions/GetTeams";
import {useToast} from "vue-toastification";
import router from "../../router";
import Multiselect from '@vueform/multiselect';


const toast = useToast();

export default {
    components: {
        Multiselect
    },
    setup() {

        const user = window.Laravel.user;
        const twofa = ref(false);
        const qr = ref('');

        const changeTwoFa = () => {
            if(user.phone == '') {
                toast.error('Telefon jest wymagany.');
            } else  {

                if(twofa.value) {
                    twofa.value = false;
                } else {
                    twofa.value = true;
                }



                axios.post('api/user/register-authy', {phone: user.phone})
                    .then(response => {

                        if (response.data.success) {
                            qr.value = JSON.parse(response.data.payload).qr_code;
                            // toast.success(response.data.message);
                        } else {
                            toast.error(response.data.message);
                        }
                    })
                    .catch(function (error) {
                        toast.error(error);
                    });
            }

        };

        const save = () => {


                axios.post('api/company/save', {
                    id: company.value.id,

                })
                    .then(response => {

                        if (response.data.success) {
                            toast.success(response.data.message);
                        } else {
                            toast.error(response.data.message);
                        }
                    })
                    .catch(function (error) {
                        toast.error(error);
                    });
        }

        onMounted(() => {
            twofa.value = !!window.Laravel.user.twofa;
            cash("body")
                .removeClass("error-page")

        });
        return {
            user,
            save,
            changeTwoFa,
            twofa,
            qr
        }
    }
}
</script>

<style scoped>

</style>
