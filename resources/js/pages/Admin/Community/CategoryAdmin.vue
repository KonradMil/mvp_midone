<template>
    <Button classes="m-2" type="primary" text="Dodaj kategorie" @buttonClicked="$router.push({path: '/admin/add/category'})"></Button>

    <vue-table-lite
        :is-loading="table.isLoading"
        :columns="table.columns"
        :rows="table.rows"
        :total="table.totalRecordCount"
        :sortable="table.sortable"
        :messages="table.messages"
        @is-finished="table.isLoading = false"
    ></vue-table-lite>
</template>

<script>
import VueTableLite from 'vue3-table-lite'
import RequestHandler from "../../../compositions/RequestHandler";
import {onMounted, reactive} from "vue";
import Button from "../../../components-terraform/Button";

export default {
    name: "CategoryAdmin",
    components: {
        VueTableLite, Button
    },
    setup(props, {emit}){
        const table = reactive({
            isLoading: false,
            columns: [
                {
                    label: "ID",
                    field: "id",
                    width: "3%",
                    sortable: true,
                    isKey: true,
                },
                {
                    label: "Nazwa",
                    field: "name",
                    width: "10%",
                    sortable: true,
                },
                {
                    label: "Subkategoria",
                    field: "subcategory",
                    width: "10%",
                    sortable: false,
                },
                {
                    label: "Postów",
                    field: "posts_count",
                    width: "15%",
                    sortable: true,
                },
            ],
            rows: [],
            totalRecordCount: 0,
            sortable: {
                order: "id",
                sort: "asc",
            },
        });

        const getData = () => {
            RequestHandler('admin/forum/categories/get', 'get', {}, (response) => {
                table.rows = response.data.categories;
            });
        }

        onMounted(() => {
            getData();
        });

        return {
            table
        }
    }
}
</script>

<style scoped>

</style>
