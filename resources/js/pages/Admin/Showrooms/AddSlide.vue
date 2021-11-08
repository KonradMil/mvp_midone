<template>
    <Box>
        <Label title="Tytuł"/>
        <Input type="text" placeholder="" v-model:val="slide.title"/>
    </Box>
    <Box>
        <Label title="Typ slajdu"></Label>
        <Select :options="types" v-model:val="slide.type"></Select>
    </Box>
    <Box v-if="slide.type === 'text'" classes="mt-2">
        <Label title="Treść"/>
        <TextEditor v-model:val="slide.content" v-model:files="files"></TextEditor>
    </Box>
    <Button type="primary" @buttonClicked="saveSlide" classes="mt-2" text="Zapisz"/>
</template>

<script>
import {reactive, ref, toRaw} from "vue";
import Input from "../../../components-terraform/Input";
import Box from "../../../components-terraform/Box";
import Select from "../../../components-terraform/Select";
import Label from "../../../components-terraform/Label";
import TextArea from "../../../components-terraform/TextArea";
import Button from "../../../components-terraform/Button";
import TextEditor from "../../../components-terraform/TextEditor";

export default {
    name: "AddSlide",
    components: {TextEditor, Button, TextArea, Box, Select, Label, Input},
    props: {

    },
    emits: ['saveSlide'],
    setup(props, {emit}) {
        const types = reactive([
            'text',
            'pdfs',
            'images',
            'form'
        ]);
        const files = ref([]);
        const slide = reactive({
            title: '',
            content: '',
            type: ''
        });

        const saveSlide = () => {
            emit('saveSlide', toRaw(slide));

        }

        const reset = () => {
            slide.text = '';
        }

        return {
            slide,
            types,
            saveSlide,
            files
        }
    }
}
</script>

<style scoped>

</style>
