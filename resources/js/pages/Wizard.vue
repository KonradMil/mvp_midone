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
                <GoogleMap
                    api-key="AIzaSyBsKJBCpnTAnjhzE1psl0yIUO3YDWny2Ew"
                    style="width: 100%; height: 500px"
                    :center="{ lat: 53.0510715, lng: 18.6029603 }"
                    :zoom="15"
                >
                    <Marker  v-for="marker in markers" :options="{ position: marker }" />
                </GoogleMap>

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
                        <img
                            :src="state._image"
                        />
                        <button
                            v-show="!state._file.state || state._file.state === 'success' || state._file.state === 'error'"
                            @click="select"
                        >
                            Upload
                        </button>
<!--                        <Dropzone-->
<!--                            ref-key="dropzoneSingleRef"-->
<!--                            :options="{-->
<!--                  url: '/api/avatar/store',-->
<!--                  thumbnailWidth: 150,-->
<!--                  maxFilesize: 4,-->
<!--                  maxFiles: 1,-->

<!--                }"-->
<!--                            class="dropzone"-->
<!--                        >-->
<!--                            <div class="text-lg font-medium">-->
<!--                               Wgraj swój awatar-->
<!--                            </div>-->
<!--                        </Dropzone>-->
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
    import { defineComponent, ref, onMounted, provide, onBeforeUnmount, reactive } from "vue";
    import DarkModeSwitcher from "../components/dark-mode-switcher/Main.vue";
    import cash from "cash-dom";
    import Dropzone from '../global-components/dropzone/Main'
    import { useToast } from "vue-toastification";
    import {useStore} from "../store";
    import { GoogleMap, Marker } from 'vue3-google-map'
    import {useUpload      } from '@websanova/vue-upload/src/v3.js';

    const toast = useToast();
    const store = useStore();


    export default {
        components: {
            DarkModeSwitcher,
            Dropzone,
            GoogleMap,
            Marker
        },

        setup() {
            const toast = useToast();
            const dropzoneSingleRef = ref();
            // provide("bind[dropzoneSingleRef]", el => {
            //     dropzoneSingleRef.value = el;
            // });
            //
            onMounted(() => {
            //         const elDropzoneSingleRef = dropzoneSingleRef.value;
            //         elDropzoneSingleRef.dropzone.on("success", (resp) => {
            //
            //         });
            //         elDropzoneSingleRef.dropzone.on("error", () => {
            //             toast.error("Błąd");
            //         });
                upload.on('demo-single', {
                    url: 'api/avatar/store',
                    accept: 'image/*',
                    startOnSelect: true,
                    maxSizePerFile: 1024 * 1024 * 3,
                    extensions: ['gif', 'png', 'jpg', 'jpeg'],
                    onSelect: (files, res) => {
                        console.log('onSelect');
                        console.log(files);
                        // Add some additional data to the request.
                        upload.option('demo-single', 'body', {
                            some_id: 1
                        });
                        // Load a preview first.
                        upload.file('demo-single').preview((file) => {
                            state.file.image = file.$raw;
                        });
                    },
                    onProgress(file, res) {
                        console.log('onProgress');
                        console.log(file);
                        console.log(res);
                    },
                    onSuccess: (file, res) => {
                        console.log('onSuccess');
                        console.log(file);
                        console.log(res);
                        // On success we can update whatever we need
                        // to locally, for instance the user avatar.
                        state.file = res.data.data;
                    },
                    onError: (file, res) => {
                        console.log('onError');
                        console.log(file);
                        console.log(res);
                    },
                    onEnd(files, res) {
                        console.log('onEnd');
                    }
                });
                cash("body")
                    .removeClass("main")
                    .removeClass("error-page")
                    .addClass("login");
            });

            onBeforeUnmount(() => {
                upload.off('demo-single');
            });

            const upload = useUpload();
            const state = reactive({
                file: {
                    image: null
                },
                _file: computed(() => {
                    return upload.file('demo-single');
                }),
                _image: computed(() => {
                    return state.file.image || '//www.gravatar.com/avatar/?d=robohash&s=320';
                })
            });

            return {
                state,
                start,
                select,
            };
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
                markers: [],
                init:{
                    streetViewControl: true,
                    scaleControl: true,
                    center: { lat: 54.04924594193164, lng: 18.04924594193164 },
                    zoom: 9,
                }
            }
        },
        methods: {
            getMarkers() {
                this.$axios.get('/sanctum/csrf-cookie').then(response => {
                    this.$axios.post('api/locations/get')
                        .then(response => {
                            let m = [];
                          response.data.forEach(function (item) {
                                m.push({lat: parseFloat(item.lat), lng: parseFloat(item.lng)});
                          });
                            console.log(m);
                            this.markers = m;
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
