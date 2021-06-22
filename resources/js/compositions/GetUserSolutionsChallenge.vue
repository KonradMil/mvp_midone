<template>

</template>

<script>
import {ref} from 'vue';

export default function GetUserSolutionsChallenge(id) {
    const list = ref([]);

    async function getUserSolutionsChallenge(id) {
        axios.post(`/api/solution/user/get/solutions/challenge/${id}`, {})
            .then(response => {
                // console.log(response.data)
                if (response.data.success) {
                    // console.log(response.data);
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
