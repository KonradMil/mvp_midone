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
                    class="intro-y w-10 h-10 rounded-full btn bg-gray-200 dark:bg-dark-1 text-gray-600 mx-2">
                    2
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
<!--                <GoogleMap-->
<!--                    api-key="AIzaSyBsKJBCpnTAnjhzE1psl0yIUO3YDWny2Ew"-->
<!--                    style="width: 100%; height: 500px"-->
<!--                    :center="{ lat: 53.0510715, lng: 18.6029603 }"-->
<!--                    :zoom="15"-->
<!--                >-->
<!--                    <Marker v-for="marker in markers" :options="{ position: marker }"/>-->
<!--                </GoogleMap>-->

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
                    <div class="intro-y col-span-4 sm:col-span-4" id="dr">
                        <div v-if="avatar_path != ''" class="row" id="prev" style="width: 100%;    position: absolute;
    max-height: 120px;
    top: 15px;
    overflow: hidden;">
                            <div :style="'background-image: url(' + avatar_path + ');     width: 200px;\n'+
'    height: 120px;\n'+
'    background-size: contain;\n'+
'    background-repeat: no-repeat;\n'+
'    margin: 0 auto;'"></div>
<!--                            <img class="avatar-preview"  :src="avatar_path"/>-->
                        </div>
                        <Dropzone
                            ref-key="dropzoneSingleRef"
                            :options="{
                              url: '/api/avatar/store',
                              thumbnailWidth: 150,
                              maxFilesize: 4,
                              maxFiles: 1,
                              previewTemplate: '<div style=\'display: none\'></div>'
                            }"
                            style="height: 153px;"
                            class="dropzone">
                            <div class="text-lg font-medium">
                                Kliknij lub upuść swój awatar
                            </div>
                        </Dropzone>
<!--                        <button v-if="avatar_path != ''" @onClick="avatar_path.value = ''"-->
<!--                                class="btn btn-danger mr-1 mb-2">-->
<!--                            <TrashIcon class="w-5 h-5"/>-->
<!--                        </button>-->
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
    import {defineComponent, ref, onMounted, provide} from "vue";
    import DarkModeSwitcher from "../components/dark-mode-switcher/Main.vue";
    import cash from "cash-dom";
    import Dropzone from '../global-components/dropzone/Main'
    import {useToast} from "vue-toastification";
    import {useStore} from "../store";

    const toast = useToast();
    const store = useStore();


    export default {
        components: {
            DarkModeSwitcher,
            Dropzone
        },

        setup() {
            const toast = useToast();
            const dropzoneSingleRef = ref();
            const avatar_path = ref();
            provide("bind[dropzoneSingleRef]", el => {
                dropzoneSingleRef.value = el;
            });

            onMounted(() => {
                const elDropzoneSingleRef = dropzoneSingleRef.value;

                elDropzoneSingleRef.dropzone.on("success", (resp) => {

                    avatar_path.value = '/s3/avatars/' + JSON.parse(resp.xhr.response).payload;
                    toast.success('Avatar został załadowany poprawnie!');
                });
                elDropzoneSingleRef.dropzone.on("error", () => {
                    toast.error("Błąd");
                });
                avatar_path.value = '';
                cash("body")
                    .removeClass("error-page")

            });

            return {avatar_path};
        },
        mounted() {

            this.name = store.state.login.user.name;
            this.lastname = store.state.login.user.lastname;
            // this.getMarkers();
        },
        data() {
            return {
                name: "",
                lastname: "",
                error: null,
                markers: [],
                image_path: '',
                init: {
                    streetViewControl: true,
                    scaleControl: true,
                    center: {lat: 54.04924594193164, lng: 18.04924594193164},
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

                            this.markers = m;
                        })
                })
            },
            next() {
                if( (this.lastname == '' || this.lastname == null) || (this.name == '' || this.name == null)) {
                    toast.warning('Imię i nazwisko nie mogą być puste.');
                } else {
                    this.$axios.get('/sanctum/csrf-cookie').then(response => {
                        this.$axios.post('api/profile/update', {
                            name: this.name,
                            lastname: this.lastname
                        })
                            .then(response => {

                                if (response.data.success) {
                                    let user = response.data.payload;
                                    store.dispatch('login/login', {
                                        user
                                    });
                                    toast.success('Pomyślnie przeszedłeś do kolejnego kroku!');
                                    window.location.href = '/kreator-krok-jeden';
                                } else {
                                    toast.error(response.data.message);
                                }
                            })
                    })
                }

            }
        },
    }
</script>
<style>
#dr .dz-message {
    position: absolute;
    bottom: calc(50% - 15px);
    left: calc(50% - 115px);
}
</style>
