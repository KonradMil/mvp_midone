<template>

</template>

<script>
import {ref} from 'vue';

export default function GetUserSolutionsChallenge(id) {
    const list = ref([]);

    async function getUserSolutionsChallenge(id) {
        axios.post(`/api/solution/user/get/solutions/challenge/${id}`, {})
            .then(response => {

                if (response.data.success) {

                    list.value = response.data.payload;
                } else {
                    // toast.error(response.data.message);
                }
            })
    }

    getUserSolutionsChallenge(id);

    return {
        list
    }
}
</script>

<style scoped>

</style>
