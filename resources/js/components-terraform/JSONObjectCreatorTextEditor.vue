<template>
    <div class="grid  gap-2" :class="'grid-cols-' + columnNumber">
        <template v-for="(name,inn) in columnNames" :key="'name_' + inn">
            <Label :title="name"/>
        </template>
    </div>
    <div class="grid  gap-2" :class="'grid-cols-' + columnNumber">
        <template v-for="(row,i) in data" :key="'row_' + i">
            <TerraInput classes="col" :key="'input_row_' + i + '_input_' + i" placeholder="" type="text" v-model:val="row[0]"></TerraInput>
            <TextEditor classes="col" :key="'input_rowtext_' + i + '_input_' + i" placeholder="" type="text" v-model:val="row[1]"></TextEditor>
        </template>
    </div>
    <Button type="primary" classes="mt-2 flex-wrap" @buttonClicked="addRow" text="Dodaj rząd"></Button>
</template>

<script>
import {onMounted, ref, watch} from "vue";
import Button from "./Button";
import TerraInput from "./TerraInput";
import Label from "./Label";
import TextEditor from "./TextEditor";

export default {
    name: "JSONObjectCreatorTextEditor",
    components: {TextEditor, TerraInput, Button, Label},
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
