<template>
        <span>{{name}}</span>
</template>

<script>
import {onMounted, ref} from "vue";

export default {
name: "CategoryName",
    props: {
        categories: Array,
        id: Number
    },
    setup(props, {emit}) {
        const name = ref('');

        const getCategoryName = (cat) => {
            const catId = cat;
            props.categories.forEach(function (c) {
                if(c.value == catId) {
                    name.value = c.name;
                }
            });
        }
        onMounted(() => {
            getCategoryName(props.id)
        });


        return {
            name
        }
    }
}
</script>

<style scoped>

</style>
