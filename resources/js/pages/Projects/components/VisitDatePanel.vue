<template>
    <div class="intro-y"  style="width: 1200px;">
    <div class="intro-y box shadow-2xl md:w-1/2 lg:w-1/2 xl:w-1/2 2xl:w-full sm:w-1/2 max-w-5xl" v-if="guard === true">
        <div class="intro-y flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
            <h2 class="font-medium text-base mr-auto">
                Termin wizyt
            </h2>
            <div class="flex items-center justify-center text-theme-1" style="margin-right: 400px;"
                 v-if="project.accept_visit_date === 1"><i data-feather="check-square" class="w-4 h-4 mr-2"></i></div>
            <!--            <div class="flex items-center justify-center text-theme-6" style="margin-right: 650px;" v-if="project.accept_visit_date === 2"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i>{{$t('challengesMain.rejected')}}</div>-->
            <!--            <div class="flex items-center mr-3" style="margin-right: 400px;" v-if="project.accept_visit_date < 1"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i>{{$t('challengesMain.waitingApproval')}}</div>-->
            <!--            <button v-if="challenge_author_id === user.id" class="btn btn-primary mr-6 mt-3" @click.prevent="acceptVisitDate">Zakończ wizytację</button>-->
            <div v-if="(integrator.id === user.id || investor.id === user.id) && project.accept_local_vision < 1"
                 class="pr-2">
                <button class="btn btn-primary w-15 mt-3" @click.prevent="addNewDeadline">Dodaj termin</button>
            </div>
            <!--            <button v-if="challenge.selected[0].author_id === user.id" class="btn btn-primary w-20 mt-3" @click.prevent="saveDeadlines">{{$t('profiles.save')}}</button>-->
        </div>
        <div class="intro-y inbox box mt-5 overflow-y-auto" style="max-height: 521px; overflow-x: hidden;">
            <transition-group tag="ul" name="list">
                <li v-for="deadline in deadlines" :key="deadline.id">
                    <div class="overflow-x-auto sm:overflow-x-visible">
                      <div class="intro-y">
                    <div :class="(showDetails[deadline.id] === true && deadline.accepted === 1) ? 'inbox__item inline-block sm:block text-gray-700 dark:text-gray-500 bg-gray-200 dark:bg-dark-1 border-b border-gray-200 dark:border-dark-1 md:w-1/2 lg:w-1/2 xl:w-1/2 2xl:w-full sm:w-1/2 max-w-5xl' : 'inbox__item inline-block sm:block text-gray-700 dark:text-gray-500 bg-gray-100 dark:bg-dark-1 border-b border-gray-200 dark:border-dark-1 md:w-1/2 lg:w-1/2 xl:w-1/2 2xl:w-full sm:w-1/2 max-w-5xl'">
                        <div class="flex px-5 py-3 pb-5">
                            <div @click="showDetails[deadline.id] = !showDetails[deadline.id]" class="w-70 flex-none flex items-center mr-5 mt-2"
                                 v-if="deadline.author !== undefined">
                                <Tippy
                                    tag="a"
                                    class="dark:text-gray-300 text-gray-600"
                                    content="W trakcie podejmowania decyzji">
                                    <EditIcon v-if="deadline.accepted < 1" class="w-5 h-5 mr-2 ml-2 text-red-600"/>
                                </Tippy>
                                <Tippy
                                    tag="a"
                                    class="dark:text-gray-300 text-gray-600"
                                    content="Zaakceptowano">
                                    <CheckCircleIcon v-if="deadline.accepted === 1 && deadline.status !== 1"
                                                     class="w-6 h-6 mr-2 ml-2 text-green-600"/>
                                </Tippy>
                                <Tippy
                                    tag="a"
                                    class="dark:text-gray-300 text-gray-600"
                                    content="Odrzucono">
                                    <XCircleIcon v-if="deadline.accepted === 2" class="w-6 h-6 mr-2 ml-2 text-red-600"/>
                                </Tippy>
                                <Tippy
                                    tag="a"
                                    class="dark:text-gray-300 text-gray-600"
                                    content="Odwołane">
                                    <AlertCircleIcon v-if="deadline.accepted === 1 && deadline.status === 1"
                                                     class="w-6 h-6 mr-2 ml-2 text-red-600"/>
                                </Tippy>
                                <div class="w-6 h-6 flex-none image-fit relative ml-5">
                                    <Avatar :src="'/s3/avatars/' + deadline.author.avatar"
                                            :username="deadline.author.name + ' ' + deadline.author.lastname" :size="30"
                                            color="#FFF" background-color="#5e50ac"/>
                                </div>
                                <div class="inbox__item--sender truncate ml-3" style="width: 200px;">
                                    {{ deadline.author.name }} {{ deadline.author.lastname }}
                                </div>
                            </div>
                            <div @click="showDetails[deadline.id] = !showDetails[deadline.id]" class="w-64 sm:w-auto truncate pt-5 pl-6">
                                <span class="inbox__item--highlight" v-if="deadline.author !== undefined">
                                    Proponowany termin: {{ $dayjs(deadline.date).format('DD.MM.YYYY') }} {{ deadline.time }}</span>
                                <span class="inbox__item--highlight" v-else>Dodaj termin wizyty</span>
                            </div>
                            <div @click="showDetails[deadline.id] = !showDetails[deadline.id]" class="flex px-5 py-3 pb-5 text-theme-1" style="margin-left: 60px; max-width: 250px;"
                                 v-if="deadline.author === undefined">
                                <Litepicker
                                    class="form-control"
                                    id="post-form-2"
                                    v-model="deadline.date"
                                    :options="{
                                    autoApply: false,
                                    lang: 'pl',
                                    format: 'DD.MM.YYYY',
                                    showWeekNumbers: true,
                                    buttonText: {'apply':'OK','cancel':'Anuluj'},
                                    dropdowns: {
                                       minYear: 2021,
                                       maxYear: 2023,
                                       months: true,
                                       years: true
                                        }
                                     }"/>
                                <!--                                <input style="height: 40px;"-->
                                <!--                                       type="datetime-local"-->
                                <!--                                       id="meeting-time"-->
                                <!--                                       name="meeting-time"-->
                                <!--                                       v-model="newDate"-->
                                <!--                                       min="2021-09-22T00:00"-->
                                <!--                                       max="2025-06-14T00:00">-->
                            </div>
                            <div @click="showDetails[deadline.id] = !showDetails[deadline.id]" class="flex text-theme-1" style="max-height: 35px; margin-top: 12px;"
                                 v-if="deadline.author === undefined">
                                <input id="appt-time" type="time" name="appt-time" v-model="deadline.time">
                            </div>
                            <div @click="showDetails[deadline.id] = !showDetails[deadline.id]" class="pl-8 pt-3"
                                 v-if="(deadline.author_id === integrator.id || deadline.author_id === investor.id)">
                                <div class="flex items-center justify-center text-theme-9"
                                     v-if="deadline.accepted  ===  1 && deadline.status !== 1"><i
                                    data-feather="check-square"
                                    class="w-4 h-4 mr-2"></i>{{ $t('challengesMain.accepted') }}
                                </div>
                                <div class="flex items-center justify-center text-theme-6"
                                     v-if="deadline.accepted  ===  1 && deadline.status === 1"><i
                                    data-feather="check-square" class="w-4 h-4 mr-2"></i>Odwołano
                                </div>
                                <div class="flex items-center justify-center text-theme-6"
                                     v-if="deadline.accepted  ===  2"><i data-feather="check-square" class="w-4 h-4 mr-2"></i>
                                    {{$t('challengesMain.rejected') }}
                                </div>
                                <div class="flex items-center" v-if="deadline.accepted < 1"><i
                                    data-feather="check-square"
                                    class="w-4 h-4 mr-2"></i>{{ $t('challengesMain.waitingApproval') }}
                                </div>
                            </div>
                            <div @click="showDetails[deadline.id] = !showDetails[deadline.id]" class="pt-1 pl-6 flex" style="margin-left: auto;"
                                 v-if="deadline.accepted < 1 && deadline.status < 1 && deadline.author_id !== user.id && deadline.status !== 1 && deadline.author !== undefined  && (integrator.id === user.id || investor.id === user.id)">
                                <Tippy
                                    tag="a"
                                    class="dark:text-gray-300 text-gray-600"
                                    content="Akceptuj">
                                    <button class="btn btn-primary mr-3 btn-sm"
                                            @click.prevent="acceptDeadline(deadline)">Akceptuję
                                    </button>
                                </Tippy>
                                <Tippy
                                    tag="a"
                                    class="dark:text-gray-300 text-gray-600"
                                    content="Odrzuć">
                                    <button class="btn btn-primary btn-sm" @click.prevent="rejectDeadline(deadline)">
                                        Odrzucam
                                    </button>
                                </Tippy>
                            </div>
                            <div v-if="deadline.accepted === 1 && deadline.status !== 1 && project.accept_local_vision !== 1"
                                class="pt-1 pl-6" style="margin-left: auto;">
                                <Tippy
                                    tag="a"
                                    class="dark:text-gray-300 text-gray-600"
                                    content="Odwołaj">
                                    <button class="btn btn-primary btn-sm" @click.prevent="cancelDeadline(deadline)">
                                        Odwołaj
                                    </button>
                                </Tippy>
                            </div>
                            <div class="pt-1 pl-9" style="margin-left: auto;"
                                 v-if="(deadline.author_id === user.id || deadline.accepted === 2  && deadline.accepted !== 1) && project.accept_local_vision !== 1 && deadline.accepted !== 1 ">
                                <Tippy
                                    v-if="deadline.accepted !== 1"
                                    tag="a"
                                    class="dark:text-gray-300 text-gray-600"
                                    content="Usuń">
                                    <button v-if="deadline.status !== 1" class="btn btn-primary btn-sm"
                                            @click.prevent="deleteDeadline(deadline)">Usuń
                                    </button>
                                </Tippy>
                            </div>
                            <div class="pt-1 pl-9 pt-3" v-if="deadline.author === undefined">
                                <button class="btn btn-primary mr-3 btn-sm" @click.prevent="saveDeadline(deadline)">
                                    Zapisz
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                      <ul v-if="showDetails[deadline.id] === true && deadline.accepted === 1" class="intro-y pt-4 pl-5">
                    <li class="intro-y">
                        <div class="sm:block text-gray-700 dark:text-gray-500 bg-gray-100 dark:bg-dark-1 border-b border-gray-200 dark:border-dark-1">
                            <div class="grid grid-cols-1">
                                <div class="pl-2 pt-2">
                                    <label for="input-wizard-1" class="form-label" style="margin-left: 40px;">
                                        Informacje dotyczące wizyty
                                    </label>
                                    <button
                                        v-if="deadline.author.id === user.id && deadline.status !== 1 && project.accept_local_vision !== 1"
                                        class="btn btn-primary mr-3 btn-sm" style="margin-left: 100px;"
                                        @click.prevent="saveMembers(deadline)">Zapisz
                                    </button>
                                </div>
                                <div class="pl-10 pt-2">
                                <textarea
                                    maxlength="400"
                                    :disabled="user.id !== deadline.author_id || deadline.status === 1 && project.accept_local_vision === 1"
                                    class="w-full px-3 py-2 text-gray-700 border rounded-lg border border-transparent focus:outline-none focus:ring-2 focus:ring-pink-700 focus:border-transparent"
                                    style="width: 900px; height: 100px; position: relative;"
                                    v-model="deadline.members">
                                </textarea>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
                    </div>
                </li>
            </transition-group>
            <div v-if="deadlines.length === 0" class="text-theme-1 dark:text-theme-10 font-medium pl-6 py-3 pb-4"
                 style="font-size: 16px;">
                Nie ma jeszcze żadnej propozycji terminu spotkania.
            </div>
            <!--            <div class="p-5 flex flex-col sm:flex-row items-center text-center sm:text-left text-gray-600">-->
            <!--                <div class="sm:ml-auto mt-2 sm:mt-0 dark:text-gray-300">Last account activity: 36 minutes ago</div>-->
            <!--            </div>-->
        </div>
    </div>
    </div>
</template>

<script>
import {computed, getCurrentInstance, onMounted, reactive, ref, watch} from "vue";

import {useToast} from "vue-toastification";
import RequestHandler from "../../../compositions/RequestHandler";

export default {
    name: "VisitDatePanel",
    components: {},
    props: {
        challenge_id: Number,
        author_id: Number,
        challenge_author_id: Number,
        project: Object,
        challenge: Object,
        integrator: Object,
        investor: Object
    },
    setup(props) {
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        const toast = useToast();
        const user = window.Laravel.user;
        const deadlines = ref([]);
        const showDetails = ref([]);
        const is_selected = ref(0);
        const guard = ref(false);
        const block = ref(false);
        const date = ref('');
        const inputValue = ref('');
        const inputEvents = ref('');
        const newDate = new Date();

        const addNewDeadline = async () => {
            block.value = true;
            let deadline = {
                date: '',
                time: '',
                members: '',
                accepted: 0,
                status: ''
            }
            setTimeout(function () {
                deadlines.value.unshift(deadline);
            }, 500)
            setTimeout(function () {
                block.value = false;
            }, 2000);
        }
        const deleteDeadline = async (deadline) => {
            RequestHandler('projects/' + props.project.id + '/visit-date/' + deadline.id + '/delete', 'post', {
                project_id: props.project.id,
                id: deadline.id,
            }, (response) => {
                deadlines.value.splice(deadlines.value.indexOf(deadline), 1);
            });
        }

        const saveMembers = async (deadline) => {
            RequestHandler('projects/' + props.project.id + '/visit-date/' + deadline.id + '/save_members', 'post', {
                project_id: props.project.id,
                id: deadline.id,
                members: deadline.members
            }, (response) => {
                showDetails.value[deadline.id] = false;
                getDeadlines();
            });
        }

        const saveDeadline = async (deadline) => {
            RequestHandler('projects/' + props.project.id + '/visit-date/save', 'post', {
                date: deadline.date,
                time: deadline.time
            }, (response) => {
                // if (deadline.members === '') {
                //     deadlines.value.unshift(deadline);
                // }
                showDetails.value[deadline.id] = false;
                getDeadlines();
            });
        }

        const getDeadlines = async (callback) => {
            RequestHandler('projects/' + props.project.id + '/visit-date', 'get', {}, (response) => {
               deadlines.value = response.data.deadlines
                callback(response);
            });
        }
        const acceptDeadline = async (deadline) => {
            RequestHandler('projects/' + props.project.id + '/visit-date/' + deadline.id + '/accept', 'post', {
                project_id: props.project.id,
                id: deadline.id,
            }, (response) => {
                deadline.accepted = 1;
                showDetails.value[deadline.id] = false;
                getDeadlines();
            });
        }

        const acceptVisitDate = async () => {
            axios.post('/api/projects/visit-date/end', {id: props.project.id})
                .then(response => {
                    if (response.data.success) {
                        toast.success('Zaakceptowano');
                        emitter.emit('acceptLocalVision', {});
                    } else {

                    }
                })
                .catch(function (error) {
                    let resData = error.response.data;
                    if (error.response.status === 400) {
                        for (let i in resData.errors) {
                            for (let k in resData.errors[i].messages) {
                                toast.error(resData.errors[i].messages[k]);
                            }
                        }
                    }
                });
        }

        const rejectDeadline = async (deadline) => {
            RequestHandler('projects/' + props.project.id + '/visit-date/' + deadline.id + '/reject', 'post', {
                project_id: props.project.id,
                id: deadline.id,
            }, (response) => {
                deadline.accepted = 2;
                showDetails.value[deadline.id] = false;
                getDeadlines();
            });
        }

        const cancelDeadline = async (deadline) => {
            RequestHandler('projects/' + props.project.id + '/visit-date/' + deadline.id + '/cancel', 'post', {
                project_id: props.project.id,
                id: deadline.id,
            }, (response) => {
                deadline.status = 1;
                showDetails.value[deadline.id] = false;
                getDeadlines();
            });
        }

        onMounted(() => {
            getDeadlines(function () {
                guard.value = true;
            });
        });

        return {
            newDate,
            inputValue,
            inputEvents,
            date,
            block,
            guard,
            is_selected,
            showDetails,
            deadlines,
            user,
            deleteDeadline,
            addNewDeadline,
            saveDeadline,
            acceptDeadline,
            rejectDeadline,
            acceptVisitDate,
            cancelDeadline,
            saveMembers
        }
    }
}
</script>

<style scoped>

.list-leave-from {
    opacity: 1;
    transform: scale(1);
}
.list-leave-to {
    opacity: 0;
    transform: scale(0.6);
}
.list-leave-active {
    transition: all 0.4s ease;
}

</style>
