<template>
    <div class="vue-swatches" tabindex="-1" id="terraform-swatch">
        <div class="vue-swatches__container vue-swatches--inline" style="background-color: transparent;">
            <div class="vue-swatches__wrapper">
                <div v-for="(color, index) in colors" class="vue-swatches__swatch" :aria-label="color" @click="$emit('colorSelected', color)" role="button" tabindex="0" :style="'width: ' + width + 'px; height: ' + height + 'px; border-radius: ' + border_radius +'px; background-color: ' + color + '; cursor: pointer; margin-right: ' + margin_right + 'px; margin-bottom: ' + margin_bottom +  'px;'">
                    <div class="vue-swatches__check__wrapper vue-swatches--has-children-centered" style="display: none;">
                        <div class="vue-swatches__check__circle vue-swatches--has-children-centered">
                            <svg role="presentation" :width="width" :height="height" viewBox="0 0 1792 1792" class="check">
                                <path class="vue-swatches__check__path" d="M1671 566q0 40-28 68l-724 724-136 136q-28 28-68 28t-68-28l-136-136-362-362q-28-28-28-68t28-68l136-136q28-28 68-28t68 28l294 295 656-657q28-28 68-28t68 28l136 136q28 28 28 68z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {watch, ref} from "vue";

export default {
    name: "Swatches",
    props: {
        height: {
            type: Number,
            default: 42
        },
        width: {
            type: Number,
            default: 42
        },
        border_radius: {
            type: Number,
            default: 11
        },
        margin_right: {
            type: Number,
            default: 11
        },
        margin_bottom: {
            type: Number,
            default: 11
        },
        colors: {
            type: Array,
            default: [
                '#1FBC9C',
                '#1CA085',
                '#2ECC70',
                '#27AF60',
                '#3398DB',
                '#2980B9',
                '#A463BF',
                '#8E43AD',
                '#3D556E',
                '#222F3D',
                '#F2C511',
                '#F39C19',
                '#E84B3C',
                '#C0382B',
                '#DDE6E8',
                '#BDC3C8'
            ]
        }
    },
    emits: ['colorSelected'],
    setup(props, {emit}) {

    }
}
</script>

<style scoped>

</style>
