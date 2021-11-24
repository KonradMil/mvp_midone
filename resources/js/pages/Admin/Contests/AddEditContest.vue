<template>
    <div>
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">{{ $t('challengesNew.new') }}</h2>
            <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                <Button text="Powrót" classes="mr-2 ml-auto sm:ml-0" @buttonClicked="$router.back()"></Button>
                <Button text="global.save" classes="mr-2 ml-auto sm:ml-0" @buttonClicked="saveContest">
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
                           v-model="contest.name"/>
                </div>
                <div class="post intro-y box mt-5">
                    <div class="post__tabs nav nav-tabs flex-col sm:flex-row flex-wrap bg-gray-300 dark:bg-dark-2 text-gray-600" role="tablist">
                        <Tippy
                            id="content-tab"
                            tag="a"
                            content="Fill in the article content"
                            data-toggle="tab"
                            data-target="#content"
                            href="javascript:;"
                            class="w-full sm:w-80 py-4 text-center flex justify-center items-center active"
                            role="tab"
                            aria-controls="content"
                            aria-selected="true"
                            @click="tab = 'basic'">
                            <CodeIcon class="w-4 h-4 mr-2"/>
                            Podstawowe informacje
                        </Tippy>
                    </div>
                    <div class="post__content tab-content">
                        <div id="content" class="tab-pane p-5 active" role="tabpanel" aria-labelledby="content-tab" v-if="tab == 'basic'">
                            <div class="border border-gray-200 dark:border-dark-5 rounded-md p-5">
                                <div class="font-medium flex items-center border-b border-gray-200 dark:border-dark-5 pb-5 mt-3">
                                    {{ $t('challengesNew.description') }}
                                </div>
                                <div class="mt-5">
                                    <textarea v-model="contest.description" class="w-full h-36 form-control" style="width: 100%;"></textarea>
                                </div>
                                <div class="font-medium flex items-center border-b border-gray-200 dark:border-dark-5 pb-5 mt-3">
                                    Dodatkowy css
                                </div>
                                <div class="mt-5">
                                    <textarea v-model="contest.custom_css" class="w-full h-36 form-control" style="width: 100%;"></textarea>
                                </div>
                                <div class="font-medium flex items-center border-b border-gray-200 dark:border-dark-5 pb-5 mt-3">
                                  Zadania
                                </div>
                                <div class="mt-5">
                                    <JSONObjectCreator column-number="2" :column-names="['Playground ID', 'Opis']" @update="updateCustomFunctions"></JSONObjectCreator>
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
                        <TerraInput type="text" placeholder="Nazwa organizacji" v-model:val="contest.organization"></TerraInput>
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
    name: "AddEditContest",
    components: {JSONObjectCreator, Button, Box, TerraInput, Swatches, Dropzone, Multiselect, Label},
    props: {
        contest_id: Number,
    },
    setup(props) {
        const {t, locale} = useI18n({useScope: 'global'})
        const toast = useToast();
        const id = ref();
        const user = window.Laravel.user;
        const showModal = ref(false);
        const files = ref([]);
        const tab = ref('basic');


        const contest = reactive({
            name: '',
            description: '',
            organization: '',
            tasks: '',
            custom_css: ''
        })

        const modalClosed = () => {
            showModal.value = false;
        }

        const saveShowroom = () => {
            RequestHandler('admin/contests/save', 'POST', {
                    showroom: showroom
            });
        }

        const deleteFile = () => {

        }
        const updateCustomFunctions = (data) => {
            contest.tasks = data;
        }


        onMounted(() => {
            cash("body").removeClass("error-page");

            if (props.contest_id != undefined) {
                id.value = props.contest_id;
            }
        });

        return {
            modalClosed,
            showModal,
            files,
            user,
            saveShowroom,
            deleteFile,
            contest,
            tab,
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
