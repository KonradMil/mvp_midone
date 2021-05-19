<template>
    <div class="col-span-12 lg:col-span-8 xxl:col-span-9">
        <div class="grid grid-cols-12 gap-6">
            <!-- BEGIN: Announcement -->
            <div class="intro-y box col-span-12 xxl:col-span-12">
                <div
                    class="flex items-center px-5 py-3 border-b border-gray-200 dark:border-dark-5"
                >
                    <h2 class="font-medium text-base mr-auto"> Rozwiązania</h2>
                </div>
                <div class="px-5 pt-5">
                    <div
                        v-for="(solution, index) in challenge.solutions"
                        :key="index"
                        class="intro-y col-span-12 md:col-span-6 xl:col-span-4 box"
                    >
                        <SingleSolutionPost :user="user" :solution="solution"></SingleSolutionPost>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {computed, onMounted, reactive, ref} from "vue";
import {useToast} from "vue-toastification";
import SingleSolutionPost from "../../../components/SingleSolutionPost";

export default {
    name: "SolutionsPanel",
    components: {SingleSolutionPost},
    props: {
        challenge: Object
    },
    setup(props) {
        const challenge = computed(() => {
            return props.challenge;
        });
        const toast = useToast();
        const types = require("../../../json/types.json");
        const user = ref({});

        onMounted(function () {
            if (window.Laravel.user) {
                user.value = window.Laravel.user;
            }
        });

        const follow = () => {
            axios.post('/api/solution/follow', {id: props.challenge.id})
                .then(response => {
                    // console.log(response.data)
                    if (response.data.success) {
                        challenge.value.followed = true;
                        toast.success('Teraz śledzisz to rozwiązania.');
                    } else {

                    }
                })
        }

        const unfollow = () => {
            axios.post('/api/solution/unfollow', {id: props.challenge.id})
                .then(response => {
                    // console.log(response.data)
                    if (response.data.success) {
                        challenge.value.followed = false;
                        toast.success('Nie śledzisz już tego rozwiązania.');
                    } else {

                    }
                })
        }


        return {
            challenge,
            types,
            follow,
            unfollow,
            user
        }
    }
}
</script>

<style scoped>

</style>
