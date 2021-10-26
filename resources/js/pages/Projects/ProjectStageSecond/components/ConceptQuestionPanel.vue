<template>
    <div class="col-span-12 lg:col-span-8 xxl:col-span-9" v-if="guard === true">
        <div class="grid grid-cols-12 gap-6">
            <!-- BEGIN: Announcement -->
            <div class="intro-y box col-span-12">
                <div class="add" v-if="addingDialog">
                    <div class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5">
                        <h2 class="font-medium text-base mr-auto" v-if="!isAnswer">Zadaj pytanie</h2>
                        <h2 class="font-medium text-base mr-auto" v-if="isAnswer">Odpowiedz na pytanie</h2>
                    </div>
                    <div class="flex px-5 py-3">
                        <textarea v-if="!isAnswer && concept_id > 0" v-model="question" class="w-full h-36 form-control"></textarea>
                        <textarea v-if="isAnswer && concept_id > 0" v-model="questionAnswer" class="w-full h-36 form-control"></textarea>
                    </div>
                    <div class="flex px-5 py-3">
                        <button
                            class="dropdown-toggle btn mr-2 shadow-md flex items-center  ml-auto sm:ml-0"
                            aria-expanded="false"
                            @click="close">
                            Cofnij
                        </button>
                        <button
                            class="dropdown-toggle btn btn-primary mr-2 shadow-md flex items-center  ml-auto sm:ml-0"
                            aria-expanded="false"
                            @click="saveQuestion">
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
                                @click="addingDialog = true">
                                <Edit3Icon class="w-4 h-4 mr-2" /> Dodaj pytanie
                            </button>
                        </div>
                    </div>
                    <div class="overflow-x-auto sm:overflow-x-visible">
                        <div
                            v-for="(q, index) in questions"
                            :key="'question_' + index"
                            class="intro-y">
                            <div class="inbox__item inline-block sm:block text-gray-700 dark:text-gray-500 bg-gray-100 dark:bg-dark-1 border-b border-gray-200 dark:border-dark-1">
                                <div class="flex px-5 py-3" @click="expand[index] = !expand[index]">
                                    <div class="w-64 sm:w-auto" style="word-break: break-all;">
                                        <strong>Pytanie: </strong> {{q.question}} - (Odpowiedzi: {{q.answers.length}})
                                    </div>
                                    <div class="inbox__item--time whitespace-nowrap ml-auto pl-10">
                                        {{ $dayjs(q.created_at).format('DD.MM.YYYY HH:mm') }}
                                    </div>
                                    <div class="inbox__item--time whitespace-nowrap ml-auto pl-10" v-if="authorId == user.id || type === 'concept'">
                                        <button class="btn btn-primary" @click="addAnswer(q.id)">Odpowiedz</button>
                                    </div>
                                </div>
                                <div v-if="expand[index] === true">
                                    <div class="border px-5 py-2" v-for="(a, i) in q.answers" style="word-break: break-all;">
                                        Odpowiedź: {{ a.answer }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="questions.length == 0" class="text-theme-1 dark:text-theme-10 font-medium pl-2 py-3" style="font-size: 16px;">
                            Nie ma jeszcze żadnych pytań.
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Daily Sales -->
        </div>
    </div>
</template>

<script>
import {onMounted, ref} from "vue";
import RequestHandler from "../../../../compositions/RequestHandler";

export default {
    name: "ConceptQuestionsPanel",
    props: {
        id: Number,
        author_id: Number,
        type: String,
        concept_id: Number,
        project: Object
    },
    setup(props) {
        const addingDialog = ref(false);
        const question = ref('');
        const questions = ref([]);
        const expand = ref([]);
        const user = window.Laravel.user;
        const isAnswer = ref(false);
        const questionId = ref(null);
        const authorId = ref(0);
        const questionAnswer = ref('');
        const guard = ref(false);

        const getConceptQuestions = (callback) => {
            RequestHandler('projects/' + props.project.id + '/concept/questions', 'get', {
                concept_id: props.concept_id,
            }, (response) => {
                questions.value = response.data.conceptQuestions;
                callback();
            });
        }

        const saveQuestion = (id) => {
            if(props.concept_id > 0 && !isAnswer.value){
                RequestHandler('projects/' + props.project.id + '/concept/question/save', 'post', {
                    concept_id: props.concept_id,
                    question: question.value,
                }, (response) => {
                    addingDialog.value = false;
                    getConceptQuestions();
                });
            } else if(props.concept_id > 0 && isAnswer.value){
                RequestHandler('projects/' + props.project.id + '/concept/question/answer/save', 'post', {
                    concept_id: props.concept_id,
                    concept_question_id: questionId.value,
                    answer: questionAnswer.value,
                }, (response) => {
                    addingDialog.value = false;
                    getConceptQuestions();
                });
            }
        }

        const close = () => {
            addingDialog.value = false;
        }

        const addAnswer = (id) => {
            isAnswer.value = true;
            addingDialog.value = true;
            questionId.value = id;
        }

        onMounted(() => {
            getConceptQuestions(() => {
                guard.value = true;
            });
        });

        return {
            guard,
            questionAnswer,
            addingDialog,
            saveQuestion,
            question,
            questions,
            close,
            user,
            isAnswer,
            addAnswer,
            questionId,
            expand,
            authorId
        }
    }
}
</script>

<style scoped>

</style>
