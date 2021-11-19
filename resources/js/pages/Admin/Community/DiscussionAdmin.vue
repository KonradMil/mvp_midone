<template>
    <Button classes="m-2" type="primary" text="Dodaj dyskusje" @buttonClicked="$router.push({path: '/admin/add/post'})"></Button> <br/>
    <div class="flex flex-row " v-if="selected_ids.length > 0">
        <Button classes="m-2" type="primary" text="Przyklej zaznaczone" @buttonClicked="stickUnstick('stick');"></Button>
        <Button classes="m-2" type="primary" text="Odklej zaznaczone" @buttonClicked="stickUnstick('unstick');"></Button>
        <Button classes="m-2" type="primary" text="Usuń zaznaczone" @buttonClicked="deleteIds"></Button>
    </div>

    <vue-table-lite
        :has-checkbox="true"
        :is-loading="table.isLoading"
        :columns="table.columns"
        :rows="table.rows"
        :total="table.totalRecordCount"
        :sortable="table.sortable"
        :messages="table.messages"
        @is-finished="table.isLoading = false"
        @return-checked-rows="updateCheckedRows"
    ></vue-table-lite>
</template>

<script>
import VueTableLite from 'vue3-table-lite'
import RequestHandler from "../../../compositions/RequestHandler";
import {onMounted, reactive, ref} from "vue";
import Button from "../../../components-terraform/Button";

export default {
    name: "DiscussionAdmin",
    components: {
        VueTableLite, Button
    },
    setup(props, {emit}){
        const selected_ids = ref([]);
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
                    label: "Tytuł",
                    field: "title",
                    width: "40%",
                    sortable: true,
                },
                {
                    label: "Przyklejony",
                    field: "category",
                    width: "10%",
                    sortable: false,
                    display: function (row) {
                        return (
                            (row.sticky === 1)? 'TAK' : 'NIE'
                        );
                    },
                },
                {
                    label: "Kategoria",
                    field: "category",
                    width: "40%",
                    sortable: false,
                    display: function (row) {
                        return (
                            row.category.name
                        );
                    },
                },
                {
                    label: "Autor",
                    field: "user",
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
            RequestHandler('admin/forum/discussions/get', 'get', {}, (response) => {
                table.rows = response.data.discussions;
            });
        }

        const stickUnstick = (action) => {
            RequestHandler('admin/forum/discussions/stick', 'post', {ids: selected_ids.value, action: action}, (response) => {
               getData();
            });
        }

        const deleteIds = () => {
            RequestHandler('admin/forum/discussions/delete', 'post', {ids: selected_ids.value}, (response) => {
                getData();
            });
        }

        const updateCheckedRows = (els) => {
            selected_ids.value = els;
        }

        onMounted(() => {
            getData();
        });

        return {
            table,
            updateCheckedRows,
            deleteIds,
            stickUnstick,
            selected_ids
        }
    }
}
</script>

<style scoped>

</style>
