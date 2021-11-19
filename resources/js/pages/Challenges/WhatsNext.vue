<template>
    <div class="intro-y box p-5 bg-theme-1 text-white mt-5" v-if="guard === true">
        <div class="flex items-center">
            <div class="font-medium text-lg">{{$t('challengesMain.nextStep')}}</div>
<!--            <div-->
<!--                class="text-xs bg-white dark:bg-theme-1 dark:text-white text-gray-800 px-1 rounded-md ml-auto"-->
<!--            >-->
<!--&lt;!&ndash;                New&ndash;&gt;-->
<!--            </div>-->
        </div>
        <div class="mt-4">
          {{text}}
        </div>
        <div class="font-medium flex mt-5">
<!--            <button-->
<!--                v-if="buttonText != ''"-->
<!--                @click="action"-->
<!--                type="button"-->
<!--                class="btn py-1 px-2 border-white text-white dark:border-gray-700 dark:text-gray-300"-->
<!--            >-->
<!--                Przejdź-->
<!--            </button>-->
<!--            <button-->
<!--                type="button"-->
<!--                class="btn py-1 px-2 border-transparent text-white dark:text-gray-500 ml-auto"-->
<!--            >-->
<!--                Dismiss-->
<!--            </button>-->
        </div>
    </div>
</template>

<script>
import {computed, getCurrentInstance, onMounted, ref, watch} from "vue";
import GetUserSolutionsChallenge from "../../compositions/GetUserSolutionsChallenge";

export default {
name: "WhatsNext",
    props: {
        challenge: Object,
        project: Object,
        user: Object,
        solutions: Array,
        stage: Number,
        id: Number,
    },
    setup(props) {
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        const title = ref('Następny krok');
        const text = ref('');
        const action = ref({});
        const buttonText = ref('Przejdź');
        const isPublic = ref(false);
        const isSolutions = ref(false);
        const isSelected = ref(false);
        const check = ref(false);
        const guard = ref(false);
        const first = ref(false);
        const second = ref(false);
        const third = ref(false);
        const fourth = ref(false);
        const fifth = ref(false);

        watch(() => props.project, (first, second) => {
            doMe();
        }, {deep: true});

        watch(() => props.challenge, (first, second) => {
           doMe();
           isOffer();
        }, {deep: true});

        watch(() => isPublic.value, (first, second) => {
            doMe();
        }, {});
        watch(() => isSolutions.value, (first, second) => {
            doMe();
        }, {});
        watch(() => isSelected.value, (first, second) => {
            doMe();
        }, {});
        watch(() => check.value, (first, second) => {
            doMe();
        }, {})

        const isOffer = async () => {
            axios.post('/api/offer/user/check', {id: props.id})
                .then(response => {
                    if (response.data.success) {
                        check.value = response.data.payload;
                    } else {

                    }
                })
        }

        emitter.on('*', (type, e) => {
            if(type == 'isPublic' && (e.isPublic === true)) {
                isPublic.value = e.isPublic;
            }
        });
        emitter.on('*', (type, e) => {
            if(type == 'check' && e.check === true) {
                check.value = e.check;
            }
        });

        emitter.on('changeToOffers', e => {
            if(e.check===true){
                check.value = e.check;
            }
        });
        emitter.on('isSolutions', e => {
            if(e.isSolutions===true){
                isSolutions.value = e.isSolutions;
            }
        });

        const solutions = computed(() => {
            if (props.challenge.solutions !== undefined) {
                if (props.challenge.solutions.length > 0) {
                    props.challenge.solutions.forEach((val) => {
                        if((val.author_id === props.user.id) || (props.user.id === props.challenge.author_id)){
                            isSolutions.value = true;
                                if(val.status === 1) {
                                   isPublic.value = true;
                               }
                                if(val.selected === 1) {
                                   isSelected.value = true;
                                 }
                        }
                    });
                }
            }
            return props.challenge.solutions;
        });

        // const filter = () => {

        //     solutions.value.forEach(function (solution) {

        //         if(solution.author_id.value === props.user.id) {
        //             isSolutions.value = true;
        //         } else if((solution.published.value === 1) && (solution.author.id.value === props.user.id)) {
        //             isPublic.value = true;
        //         }
        //     });
        // }

        // const getSolutionRepositories = async () => {

        //     solutions.value = GetUserSolutionsChallenge(props.challenge.id);
        // }

        const doMe = () => {
            try {
                if(props.challenge.stage === 3 && props.project.accept_local_vision !== 1){
                text.value = 'W raporcie z wizji lokalnej uzwględnij wszelkie zmiany jakie należy wprowadzić w projekcie po wizycie na zakładzie.';
                action.value = {redirect: '' }
                } else if(props.challenge.stage === 3 && props.project.accept_local_vision === 1 && props.project.accept_financial_details !== 1 && props.project.accept_technical_details !== 1){
                    text.value = 'Po przeprowadzeniu wizji lokalnej strony mogą uzgodnić zmiany w założeniach technicznych dla stanowiska.';
                    action.value = {redirect: '' }
                } else if(props.challenge.stage === 3 && props.project.accept_financial_details === 1 && props.project.accept_technical_details === 1 && props.project.accept_offer !== 1){
                    text.value = 'Po przeprowadzeniu wizji lokalnej strony mogą uzgodnić zmiany oferty na realizacje stanowiska.';
                    action.value = {redirect: '' }
                }
                if(props.user.type === 'integrator' && props.challenge.stage < 3) {
                     if(isSelected.value === true && check.value === false){
                        text.value = 'Ten etap polega na zebraniu ofert finansowych do wybranego przez inwestora stanowiska. Jeżeli jesteś zainteresowany, złóż ofertę.';action.value = {redirect: ''}
                    } else if(isSolutions.value === false && props.challenge.stage === 1) {
                        text.value = 'Na tym etapie Inwestor oczekuje na rozwiązania technologiczne. Przygotuj koncepcję swojego rozwiązania.';
                        action.value = {redirect: ''}
                    } else if(isPublic.value === false && isSolutions.value === true) {
                        text.value = 'Po opublikowaniu rozwiązania będzie ono widoczne dla Inwestora.';
                        action.value = {redirect: ''}
                    }else if(isSelected.value !== true && isPublic.value === true && isSolutions.value === true) {
                        text.value = 'Jedno z twoich rozwiązań jest opublikowane! Jeśli inwestor je zaakceptuje będziesz mógł złożyć ofertę.';
                        action.value = {redirect: ''}
                    }else if(props.challenge.stage === 2 && isSelected.value=== true && isSolutions.value === true) {
                        text.value = 'Ten etap polega na zebraniu ofert finansowych do wybranego przez inwestora stanowiska. Jeżeli jesteś zainteresowany, złóż ofertę.';
                        action.value = {redirect: ''}
                    } else if(check.value === true) {
                        text.value = 'Opublikuj przygotowaną ofertę.';
                        action.value = {redirect: ''}
                    }
                } else if(props.user.type === 'investor' && props.challenge.stage < 3){
                    if(props.challenge.solutions < 1 && props.challenge.stage === 1) {
                        text.value = 'Oczekuj na nowe rozwiązania.';
                        buttonText.value = '';
                        action.value = {redirect: ''}
                    } else if(props.challenge.selected.length > 0 && check.value === false) {
                        text.value = 'Ten etap polega na zebraniu ofert finansowych do opisanego stanowiska. Oczekuj na nowe oferty.';
                        buttonText.value = '';
                        action.value = {redirect: ''}
                    } else if(props.challenge.stage === 0) {
                        text.value = 'Uzupełnij wyzwanie o zdjęcia i kluczowe informacje związane ze stanowiskiem i Twoimi oczekiwaniami, a następnie opublikuj swoje wyzwanie. \n' +
                            'Im bardziej szczegółowy opis wyzwania, tym bardziej sprecyzowane koncepcje rozwiązań zostaną dla niego przygotowane.';
                        action.value = {redirect: ''}
                    } else if(isPublic.value === true && isSelected.value === false && props.challenge.selected.length < 1) {
                        text.value = 'Zaakceptuj rozwiązania, aby otrzymać oferty.';
                        action.value = {redirect: ''}
                    } else if(check.value === true){
                        text.value = 'Zaakceptuj ofertę, która spełnia wszystkie Twoje oczekiwania.';
                        action.value = {redirect: ''}
                    }
                }
            } catch (e) {

            }
        }

        const initialize = async() =>{
            await doMe();
            guard.value = true;
        }

        onMounted(() => {
            initialize();
        });

        return {
            guard,
            first,
            second,
            third,
            fourth,
            fifth,
            check,
            isSelected,
            isPublic,
            isSolutions,
            solutions,
            title,
            text,
            action,
            buttonText,
        }
    }
}
</script>

<style scoped>

</style>
