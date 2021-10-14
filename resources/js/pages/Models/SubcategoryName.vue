<template>
    <span>{{name}}</span>
</template>

<script>
import {onMounted, ref} from "vue";

export default {
    name: "SubcategoryName",
    props: {
        categories: Array,
        id: Number,
        catid: Number
    },
    setup(props, {emit}) {
        const name = ref('');

        const getSubcategoryName = (cat, sub) => {
            props.categories.forEach(function (c) {
                if(c.value == cat) {

                    c.subcategories.forEach(function (s) {

                        if(s.value == sub) {

                            name.value = s.name;
                        }
                    })
                }
            });
        }

        onMounted(() => {
            getSubcategoryName(props.catid, props.id)
        });


        return {
            name
        }
    }
}
</script>

<style scoped>

</style>
