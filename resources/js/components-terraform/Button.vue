<template>
    <button type="button" class="btn flex items-center" :class="classes + ' ' + buttonType" @click="$emit('buttonClicked')">
        <slot></slot>{{ $t(text) }}
    </button>
</template>

<script>
import {computed} from "vue";

export default {
    name: "Button",
    props: {
        text: {
            type: String,
            required: true
        },
        classes: {
            type: String
        },
        type: {
            type: String,
            default: 'btn-primary'
        }
    },
    emits: [
        'buttonClicked'
    ],
    setup(props, {emit}) {
        const buttonType = computed(() => {
            let temp = '';
            switch (props.type) {
                case 'primary':
                    temp = 'btn-primary';
                    break;
                case 'secondary':
                    temp = 'btn-secondary';
                    break;
                case 'success':
                    temp = 'btn-success';
                    break;
                case 'warning':
                    temp = 'btn-warning';
                    break;
                case 'error':
                    temp = 'btn-error';
                    break;
                default:
                    temp = 'btn-primary';
                    break;
            }
            return temp;
        });

        return {
            buttonType
        }
    }
}
</script>

<style scoped>

</style>
