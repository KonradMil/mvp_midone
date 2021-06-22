<template>
    <div class="intro-y box p-5 bg-theme-1 text-white mt-5">
        <div class="flex items-center">
            <div class="font-medium text-lg">{{ title }}</div>
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
import {computed, onMounted, ref, watch} from "vue";
import GetUserSolutionsChallenge from "../../compositions/GetUserSolutionsChallenge";

export default {
name: "WhatsNext",
    props: {
        challenge: Object,
        user: Object
    },
    setup(props) {
        const title = ref('Następny krok');
        const text = ref('');
        const action = ref({});
        const buttonText = ref('Przejdź');
        const isSolutions = ref(false);
        const isPublic = ref(false);
        watch(() => props.challenge, (first, second) => {
           doMe();
           console.log('filter is coming first');
            filter();
        });

        const solutions = computed(() => {
            return props.challenge.solutions;
        });

        const filter = () => {
            console.log(solutions.value + '->  solutions.value');
            solutions.value.forEach(function (solution) {
                console.log(solution.author_id.value + 'author_id');
                if(solution.author_id.value === props.user.id) {
                    isSolutions.value = true;
                } else if((solution.published.value === 1) && (solution.author.id.value === props.user.id)) {
                    isPublic.value = true;
                }
            });
        }

        // const getSolutionRepositories = async () => {
        //     console.log(props.challenge.id);
        //     solutions.value = GetUserSolutionsChallenge(props.challenge.id);
        // }

        const doMe = () => {
            console.log('filter is coming');
            filter();
            if(props.user.type == 'integrator') {
                if(props.challenge.stage == 1) {
                    console.log('HERE');
                    text.value = 'Na tym etapie Inwestor oczekuje na rozwiązania technologiczne. Przygotuj koncepcję swojego rozwiązania.';
                    action.value = {redirect: ''}
                } else if(props.challenge.solutions.length > 0 && props.challenge.stage == 1) {
                    text.value = 'Po opublikowaniu rozwiązania będzie ono widoczne dla Inwestora.';
                    action.value = {redirect: ''}
                }else if(props.challenge.stage == 2) {
                    text.value = 'Ten etap polega na zebraniu ofert finansowych do wybranego przez inwestora stanowiska. Jeżeli jesteś zainteresowany, złóż ofertę.';
                    action.value = {redirect: ''}
                }
            } else {
                if(props.challenge.stage == 1) {
                    text.value = 'Ten etap polega na zebraniu ofert robotyzacji opisanego stanowiska. Oczekuj na nowe rozwiązania.';
                    buttonText.value = '';
                    action.value = {redirect: ''}
                } else if(props.challenge.stage == 2) {
                    text.value = 'Ten etap polega na zebraniu ofert finansowych do opisanego stanowiska. Oczekuj na nowe oferty.';
                    buttonText.value = '';
                    action.value = {redirect: ''}
                } else if(props.challenge.stage == 0) {
                    text.value = 'Uzupełnij wyzwanie o zdjęcia i kluczowe informacje związane ze stanowiskiem i Twoimi oczekiwaniami, a następnie opublikuj swoje wyzwanie. \n' +
                        'Im bardziej szczegółowy opis wyzwania, tym bardziej sprecyzowane koncepcje rozwiązań zostaną dla niego przygotowane.';
                    action.value = {redirect: ''}
                }
            }
        }

        onMounted(() => {
            // if(props.user.type == 'integrator') {
            //     getSolutionRepositories('');
            // }
            console.log("props");
            console.log(props);
            console.log(props.challenge);
            console.log(props.user);

        });

        return {
            isPublic,
            isSolutions,
            solutions,
            title,
            text,
            action,
            buttonText,
            // getSolutionRepositories
        }
    }
}
</script>

<style scoped>

</style>
