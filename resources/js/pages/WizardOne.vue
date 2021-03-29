<template>
    <div>
        <div class="flex items-center mt-8">
            <h2 class="intro-y text-lg font-medium mr-auto">Kreator profilu</h2>
        </div>
        <!-- BEGIN: Wizard Layout -->
        <div class="intro-y box py-10 sm:py-20 mt-5">
            <div class="flex justify-center">
                <button class="intro-y w-10 h-10 rounded-full btn btn-primary mx-2">
                    1
                </button>
                <button
                    class="intro-y w-10 h-10 rounded-full btn btn-primary mx-2"
                >
                    2
                </button>
                <button
                    class="intro-y w-10 h-10 rounded-full btn bg-gray-200 dark:bg-dark-1 text-gray-600 mx-2"
                >
                    3
                </button>
            </div>
            <div class="px-5 mt-10">
                <div class="font-medium text-center text-lg">Firma</div>
                <div class="text-gray-600 text-center mt-2">
                    Uzupełnij dane firmowe
                </div>
            </div>
            <div
                class="px-5 sm:px-20 mt-10 pt-10 border-t border-gray-200 dark:border-dark-5"
            >
                <!--                <div class="font-medium text-base">Profile Settings</div>-->
                <div class="grid grid-cols-12 gap-4 gap-y-5 mt-5">
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-1" class="form-label">Nazwa firmy</label>
                        <input
                            id="input-wizard-1"
                            type="text"
                            class="form-control"
                            v-model="name"
                        />
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-2" class="form-label">NIP</label>
                        <input
                            id="input-wizard-2"
                            type="text"
                            class="form-control"
                            v-model="nip"
                        />
                        <button class="btn btn-primary w-1/4 mt-2" @click="searchNip">Szukaj po NIP</button>
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-3" class="form-label">REGON</label>
                        <input
                            id="input-wizard-3"
                            type="text"
                            class="form-control"
                            v-model="regon"
                        />
                        <button class="btn btn-primary w-1/4 mt-2" @click="searchRegon">Szukaj po REGON</button>
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-4" class="form-label">KRS</label>
                        <input
                            id="input-wizard-4"
                            type="text"
                            class="form-control"
                            v-model="krs"
                        />
                        <button class="btn btn-primary w-1/4 mt-2" @click="searchKRS">Szukaj po KRS</button>
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-5" class="form-label">Miejscowość</label>
                        <input
                            id="input-wizard-5"
                            type="text"
                            class="form-control"
                            v-model="city"
                        />
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-6" class="form-label">Ulica</label>
                        <input
                            id="input-wizard-6"
                            type="text"
                            class="form-control"
                            v-model="street"
                        />
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-5" class="form-label">Nr domu</label>
                        <input
                            id="input-wizard-7"
                            type="text"
                            class="form-control"
                            v-model="house_nr"
                        />
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-6" class="form-label">Nr lokalu</label>
                        <input
                            id="input-wizard-8"
                            type="text"
                            class="form-control"
                            v-model="loc_nr"
                        />
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-5" class="form-label">Kod pocztowy</label>
                        <input
                            id="input-wizard-9"
                            type="text"
                            class="form-control"
                            v-model="postcode"
                        />
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-6" class="form-label">Poczta</label>
                        <input
                            id="input-wizard-10"
                            type="text"
                            class="form-control"
                            v-model="loc_nr"
                        />
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-5" class="form-label">Województwo</label>
                        <input
                            id="input-wizard-11"
                            type="text"
                            class="form-control"
                            v-model="voivodeship"
                        />
                    </div>
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label for="input-wizard-6" class="form-label">Kraj</label>
                        <input
                            id="input-wizard-12"
                            type="text"
                            class="form-control"
                            v-model="country"
                        />
                    </div>
                    <div
                        class="intro-y col-span-12 flex items-center justify-center sm:justify-end mt-5"
                    >
                        <button class="btn btn-secondary w-24" @click="$router.push('kreator')">Wstecz</button>
                        <button class="btn btn-primary w-24 ml-2" @click="handleSubmit">Dalej</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Wizard Layout -->
    </div>
</template>

<script>
    import {defineComponent, onMounted} from "vue";
    import DarkModeSwitcher from "../components/dark-mode-switcher/Main.vue";
    import cash from "cash-dom";
    import {useToast} from "vue-toastification";

    const toast = useToast();

    export default {
        components: {
            DarkModeSwitcher
        },
        setup() {
            onMounted(() => {
                cash("body")
                    .removeClass("main")
                    .removeClass("error-page")
                    .addClass("login");
            });
        },
        data() {
            return {
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
        methods: {
            handleSubmit() {
                this.$axios.get('/sanctum/csrf-cookie').then(response => {
                    this.$axios.post('api/company/create', {
                        regon : this.regon,
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
                            if (response.data.success) {
                                if (response.data.success) {

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
            searchNip() {
                if (this.nip != '') {
                    this.search(this.nip);
                } else {
                    toast.warning('NIP nie może być pusty');
                }

            },
            searchRegon() {
                if (this.regon != '') {
                    this.search(this.regon);
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
