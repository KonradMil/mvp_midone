<template>
    <Box classes="mt-2 p-5">
        <div class="mt-3">
            <Label title="Kategoria"/>
            <Select :options="categories" v-model:val="selected_category"></Select>
        </div>
        <div class="mt-3">
            <Label title="Subkategoria"/>
            <Select :options="subcategories" v-model:val="post.category_id"></Select>
        </div>
        <div class="mt-3">
            <Label title="Nazwa"/>
            <TerraInput type="text" placeholder="" v-model:val="post.title"/>
        </div>
        <div class="mt-3">
            <Label title="Treść"/>
            <TextEditor v-model:val="post.body"></TextEditor>
        </div>
        <Button classes="m-2" type="primary" text="Zapisz" @buttonClicked="savePost"></Button>
    </Box>
</template>

<script>
import VueTableLite from 'vue3-table-lite'
import RequestHandler from "../../../compositions/RequestHandler";
import {onMounted, reactive, ref, watch} from "vue";
import Box from "../../../components-terraform/Box";
import Button from "../../../components-terraform/Button";
import TextEditor from "../../../components-terraform/TextEditor";
import TerraInput from "../../../components-terraform/TerraInput";
import Select from "../../../components-terraform/Select"
import Label from "../../../components-terraform/Label"

export default {
    name: "AddDiscussionAdmin",
    components: {
        VueTableLite, Button, TextEditor, Box, TerraInput, Select, Label
    },
    props: {
        id: {
            type: Number
        }
    },
    setup(props, {emit}) {
        const post = reactive({
            id: undefined,
            title: '',
            body: '',
            markdown: '',
            discussion_id: undefined,
            post_id: undefined,
            category_id: undefined
        });
        const selected_category = ref();
        const categories = ref([]);
        const subcategories = ref([]);

        watch(selected_category, () => {
            getSubcategories();
        });

        const savePost = () => {
            RequestHandler('admin/forum/discussion/save', 'POST', {discussion: post}, (response) => {
                post.id = response.data.post.id;
                post.body = response.data.post.body;
                post.title = response.data.post.title;
                post.markdown = response.data.post.markdown;
                post.discussion_id = response.data.post.discussion_id;
                post.category_id = response.data.post.category_id;
            });
        }

        const getTopCategory = () => {
            RequestHandler('admin/forum/categories/top/get', 'get', {}, (response) => {
                categories.value = response.data.categories;
            });
        }

        const getSubcategories = () => {
            RequestHandler('admin/forum/categories/' + selected_category.value + '/children', 'get', {}, (response) => {
                subcategories.value = response.data.subcategories;
            });
        }

        onMounted(() => {
            getTopCategory();
            if (props.id != undefined) {
                getData();
            }

        });

        return {
            subcategories,
            categories,
            selected_category,
            post,
            savePost
        }
    }
}
</script>

<style scoped>

</style>
