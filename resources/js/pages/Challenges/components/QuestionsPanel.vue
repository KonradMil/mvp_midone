<template>
    <div class="col-span-12 lg:col-span-8 xxl:col-span-9">
        <div class="grid grid-cols-12 gap-6">
            <!-- BEGIN: Announcement -->
            <div class="intro-y box col-span-12">
                <div class="add" v-if="addingDialog">
                    <div
                        class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5"
                    >
                        <h2 class="font-medium text-base mr-auto">Zadaj pytanie</h2>
                    </div>
                    <div class="flex px-5 py-3">
                        <textarea v-model="question" class="w-full h-36 form-control"></textarea>
                    </div>
                    <div class="flex px-5 py-3">
                        <button
                            class="dropdown-toggle btn mr-2 shadow-md flex items-center  ml-auto sm:ml-0"
                            aria-expanded="false"
                            @click="close"
                        >
                            Cofnij
                        </button>
                        <button
                            class="dropdown-toggle btn btn-primary mr-2 shadow-md flex items-center  ml-auto sm:ml-0"
                            aria-expanded="false"
                            @click="saveQuestion"
                        >
                            <SaveIcon class="w-4 h-4 mr-2"/>
                            {{$t('global.save')}}
                        </button>
                    </div>
                </div>
                <div class="inbox" v-if="!addingDialog">
                    <div class="p-5 flex flex-col-reverse sm:flex-row text-gray-600 border-b border-gray-200 dark:border-dark-1">
                        <div class="flex items-center mt-3 sm:mt-0 border-t sm:border-0 border-gray-200 pt-5 sm:pt-0 mt-5 sm:mt-0 -mx-5 sm:mx-0 px-5 sm:px-0">
                            <button
                                type="button"
                                class="btn text-gray-700 dark:text-gray-300 w-full bg-white dark:bg-theme-1 mt-1"
                                @click="addingDialog = true"
                            >
                                <Edit3Icon class="w-4 h-4 mr-2" /> Dodaj pytanie
                            </button>
                        </div>
<!--                        <div class="flex items-center sm:ml-auto">-->
<!--                            <div class="dark:text-gray-300">1 - 50 of 5,238</div>-->
<!--                            <a href="javascript:;" class="w-5 h-5 ml-5 flex items-center justify-center dark:text-gray-300">-->
<!--                                <ChevronLeftIcon class="w-4 h-4"/>-->
<!--                            </a>-->
<!--                            <a href="javascript:;" class="w-5 h-5 ml-5 flex items-center justify-center dark:text-gray-300">-->
<!--                                <ChevronRightIcon class="w-4 h-4"/>-->
<!--                            </a>-->
<!--                        </div>-->
                    </div>
                    <div class="overflow-x-auto sm:overflow-x-visible">
                        <div
                            v-for="(q, index) in questions"
                            :key="'question_' + index"
                            class="intro-y">
                            <div class="inbox__item inline-block sm:block text-gray-700 dark:text-gray-500 bg-gray-100 dark:bg-dark-1 border-b border-gray-200 dark:border-dark-1">
                                <div class="flex px-5 py-3">
                                    <div class="w-64 sm:w-auto truncate">
                                        <strong>Pytanie: </strong> {{q.question}}
                                    </div>
                                    <div class="inbox__item--time whitespace-nowrap ml-auto pl-10">
                                        {{ $dayjs(q.created_at).format('DD.MM.YYYY HH:mm') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Daily Sales -->
        </div>
    </div>
</template>

<script>
import {computed, getCurrentInstance, onMounted, reactive, ref} from "vue";
import SaveQuestion from "../../../compositions/SaveQuestion";
import GetQuestions from "../../../compositions/GetQuestions";

export default {
    name: "QuestionsPanel",
    props: {
      id: Number
    },
    setup(props) {
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        const addingDialog = ref(false);
        const question = ref('');
        const questions = ref([]);

        const saveQuestion = () => {
            SaveQuestion({challenge_id: props.id, question: question.value}, () => {
                addingDialog.value = false;
                getQuestions();
            });
        }

       const close = () => {
            addingDialog.value = false;
       }

       const getQuestions = () => {
            GetQuestions(props.id, (res) => {
                questions.value = res;
            });
       }

        onMounted(() => {
            getQuestions();
        });


        return {
            addingDialog,
            saveQuestion,
            question,
            questions,
            close
        }
    }
}
</script>

<style scoped>

</style>
