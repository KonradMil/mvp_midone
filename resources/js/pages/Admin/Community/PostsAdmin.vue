<template>
    <Button classes="m-2" type="primary" text="Dodaj post" @buttonClicked="$router.push({path: '/admin/add/post'})"></Button>
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
    name: "PostsAdmin",
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
                    label: "Treść",
                    field: "body",
                    width: "70%",
                    sortable: false,
                    display: function (row) {
                        return (
                           row.body
                        );
                    },
                },
                {
                    label: "Autor",
                    field: "user.name",
                    width: "10%",
                    sortable: false,
                    display: function (row) {
                        return (
                            row.user.name + ' ' + row.user.lastname
                        );
                    },
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
            RequestHandler('admin/forum/posts/get', 'get', {}, (response) => {
                table.rows = response.data.posts;
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
