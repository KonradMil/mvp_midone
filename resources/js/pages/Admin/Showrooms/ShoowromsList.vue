<template>
    <Button classes="m-2" type="primary" text="Dodaj showroom" @buttonClicked="$router.push({path: '/admin/showrooms/add'})"></Button>
    <vue-table-lite
        :is-loading="table.isLoading"
        :columns="table.columns"
        :rows="table.rows"
        :total="table.totalRecordCount"
        :sortable="table.sortable"
        :messages="table.messages"
        @do-search="doSearch"
        @is-finished="table.isLoading = false"
    ></vue-table-lite>
</template>

<script>
import VueTableLite from 'vue3-table-lite'
import RequestHandler from "../../../compositions/RequestHandler";
import {onMounted, reactive} from "vue";
import Button from "../../../components-terraform/Button";

export default {
    name: "ShowroomsList",
    components: {
        Button,
        VueTableLite
    },
    setup() {
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
                    label: "Organizacja",
                    field: "organization_name",
                    width: "15%",
                    sortable: true,
                },
                {
                    label: "Użytkowników",
                    field: "views",
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

        const doSearch = (offset, limit, order, sort) => {
            table.isLoading = true;

        };

        const getData = () => {
            RequestHandler('admin/showrooms/get?id=' + props.showroom_id, 'get', {}, (response) => {
                console.log(response);
              table.rows = response.data.showrooms;
            });
        }

        onMounted(() => {
            getData();
        });

        return {
            table,
            doSearch
        }
    }
}
</script>

<style scoped>

</style>
