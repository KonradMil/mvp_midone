<template>
    <div>
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">Dodaj SAAS</h2>
            <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                <Button text="Powrót" classes="mr-2 ml-auto sm:ml-0" @buttonClicked="$router.back()"></Button>
                <Button text="global.save" classes="mr-2 ml-auto sm:ml-0" @buttonClicked="saveSAAS">
                    <SaveIcon class="w-4 h-4 mr-2"/>
                </Button>
            </div>
        </div>
        <div class="pos intro-y grid grid-cols-12 gap-5 mt-5">
            <!-- BEGIN: Post Content -->
            <div class="intro-y col-span-12 lg:col-span-8">
                <div class="input-group mt-2">
                    <input type="text"
                           class="intro-y form-control py-3 px-4 box pr-10 placeholder-theme-13"
                           :placeholder="$t('global.name') + '*'"
                           v-model="saas.name"/>
                </div>
                <div class="post intro-y box mt-5">
                    <div class="post__content tab-content">
                        <div id="content" class="tab-pane p-5 active" role="tabpanel" aria-labelledby="content-tab">
                            <div class="border border-gray-200 dark:border-dark-5 rounded-md p-5">
                                <div class="font-medium flex items-center border-b border-gray-200 dark:border-dark-5 pb-5 mt-3">
                                    {{ $t('challengesNew.description') }}
                                </div>
                                <div class="mt-5">
                                    <textarea v-model="saas.description" class="w-full h-36 form-control" style="width: 100%;"></textarea>
                                </div>
                                <div class="font-medium flex items-center border-b border-gray-200 dark:border-dark-5 pb-5 mt-3">
                                    Dodatkowy css
                                </div>
                                <div class="mt-5">
                                    <textarea v-model="saas.custom_css" class="w-full h-36 form-control" style="width: 100%;"></textarea>
                                </div>
                                <div class="font-medium flex items-center border-b border-gray-200 dark:border-dark-5 pb-5 mt-3">
                                    Preładowane funckcje Unity
                                </div>
                                <div class="mt-5">
                                    <JSONObjectCreator column-number="2" :column-names="['Nazwa funkcji', 'Dane']" @update="updateCustomFunctions"></JSONObjectCreator>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-span-12 lg:col-span-4">
                <Box classes="p-5">
                    <div class="my-3">
                        <Label title="Organizacja"></Label>
                        <TerraInput type="text" placeholder="Nazwa organizacji" v-model:val="saas.organization_name"></TerraInput>
                    </div>
                    <div class="my-3">
                        <Label title="E-mail organizacji (@umk.gov.pl)"></Label>
                        <TerraInput type="text" placeholder="@umk..gov.pl" v-model:val="saas.email"></TerraInput>
                    </div>
                    <div class="my-3">
                        <Label title="Kolor dominujący"></Label>
                        <Swatches @colorSelected="selectedColor" class="mt-2"></Swatches>
                    </div>
                </Box>
            </div>
        </div>
    </div>
</template>

<script>
import {ref, onMounted, reactive} from "vue";
import cash from "cash-dom";
import {useToast} from "vue-toastification";
import {useI18n} from 'vue-i18n'
import Multiselect from '@vueform/multiselect'
import Dropzone from "../../../components-terraform/Dropzone";
import Swatches from "../../../components-terraform/Swatches";
import Label from "../../../components-terraform/Label";
import TerraInput from "../../../components-terraform/TerraInput";
import Box from "../../../components-terraform/Box";
import Button from "../../../components-terraform/Button";
import JSONObjectCreator from "../../../components-terraform/JSONObjectCreator";
import RequestHandler from "../../../compositions/RequestHandler";

export default {
    name: "AddEditSAAS",
    components: {JSONObjectCreator, Button, Box, TerraInput, Swatches, Dropzone, Multiselect, Label},
    props: {
        saas_id: Number,
    },
    setup(props) {
        const {t, locale} = useI18n({useScope: 'global'})
        const toast = useToast();
        const id = ref();
        const user = window.Laravel.user;
        const showModal = ref(false);
        const files = ref([]);
        const slides = ref([]);

        const saas = reactive({
            name: '',
            description: '',
            dominantColor: '',
            organization_name: '',
            email: '',
            custom_functions: '',
            custom_css: '',
            saas_id: undefined,
        })

        const modalClosed = () => {
            showModal.value = false;
        }

        const saveSAAS = () => {
            RequestHandler('admin/forum/saas/save', 'POST', {
                    saas: saas
            });
        }

        const deleteFile = () => {

        }

        const selectedColor = (color) => {
            saas.dominantColor = color;
        }

        const updateCustomFunctions = (data) => {
            saas.custom_functions = data;
        }


        onMounted(() => {
            cash("body").removeClass("error-page");

            if (props.saas_id != undefined) {
                id.value = props.saas_id;
            }
        });

        return {
            slides,
            modalClosed,
            showModal,
            files,
            user,
            saveSAAS,
            deleteFile,
            selectedColor,
            saas,
            updateCustomFunctions,
        };
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/";
        }
        next();
    }
}
</script>
<style scoped>

</style>
