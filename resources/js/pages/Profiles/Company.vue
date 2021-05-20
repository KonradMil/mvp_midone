<template>
    <div class="intro-y box lg:mt-5">
        <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">
                {{$t('profiles.personality')}}
            </h2>
        </div>
        <form @submit.prevent="handleSubmit">
            <div class="p-5">
                <div class="flex flex-col-reverse xl:flex-row flex-col">
                    <div class="flex-1 mt-6 xl:mt-0">
                        <div class="grid grid-cols-12 gap-x-5">
                            <div class="col-span-12 xxl:col-span-6">
                                <div class="mt-3">
                                    <label for="input-wizard-1" class="form-label">{{ $t('profiles.companyName') }}</label>
                                    <input
                                        id="input-wizard-1"
                                        type="text"
                                        class="form-control"
                                        v-model="company.company_name"/>
                                </div>
                                <div class="mt-3">
                                    <label for="input-wizard-2" class="form-label">NIP</label>
                                    <input
                                        id="input-wizard-2"
                                        type="text"
                                        class="form-control"
                                        v-model="company.nip"
                                    />
                                    <button class="btn btn-primary w-1/4 mt-2" @click="searchNip">{{ $t('profiles.searchFor') }} NIP</button>
                                </div>
                            </div>
                            <div class="col-span-12 xxl:col-span-6">
                                <div class="mt-3">
                                    <label for="input-wizard-3" class="form-label">REGON</label>
                                    <input
                                        id="input-wizard-3"
                                        type="text"
                                        class="form-control"
                                        v-model="company.regon"
                                    />
                                    <button class="btn btn-primary w-1/3 mt-2" @click="searchRegon">{{ $t('profiles.searchFor') }} REGON</button>
                                </div>
                                <div class="mt-3">
                                    <label for="input-wizard-4" class="form-label">KRS</label>
                                    <input
                                        id="input-wizard-4"
                                        type="text"
                                        class="form-control"
                                        v-model="company.krs"
                                    />
                                    <button class="btn btn-primary w-1/4 mt-2" @click="searchKRS">{{ $t('profiles.searchFor') }} KRS</button>
                                </div>
                            </div>
                            <div class="col-span-12 xxl:col-span-6">
                                <div class="mt-3">
                                    <label for="input-wizard-5" class="form-label">{{ $t('profiles.city') }}</label>
                                    <input
                                        id="input-wizard-5"
                                        type="text"
                                        class="form-control"
                                        v-model="company.city"
                                    />
                                </div>
                                <div class="mt-3">
                                    <label for="input-wizard-6" class="form-label">{{ $t('profiles.street') }}</label>
                                    <input
                                        id="input-wizard-6"
                                        type="text"
                                        class="form-control"
                                        v-model="company.street"
                                    />
                                </div>
                            </div>
                            <div class="col-span-12 xxl:col-span-6">
                                <div class="mt-3">
                                    <label for="input-wizard-5" class="form-label">{{ $t('profiles.houseNumber') }}</label>
                                    <input
                                        id="input-wizard-7"
                                        type="text"
                                        class="form-control"
                                        v-model="company.house_nr"
                                    />
                                </div>
                                <div class="mt-3">
                                    <label for="input-wizard-6" class="form-label">{{ $t('profiles.flatNumber') }}</label>
                                    <input
                                        id="input-wizard-8"
                                        type="text"
                                        class="form-control"
                                        v-model="company.loc_nr"
                                    />
                                </div>
                            </div>
                            <div class="col-span-12 xxl:col-span-6">
                                <div class="mt-3">
                                    <label for="input-wizard-5" class="form-label">{{ $t('profiles.postCode') }}</label>
                                    <input
                                        id="input-wizard-9"
                                        type="text"
                                        class="form-control"
                                        v-model="company.postcode"
                                    />
                                </div>
                                <div class="mt-3">
                                    <label for="input-wizard-6" class="form-label">{{ $t('profiles.flatNumber') }}</label>
                                    <input
                                        id="input-wizard-8"
                                        type="text"
                                        class="form-control"
                                        v-model="company.loc_nr"
                                    />
                                </div>
                            </div>
                            <div class="col-span-12 xxl:col-span-6">
                                <div class="mt-3">
                                    <label for="input-wizard-5" class="form-label">{{ $t('profiles.province') }}</label>
                                    <input
                                        id="input-wizard-11"
                                        type="text"
                                        class="form-control"
                                        v-model="company.voivodeship"
                                    />
                                </div>
                                <div class="mt-3">
                                    <label for="input-wizard-6" class="form-label">{{ $t('profiles.country') }}</label>
                                    <input
                                        id="input-wizard-12"
                                        type="text"
                                        class="form-control"
                                        v-model="company.country"
                                    />
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary w-20 mt-3" @click="saveCompany">{{ $t('global.save') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import {defineComponent, onMounted, ref} from "vue";
import DarkModeSwitcher from "../../components/dark-mode-switcher/Main.vue";
import cash from "cash-dom";
import GetTeams from "../../compositions/GetTeams";
import {useToast} from "vue-toastification";

const toast = useToast();

export default {
    components: {
        DarkModeSwitcher
    },
    setup() {
        const user = window.Laravel.user;
        const teams = ref([]);
        // const companies = ref([]);

        // const getCompaniesRepositories = async () =>{
        //     companies.value = GetCompanies();
        // }
        const getTeamsRepositories = async () => {
            teams.value = GetTeams();
            console.log(teams.value);
        }
        onMounted(() => {
            // getCompaniesRepositories('');
            getTeamsRepositories('');
            cash("body")
                .removeClass("error-page")

        });
        return {
            teams,
            // companies
        }
    },
    data() {
        return {
            company: {},
            name: '',
            krs: '',
            nip: '',
            regon: '',
            city: '',
            street: '',
            loc_nr: '',
            house_nr: '',
            postcode: '',
            voivodeship: '',
            country: '',
            error: null
        }
    },
    created() {
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get('api/company/get')
                .then(response => {
                    this.company = response.data.payload[0]
                    console.log(response.data);
                })
                .catch(function (error) {
                    console.log(error);
                });
        })
    },
    methods: {
        handleSubmit() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('api/company/create', {
                    regon: this.regon,
                    nip: this.nip,
                    company_name: this.name,
                    city: this.city,
                    street: this.street,
                    flat_nr: this.loc_nr,
                    house_nr: this.house_nr,
                    postcode: this.postcode,
                    province: this.voivodeship,
                    country: this.country,
                    krs: this.krs
                })
                    .then(response => {
                        console.log(response.data)
                        // ??
                        if (response.data.success) {
                            this.$router.push('/kreator-krok-dwa');
                        } else {
                            toast.error(response.data.message);
                        }
                    })
                    .catch(function (error) {
                        toast.error(error);
                    });
            })
        },
        searchNip() {
            if (this.company.nip != '') {
                this.search(this.company.nip);
            } else {
                toast.warning('NIP nie może być pusty');
            }

        },
        searchRegon() {
            if (this.company.regon != '') {
                this.search(this.company.regon);
            } else {
                toast.warning('REGON nie może być pusty');
            }
        },
        searchKRS() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('api/company/search/krs', {
                    krs: this.krs
                })
                    .then(response => {
                        console.log(response.data)
                        if (response.data.success) {
                            if (response.data.success) {
                                this.regon = response.data.payload[0].regon;
                                this.nip = response.data.payload[0].nip;
                                this.city = response.data.payload[0].postalCityName;
                                this.name = response.data.payload[0].name;
                                this.street = response.data.payload[0].streetName;
                                this.loc_nr = response.data.payload[0].flatNr;
                                this.house_nr = response.data.payload[0].homeNr;
                                this.postcode = response.data.payload[0].postalCode;
                                this.voivodeship = response.data.payload[0].voivodshipName;
                                this.country = 'Polska';
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
        },
        search(val) {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('api/company/search/nip', {
                    nip: val
                })
                    .then(response => {
                        console.log(response.data)
                        if (response.data.success) {
                            this.regon = response.data.payload[0].regon;
                            this.nip = response.data.payload[0].nip;
                            this.city = response.data.payload[0].postalCityName;
                            this.name = response.data.payload[0].name;
                            this.street = response.data.payload[0].streetName;
                            this.loc_nr = response.data.payload[0].flatNr;
                            this.house_nr = response.data.payload[0].homeNr;
                            this.postcode = response.data.payload[0].postalCode;
                            this.voivodeship = response.data.payload[0].voivodshipName;
                            this.country = 'Polska';
                        } else {
                            toast.error(response.data.message);
                        }
                    })
                    .catch(function (error) {
                        toast.error(error);
                    });
            })
        }
    },
}
</script>

<style scoped>

</style>
