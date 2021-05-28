<template>
    <div class="intro-y box pt-5">
        <div class="flex items-center p-5 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text-base mr-auto">
                {{ $t('profiles.personality') }}
            </h2>
        </div>

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
                                    <button class="btn btn-primary w-1/4 mt-2" @click.prevent="searchNip">{{ $t('profiles.searchFor') }} NIP</button>
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
                                    <button class="btn btn-primary w-1/3 mt-2" @click.prevent="searchRegon">{{ $t('profiles.searchFor') }} REGON</button>
                                </div>
                                <div class="mt-3">
                                    <label for="input-wizard-4" class="form-label">KRS</label>
                                    <input
                                        id="input-wizard-4"
                                        type="text"
                                        class="form-control"
                                        v-model="company.krs"
                                    />
                                    <button class="btn btn-primary w-1/4 mt-2" @click.prevent="searchKRS">{{ $t('profiles.searchFor') }} KRS</button>
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
                                    <label for="input-wizard-5" class="form-label">{{ $t('profiles.province') }}</label>
                                    <input
                                        id="input-wizard-11"
                                        type="text"
                                        class="form-control"
                                        v-model="company.province"
                                    />
                                </div>
                            </div>
                            <div class="col-span-12 xxl:col-span-6">
                                <div class="mt-3">
                                    <label for="input-wizard-6" class="form-label">{{ $t('profiles.country') }}</label>
                                    <input
                                        id="input-wizard-12"
                                        type="text"
                                        class="form-control"
                                        v-model="company.country"
                                    />
                                </div>
                                <div class="mt-3">

                                </div>
                            </div>
                        </div>
                        <button v-if="!isUndefined" class="btn btn-primary w-20 mt-3" type="submit" @click.prevent="save">{{ $t('global.save') }}</button>
                        <button v-if="isUndefined"  class="btn btn-primary w-20 mt-3" type="submit" @click.prevent="create">{{ $t('global.save') }}</button>
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
        const isUndefined = ref(false);

        if(user.companies[0] === undefined)
         {
             isUndefined.value = true;
         }
         else{
             company.value = user.companies[0];
         }

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
                        console.log(response.data)
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
                        console.log(response.data)
                        if (response.data.success) {
                            company.value.regon = response.data.payload.regon;
                            company.value.nip = response.data.payload.nip;
                            company.value.city = response.data.payload.city;
                            company.value.company_name = response.data.payload.name;
                            company.value.street = response.data.payload.street;
                            company.value.loc_nr = response.data.payload.loc_nr;
                            company.value.house_nr = response.data.payload.house_nr;
                            company.value.postcode = response.data.payload.postcode;
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

        const create = () => {
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post('api/company/create', {
                    regon: company.value.regon,
                    nip: company.value.nip,
                    company_name: company.value.company_name,
                    city: company.value.city,
                    street: company.value.street,
                    flat_nr: company.value.flat_nr,
                    house_nr: company.value.house_nr,
                    postcode: company.value.postcode,
                    province: company.value.province,
                    country: company.value.country,
                    krs: company.value.krs
                })
                    .then(response => {
                        console.log(response.data)
                        if (response.data.success) {
                            router.push({path: 'profiles'});
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
        const save = () => {
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post('api/company/save', {
                    id: company.value.id,
                    regon: company.value.regon,
                    nip: company.value.nip,
                    company_name: company.value.company_name,
                    city: company.value.city,
                    street: company.value.street,
                    flat_nr: company.value.flat_nr,
                    house_nr: company.value.house_nr,
                    postcode: company.value.postcode,
                    province: company.value.province,
                    country: company.value.country,
                    krs: company.value.krs
                })
                    .then(response => {
                        console.log(response.data)
                        if (response.data.success) {
                            toast.success(response.data.message);
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
            save,
            create,
            isUndefined
        }
    }
}
</script>

<style scoped>

</style>
