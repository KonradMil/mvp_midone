<template>
    <Box classes="mt-2 p-5">
        <div class="mt-3">
            <Label title="Kategoria"/>
            <Select :options="categories" v-model:val="category.parent_id"></Select>
        </div>
<!--        <div class="mt-3">-->
<!--            <Label title="Subkategoria"/>-->
<!--            <Select :options="subcategories" v-model:val="category.parent_id"></Select>-->
<!--        </div>-->
        <div class="mt-3">
            <Label title="Nazwa"/>
            <TerraInput type="text" placeholder="" v-model:val="category.name"/>
        </div>
        <div class="mt-3">
            <Label title="Kolejność"/>
            <TerraInput type="text" placeholder="" v-model:val="category.order"/>
        </div>
        <Button classes="m-2" type="primary" text="Zapisz" @buttonClicked="saveCategory"></Button>
    </Box>
</template>

<script>
import VueTableLite from 'vue3-table-lite'
import RequestHandler from "../../../compositions/RequestHandler";
import {onMounted, reactive, ref, watch} from "vue";
import TerraInput from "../../../components-terraform/TerraInput"
import Button from "../../../components-terraform/Button"
import Box from "../../../components-terraform/Box"
import Select from "../../../components-terraform/Select"
import Label from "../../../components-terraform/Label"

export default {
    name: "AddCategoryAdmin",
    components: {
        VueTableLite, Button, TerraInput, Box, Select, Label
    },
    props: {
        id: {
            type: Number
        }
    },
    setup(props, {emit}) {
        const category = reactive({
            id: undefined,
            name: '',
            order: '',
            slug: '',
            color: '',
            parent_id : undefined
        });
        const categories = ref([]);

        const saveCategory = () => {
            RequestHandler('admin/forum/category/save', 'POST', {category: category}, (response) => {
                category.id = response.data.category.id;
                category.name = response.data.category.name;
                category.order = response.data.category.order;
                category.slug = response.data.category.slug;
                category.color = response.data.category.color;
                category.parent_id = response.data.category.parent_id;
            });
        }

        const getTopCategory = () => {
            RequestHandler('admin/forum/categories/top/get', 'get', {}, (response) => {
              categories.value = response.data.categories;
            });
        }

        onMounted(() => {
            getTopCategory();
            category.id = props.id;
            if (props.id != undefined) {
                getData();
            }
        });

        return {
            category,
            categories,
            saveCategory
        }
    }
}
</script>

<style scoped>

</style>
