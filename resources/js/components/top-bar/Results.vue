<template>
    <div class="search-result__content">
        <div class="search-result__content__title">Wyzwania</div>
        <div class="mb-5">
            <a href="" @click.prevent="$router.push({ path: 'challenges/card/' + challenge.id})" v-for="(challenge, index) in results.challenges" :key="'chal_' + index" class="flex items-center">
                {{challenge.name}}
<!--                <div-->
<!--                    class="w-8 h-8 bg-theme-18 text-theme-9 flex items-center justify-center rounded-full"-->
<!--                >-->
<!--                    <InboxIcon class="w-4 h-4"/>-->
<!--                </div>-->
<!--                <div class="ml-3">Mail Settings</div>-->
            </a>
<!--            <a href="" class="flex items-center mt-2">-->
<!--                <div-->
<!--                    class="w-8 h-8 bg-theme-17 text-theme-11 flex items-center justify-center rounded-full"-->
<!--                >-->
<!--                    <UsersIcon class="w-4 h-4"/>-->
<!--                </div>-->
<!--                <div class="ml-3">Users & Permissions</div>-->
<!--            </a>-->
<!--            <a href="" class="flex items-center mt-2">-->
<!--                <div-->
<!--                    class="w-8 h-8 bg-theme-14 text-theme-10 flex items-center justify-center rounded-full"-->
<!--                >-->
<!--                    <CreditCardIcon class="w-4 h-4"/>-->
<!--                </div>-->
<!--                <div class="ml-3">Transactions Report</div>-->
<!--            </a>-->
        </div>
<!--        <div class="search-result__content__title">Users</div>-->
<!--        <div class="mb-5">-->
<!--            <a-->
<!--                v-for="(faker, fakerKey) in $_.take($f(), 4)"-->
<!--                :key="fakerKey"-->
<!--                href-->
<!--                class="flex items-center mt-2"-->
<!--            >-->
<!--                <div class="w-8 h-8 image-fit">-->
<!--                    <Avatar :src="user.avatar_path" :username="user.name + ' ' + user.lastname" color="#FFF"-->
<!--                            background-color="#5e50ac"/>-->
<!--                </div>-->
<!--                <div class="ml-3">{{ faker.users[0].name }}</div>-->
<!--                <div-->
<!--                    class="ml-auto w-48 truncate text-gray-600 text-xs text-right"-->
<!--                >-->
<!--                    {{ faker.users[0].email }}-->
<!--                </div>-->
<!--            </a>-->
<!--        </div>-->
<!--        <div class="search-result__content__title">Products</div>-->
<!--        <a-->
<!--            v-for="(faker, fakerKey) in $_.take($f(), 4)"-->
<!--            :key="fakerKey"-->
<!--            href-->
<!--            class="flex items-center mt-2"-->
<!--        >-->
<!--            <div class="w-8 h-8 image-fit">-->
<!--                <img-->
<!--                    alt="DBR77 Platforma Robotów "-->
<!--                    class="rounded-full"-->
<!--                    :src="require(`../../../images/${faker.images[0]}`)"-->
<!--                />-->
<!--            </div>-->
<!--            <div class="ml-3">{{ faker.products[0].name }}</div>-->
<!--            <div class="ml-auto w-48 truncate text-gray-600 text-xs text-right">-->
<!--                {{ faker.products[0].category }}-->
<!--            </div>-->
<!--        </a>-->
    </div>
</template>

<script>
import {onMounted, ref, watch} from "vue";

export default {
    name: "Results",
    props: {
        results: Object
    },

    setup(props) {
        const results = ref({});

        watch(() => props.results, (first, second) => {
            results.value = props.results;
        });

        onMounted(() => {
            results.value = props.results;
        });

        return {
            results
        }

    }
}
</script>

<style scoped>

</style>
