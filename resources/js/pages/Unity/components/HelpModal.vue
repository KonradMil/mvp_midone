<template>
    <div id="help-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body p-10 text-center">
                    <h3 class="intro-y text-lg font-medium mt-5">Pomoc</h3>
                    <div class="grid grid-cols-12 gap-6 mt-5">
                        <div class="col-span-12 lg:col-span-4 xxl:col-span-3 flex lg:block flex-col-reverse">
                            <div class="intro-y box mt-5 lg:mt-0">
                                <div class="p-5 border-t border-gray-200 dark:border-dark-5">
                                    <a class="flex items-center"
                                       href=""
                                       @click.prevent="modelActiveTab = 'klawiszologia'"
                                       :class="(modelActiveTab == 'klawiszologia')? ' text-theme-1 dark:text-theme-10 font-medium' : ''">
                                        <ActivityIcon class="w-4 h-4 mr-2"/>
                                        Klawiszologia
                                    </a>
                                    <a class="flex items-center mt-5" href=""
                                       @click.prevent="modelActiveTab = 'faq'"
                                       :class="(modelActiveTab == 'faq')? ' text-theme-1 dark:text-theme-10 font-medium' : 'mt-5'">
                                        <BoxIcon class="w-4 h-4 mr-2"/>
                                        FAQ
                                    </a>
                                    <a class="flex items-center mt-5" href=""
                                       @click.prevent="modelActiveTab = 'tutorial'"
                                       :class="(modelActiveTab == 'tutorial')? ' text-theme-1 dark:text-theme-10 font-medium' : 'mt-5'">
                                        <SettingsIcon class="w-4 h-4 mr-2"/>
                                        Tutorial
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-9 lg:col-span-9 xxl:col-span-9" v-if="modelActiveTab == 'klawiszologia'">
                            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                                <h2 class="font-medium text-base mr-auto"> Klawiszologia</h2>
                            </div>
                            <div class="grid grid-cols-12 gap-6">
                                <div class="intro-y box col-span-12 xxl:col-span-12">
                                    <img src="/s3/images/klawiszologia.jpeg" class="img-fluid cursor-pointer" @click="window.open('/s3/images/klawiszologia.jpeg', '_blank').focus();"/>
                                </div>

                            </div>
                        </div>
                        <div class="col-span-9 lg:col-span-9 xxl:col-span-9" v-if="modelActiveTab == 'faq'">
                            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                                <h2 class="font-medium text-base mr-auto">FAQ</h2>
                            </div>
                            <div class="grid grid-cols-12 gap-6">
                                <div class="intro-y box col-span-12 xxl:col-span-12">

                                </div>
                            </div>
                        </div>
                        <div class="col-span-9 lg:col-span-9 xxl:col-span-9" v-if="modelActiveTab == 'tutorial'">
                            <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                                <h2 class="font-medium text-base mr-auto">Tutorial</h2>
                            </div>
                            <div class="grid grid-cols-12 gap-6">
                                <div class="intro-y box col-span-6 xxl:col-span-6">
                                    <div class="px-15 py-15">
                                        <button class="btn btn-primary" type="button" @click="startTutorial">Rozpocznij tutorial</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {ref} from "vue"
import useEmitter from "../../../composables/useEmitter";
export default {
    name: "HelpModal",
    setup() {
        const modelActiveTab = ref('klawiszologia');
        const emitter = useEmitter();

        const startTutorial = () => {
            emitter.emit('starttutorial', '');
        }
        return {
            modelActiveTab,
            startTutorial
        }
    }
}
</script>

<style scoped>

</style>
