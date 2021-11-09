<template>
    <teleport to="body">
    <vue-final-modal
        v-slot="{ params, close }"
        v-bind="$attrs"
        classes="flex justify-center items-center"
        content-class="relative flex flex-col max-h-full mx-4 p-4 border dark:border-gray-800 rounded bg-white dark:bg-gray-900">
        <span class="mr-8 text-xl font-bold mb-2" style="color: #5e50ac;">
          <slot name="title"></slot>
        </span>
        <div class="flex-grow overflow-y-auto">
            <slot :params="params"></slot>
        </div>
        <div class="flex-shrink-0 flex justify-content-end pt-4">
            <Button classes="vfm-btn mr-2" @buttonClicked="conf" text="Potwierdź"/>
            <Button classes="vfm-btn" @buttonClicked="close" text="Anuluj"/>
        </div>
        <button class="absolute top-0 right-0 mt-2 mr-2" @click="close">
           X
        </button>
    </vue-final-modal>
    </teleport>
</template>
<script>
import Button from "./Button";

export default {
    name: "TerraModal",
    components: {Button},
    emits: ['cancel', 'confirm'],
    inheritAttrs: false,
    setup(props, {emit}) {
        const close = (e) => {
            emit('cancel', e);
        }

        const conf = (e) => {
            emit('confirm', e);
        }

        return {
            close,
            conf
        }
    }
}
</script>

<style scoped>

</style>
