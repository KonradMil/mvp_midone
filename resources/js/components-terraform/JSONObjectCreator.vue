<template>
    <div class="grid  gap-2" :class="'grid-cols-' + columnNumber">
        <template v-for="(name,inn) in columnNames" :key="'name_' + inn">
            <Label :title="name"/>
        </template>
    </div>
    <div class="grid  gap-2" :class="'grid-cols-' + columnNumber">
        <template v-for="(row,i) in data" :key="'row_' + i">
            <Input v-for="(n,index) in parseInt(columnNumber)" classes="col" :key="'input_row_' + i + '_input_' + index" placeholder="" type="text" v-model:val="row[index]"></Input>
        </template>
    </div>
    <Button type="primary" classes="mt-2 flex-wrap" @buttonClicked="addRow" text="Dodaj rząd"></Button>
</template>

<script>
import {onMounted, ref, watch} from "vue";
import Button from "./Button";
import Input from "./Input";
import Label from "./Label";

export default {
    name: "JSONObjectCreator",
    components: {Input, Button, Label},
    props: {
        columnNumber: {
            type: Number,
            default: 2
        },
        initialData: {
            type: Array,
            default: []
        },
        columnNames: {
            type: Array
        }
    },
    emits: ['update'],
    setup(props, {emit}) {
        const data = ref([]);

        watch(data, () => {
            emit('update', data);
        });

        const addRow = () => {
            let temp_obj = {};
            for (let i = 1; i <= props.columnNumber; i++ ) {
                temp_obj[i - 1] = '';
            }
            data.value.push(temp_obj);
        }

        onMounted(() => {
               data.value = props.initialData;
        });

        return {
            data,
            addRow
        }
    }
}
</script>

<style scoped>

</style>
