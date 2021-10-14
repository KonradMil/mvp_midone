<template>
    <div>
        <div class="flex items-center mt-8">
            <h2 class="intro-y text-lg font-medium mr-auto">Kreator profilu</h2>
        </div>
        <!-- BEGIN: Wizard Layout -->
        <div class="intro-y box py-10 sm:py-20 mt-5">
            <div class="flex justify-center">
                <button
                    @click="$router.push('/kreator')"
                    class="intro-y w-10 h-10 rounded-full btn bg-gray-200 dark:bg-dark-1 text-gray-600 mx-2">

                    1
                </button>
                <button class="intro-y w-10 h-10 rounded-full btn btn-primary mx-2">
                    2
                </button>
            </div>
            <div class="px-5 mt-10">
                <div class="font-medium text-center text-lg">Firma</div>
                <div class="text-gray-600 text-center mt-2">
                    Uzupełnij dane firmy
                </div>
            </div>
            <div class="px-5 sm:px-20 mt-10 pt-10 border-t border-gray-200 dark:border-dark-5">
                <!--                <div class="font-medium text-base">Profile Settings</div>-->
                <div class="grid grid-cols-12 gap-4 gap-y-5 mt-5">
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-1" class="form-label">Nazwa firmy</label>
                        <input id="input-wizard-1" type="text" class="form-control" v-model="company.company_name"/>
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-2" class="form-label">NIP</label>
                        <input id="input-wizard-2" type="text" class="form-control" v-model="company.nip"/>
                        <button class="btn btn-primary w-1/4 mt-2" @click.prevent="searchNip">Szukaj po NIP</button>
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-3" class="form-label">REGON</label>
                        <input id="input-wizard-3" type="text" class="form-control" v-model="company.regon"/>
                        <button class="btn btn-primary w-1/4 mt-2" @click.prevent="searchRegon">Szukaj po REGON</button>
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-4" class="form-label">KRS</label>
                        <input id="input-wizard-4" type="text" class="form-control" v-model="company.krs"/>
                        <button class="btn btn-primary w-1/4 mt-2" @click.prevent="searchKRS">Szukaj po KRS</button>
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-5" class="form-label">Miejscowość</label>
                        <input id="input-wizard-5" type="text" class="form-control" v-model="company.city"/>
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-6" class="form-label">Ulica</label>
                        <input id="input-wizard-6" type="text" class="form-control" v-model="company.street"/>
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-5" class="form-label">Nr domu</label>
                        <input id="input-wizard-7" type="text" class="form-control" v-model="company.house_nr"/>
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-6" class="form-label">Nr lokalu</label>
                        <input id="input-wizard-8" type="text" class="form-control" v-model="company.loc_nr"/>
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-5" class="form-label">Kod pocztowy</label>
                        <input id="input-wizard-9" type="text" class="form-control" v-model="company.postcode"/>
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-5" class="form-label">Województwo</label>
                        <input id="input-wizard-11" type="text" class="form-control" v-model="company.province"/>
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-6" class="form-label">Kraj</label>
                        <input id="input-wizard-12" type="text" class="form-control" v-model="company.country"/>
                    </div>
                    <div class="intro-y col-span-12 flex items-center justify-center sm:justify-end mt-5">
                        <button class="btn btn-secondary w-24" @click="$router.push('kreator')">Wstecz</button>
                        <button class="btn btn-primary w-24 ml-2" @click="save">Zapisz</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Wizard Layout -->
    </div>
</template>

<script>
import {defineComponent, onMounted, ref} from "vue";
    import DarkModeSwitcher from "../components/dark-mode-switcher/Main.vue";
    import cash from "cash-dom";
    import {useToast} from "vue-toastification";
import router from "../router";

    const toast = useToast();

    export default {
        components: {
            DarkModeSwitcher
        },
        setup() {
            const user = window.Laravel.user;
            const teams = ref([]);
            const company = ref({
                regon: '',
                nip: '',
                company_name: '',
                city: '',
                street: '',
                flat_nr: '',
                house_nr: '',
                postcode: '',
                province: '',
                country: '',
                krs: ''
            });
            // company.value = user.companies[0];


            const searchNip = () => {
                search({nip:company.value.nip});
            };

            const searchRegon = () => {
                search({regon:company.value.regon});
            };

            const searchKRS = () => {
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.post('api/company/search/krs', {
                        krs: company.value.krs
                    })
                        .then(response => {

                            if (response.data.success) {
                                if (response.data.success) {
                                    company.value.regon = response.data.payload.regon;
                                    company.value.nip = response.data.payload.nip;
                                    company.value.city = response.data.payload.postCity;
                                    company.value.company_name = response.data.payload.name;
                                    company.value.street = response.data.payload.street;
                                    company.value.loc_nr = response.data.payload.apartmentNumber;
                                    company.value.house_nr = response.data.payload.propertyNumber;
                                    company.value.postcode = response.data.payload.zipCode;
                                    company.value.province = response.data.payload.province;
                                    company.value.country = 'Polska';
                                } else {
                                    toast.error(response.data.message);
                                }

                            } else {
                                toast.error(response.data.message);
                            }
                        })
                        .catch(function (error) {
                            toast.error(error);
                        });
                })
            };

            const search = (val) => {
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.post('api/company/search/nip', val)
                        .then(response => {

                            if (response.data.success) {
                                company.value.regon = response.data.payload.regon;
                                company.value.nip = response.data.payload.nip;
                                company.value.city = response.data.payload.postCity;
                                company.value.company_name = response.data.payload.name;
                                company.value.street = response.data.payload.street;
                                company.value.loc_nr = response.data.payload.apartmentNumber;
                                company.value.house_nr = response.data.payload.propertyNumber;
                                company.value.postcode = response.data.payload.zipCode;
                                company.value.province = response.data.payload.province;
                                company.value.country = 'Polska';
                            } else {
                                toast.error(response.data.message);
                            }
                        })
                        .catch(function (error) {

                            toast.error(error);
                        });
                })
            }

            const save = () => {
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.post('api/company/create', {
                        regon: company.value.regon,
                        nip: company.value.nip,
                        company_name: company.value.company_name,
                        city: company.value.city,
                        street: company.value.street,
                        flat_nr: company.value.loc_nr,
                        house_nr: company.value.house_nr,
                        postcode: company.value.postcode,
                        province: company.value.province,
                        country: company.value.country,
                        krs: company.value.krs
                    })
                        .then(response => {

                            if (response.data.success) {
                                window.location.href = '/profiles';
                                // router.push({path: 'profiles'});
                                // toast.success(response.data.message);
                            } else {
                                toast.error(response.data.message);
                            }
                        })
                        .catch(function (error) {
                            toast.error(error);
                        });
                })
            }

            onMounted(() => {
                // getCompaniesRepositories('');
                cash("body")
                    .removeClass("error-page")

            });
            return {
                teams,
                company,
                searchKRS,
                searchNip,
                searchRegon,
                save
            }
        }
    }
</script>
