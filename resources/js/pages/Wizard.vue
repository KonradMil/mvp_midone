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
                    class="intro-y w-10 h-10 rounded-full btn bg-gray-200 dark:bg-dark-1 text-gray-600 mx-2"
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
                <div class="font-medium text-center text-lg">Dane podstawowe</div>
                <div class="text-gray-600 text-center mt-2">
                    Aby zacząć uzupełnij podstawowe dane.
                </div>
            </div>
            <div
                class="px-5 sm:px-20 mt-10 pt-10 border-t border-gray-200 dark:border-dark-5"
            >
<!--                <div class="font-medium text-base">Profile Settings</div>-->
                <div class="grid grid-cols-12 gap-4 gap-y-5 mt-5">
                    <div class="col-span-2"></div>
                    <div class="intro-y col-span-4 sm:col-span-4">
                        <div class="row">
                            <label for="input-wizard-1" class="form-label">Imię</label>
                            <input
                                id="input-wizard-1"
                                type="text"
                                class="form-control"
                                placeholder="Jan"
                                v-model="name"
                            />
                        </div>
                        <div class="row" style="margin-top: 20px;">
                        <label for="input-wizard-2" class="form-label">Nazwisko</label>
                        <input
                            id="input-wizard-2"
                            type="text"
                            class="form-control"
                            placeholder="Kowalski"
                            v-model="lastname"
                        />
                        </div>
                    </div>
                    <div class="intro-y col-span-4 sm:col-span-4">
                        <GoogleMap :init="initializeGoogleMap" :markers="markers" />
                        <Dropzone
                            ref-key="dropzoneSingleRef"
                            :options="{
                  url: '/api/avatar/store',
                  thumbnailWidth: 150,
                  maxFilesize: 4,
                  maxFiles: 1,

                }"
                            class="dropzone"
                        >
                            <div class="text-lg font-medium">
                               Wgraj swój awatar
                            </div>
                        </Dropzone>
                    </div>

                    <div
                        class="intro-y col-span-12 flex items-center justify-center sm:justify-end mt-5"
                    >
<!--                        <button class="btn btn-secondary w-24" disabled>Previous</button>-->
                        <button class="btn btn-primary w-24 ml-2" @click="next">Dalej</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Wizard Layout -->
    </div>
</template>

<script>
    import { defineComponent, ref, onMounted, provide } from "vue";
    import DarkModeSwitcher from "../components/dark-mode-switcher/Main.vue";
    import cash from "cash-dom";
    import Dropzone from '../global-components/dropzone/Main'
    import { useToast } from "vue-toastification";
    import {useStore} from "../store";
    import GoogleMap from 'googlemaps-vue3'
    const toast = useToast();
    const store = useStore();


    export default {
        components: {
            DarkModeSwitcher,
            Dropzone
        },
        setup() {

            const initializeGoogleMap = {
                streetViewControl: true,
                scaleControl: true,
                center: { lat: 34.04924594193164, lng: 34.04924594193164 },
                zoom: 2,
            };
            const toast = useToast();
            const dropzoneSingleRef = ref();
            provide("bind[dropzoneSingleRef]", el => {
                dropzoneSingleRef.value = el;
            });

            onMounted(() => {
                    const elDropzoneSingleRef = dropzoneSingleRef.value;
                    elDropzoneSingleRef.dropzone.on("success", (resp) => {

                    });
                    elDropzoneSingleRef.dropzone.on("error", () => {
                        toast.error("Błąd");
                    });
                cash("body")
                    .removeClass("main")
                    .removeClass("error-page")
                    .addClass("login");
            });
        },
        mounted() {
            console.log(store.state);
          this.name = store.state.login.user.name;
          this.lastname = store.state.login.user.lastname;
          this.getMarkers();
        },
        data() {
            return {
                name: "",
                lastname: "",
                error: null,
                markers: {}
            }
        },
        methods: {
            getMarkers() {
                this.$axios.get('/sanctum/csrf-cookie').then(response => {
                    this.$axios.post('api/locations/get')
                        .then(response => {
                          this.markers = response.data;
                        })
                })
            },
            next() {
                this.$axios.get('/sanctum/csrf-cookie').then(response => {
                    this.$axios.post('api/profile/update', {
                        name: this.name,
                        lastname: this.lastname
                    })
                        .then(response => {
                            console.log(response.data)
                            if (response.data.success) {
                                let user = response.data.payload;
                                store.dispatch('login/login', {
                                    user
                                });
                                this.$router.push('/kreator-krok-jeden');
                            } else {
                                toast.error(response.data.message);
                            }
                        })
                    // .catch(function (error) {
                    //     this.toast.error(error);
                    // });
                })
            }
        },
    }
</script>
