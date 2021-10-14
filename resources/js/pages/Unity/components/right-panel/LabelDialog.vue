<template>
    <div>
        <label for="modal-form-1" class="form-label">Tytuł</label>
        <input
            id="modal-form-1"
            type="text"
            class="form-control"
            placeholder=""
            v-model="l.message"
        />
    </div>
    <div class="mt-3">
        <label for="modal-form-2" class="form-label">Kolor</label>
<!--        <VSwatches id="modal-form-2" v-model="l.textColor" inline></VSwatches>-->
        <div class="vue-swatches" tabindex="-1" id="modal-form-2"  modelvalue="#222F3D" data-v-530b672a=""><!-- Trigger --><!--v-if-->
            <div class="vue-swatches__container vue-swatches--inline" style="background-color: transparent;"><!-- The wrapper handles the internal spacing -->
                <div class="vue-swatches__wrapper"><!-- for nested distribution --><!-- for normal distribution -->
                    <div class="vue-swatches__swatch" aria-label="#1FBC9C" @click="l.textColor = '#1FBC9C'" role="button" tabindex="0" style="width: 42px; height: 42px; border-radius: 11px; background-color: rgb(31, 188, 156); cursor: pointer; margin-right: 11px; margin-bottom: 11px;"><!--v-if-->
                        <div class="vue-swatches__check__wrapper vue-swatches--has-children-centered" style="display: none;">
                            <div class="vue-swatches__check__circle vue-swatches--has-children-centered">
                                <svg version="1.1" role="presentation" width="12" height="12" viewBox="0 0 1792 1792" class="check">
                                    <path class="vue-swatches__check__path" d="M1671 566q0 40-28 68l-724 724-136 136q-28 28-68 28t-68-28l-136-136-362-362q-28-28-28-68t28-68l136-136q28-28 68-28t68 28l294 295 656-657q28-28 68-28t68 28l136 136q28 28 28 68z"></path>
                                </svg>
                            </div>
                        </div><!--v-if--></div>
                    <div class="vue-swatches__swatch" aria-label="#1CA085"  @click="l.textColor = '#1CA085'" role="button" tabindex="0" style="width: 42px; height: 42px; border-radius: 11px; background-color: rgb(28, 160, 133); cursor: pointer; margin-right: 11px; margin-bottom: 11px;"><!--v-if-->
                        <div class="vue-swatches__check__wrapper vue-swatches--has-children-centered" style="display: none;">
                            <div class="vue-swatches__check__circle vue-swatches--has-children-centered">
                                <svg version="1.1" role="presentation" width="12" height="12" viewBox="0 0 1792 1792" class="check">
                                    <path class="vue-swatches__check__path" d="M1671 566q0 40-28 68l-724 724-136 136q-28 28-68 28t-68-28l-136-136-362-362q-28-28-28-68t28-68l136-136q28-28 68-28t68 28l294 295 656-657q28-28 68-28t68 28l136 136q28 28 28 68z"></path>
                                </svg>
                            </div>
                        </div><!--v-if--></div>
                    <div class="vue-swatches__swatch" aria-label="#2ECC70"  @click="l.textColor = '#2ECC70'" role="button" tabindex="0" style="width: 42px; height: 42px; border-radius: 11px; background-color: rgb(46, 204, 112); cursor: pointer; margin-right: 11px; margin-bottom: 11px;"><!--v-if-->
                        <div class="vue-swatches__check__wrapper vue-swatches--has-children-centered" style="display: none;">
                            <div class="vue-swatches__check__circle vue-swatches--has-children-centered">
                                <svg version="1.1" role="presentation" width="12" height="12" viewBox="0 0 1792 1792" class="check">
                                    <path class="vue-swatches__check__path" d="M1671 566q0 40-28 68l-724 724-136 136q-28 28-68 28t-68-28l-136-136-362-362q-28-28-28-68t28-68l136-136q28-28 68-28t68 28l294 295 656-657q28-28 68-28t68 28l136 136q28 28 28 68z"></path>
                                </svg>
                            </div>
                        </div><!--v-if--></div>
                    <div class="vue-swatches__swatch" aria-label="#27AF60"  @click="l.textColor = '#27AF60'" role="button" tabindex="0" style="width: 42px; height: 42px; border-radius: 11px; background-color: rgb(39, 175, 96); cursor: pointer; margin-right: 11px; margin-bottom: 11px;"><!--v-if-->
                        <div class="vue-swatches__check__wrapper vue-swatches--has-children-centered" style="display: none;">
                            <div class="vue-swatches__check__circle vue-swatches--has-children-centered">
                                <svg version="1.1" role="presentation" width="12" height="12" viewBox="0 0 1792 1792" class="check">
                                    <path class="vue-swatches__check__path" d="M1671 566q0 40-28 68l-724 724-136 136q-28 28-68 28t-68-28l-136-136-362-362q-28-28-28-68t28-68l136-136q28-28 68-28t68 28l294 295 656-657q28-28 68-28t68 28l136 136q28 28 28 68z"></path>
                                </svg>
                            </div>
                        </div><!--v-if--></div>
                    <div class="vue-swatches__swatch" aria-label="#3398DB" @click="l.textColor = '#3398DB'" role="button" tabindex="0" style="width: 42px; height: 42px; border-radius: 11px; background-color: rgb(51, 152, 219); cursor: pointer; margin-right: 11px; margin-bottom: 11px;"><!--v-if-->
                        <div class="vue-swatches__check__wrapper vue-swatches--has-children-centered" style="display: none;">
                            <div class="vue-swatches__check__circle vue-swatches--has-children-centered">
                                <svg version="1.1" role="presentation" width="12" height="12" viewBox="0 0 1792 1792" class="check">
                                    <path class="vue-swatches__check__path" d="M1671 566q0 40-28 68l-724 724-136 136q-28 28-68 28t-68-28l-136-136-362-362q-28-28-28-68t28-68l136-136q28-28 68-28t68 28l294 295 656-657q28-28 68-28t68 28l136 136q28 28 28 68z"></path>
                                </svg>
                            </div>
                        </div><!--v-if--></div>
                    <div class="vue-swatches__swatch" aria-label="#2980B9"  @click="l.textColor = '#2980B9'" role="button" tabindex="0" style="width: 42px; height: 42px; border-radius: 11px; background-color: rgb(41, 128, 185); cursor: pointer; margin-right: 11px; margin-bottom: 11px;"><!--v-if-->
                        <div class="vue-swatches__check__wrapper vue-swatches--has-children-centered" style="display: none;">
                            <div class="vue-swatches__check__circle vue-swatches--has-children-centered">
                                <svg version="1.1" role="presentation" width="12" height="12" viewBox="0 0 1792 1792" class="check">
                                    <path class="vue-swatches__check__path" d="M1671 566q0 40-28 68l-724 724-136 136q-28 28-68 28t-68-28l-136-136-362-362q-28-28-28-68t28-68l136-136q28-28 68-28t68 28l294 295 656-657q28-28 68-28t68 28l136 136q28 28 28 68z"></path>
                                </svg>
                            </div>
                        </div><!--v-if--></div>
                    <div class="vue-swatches__swatch" aria-label="#A463BF" @click="l.textColor = '#A463BF'" role="button" tabindex="0" style="width: 42px; height: 42px; border-radius: 11px; background-color: rgb(164, 99, 191); cursor: pointer; margin-right: 11px; margin-bottom: 11px;"><!--v-if-->
                        <div class="vue-swatches__check__wrapper vue-swatches--has-children-centered" style="display: none;">
                            <div class="vue-swatches__check__circle vue-swatches--has-children-centered">
                                <svg version="1.1" role="presentation" width="12" height="12" viewBox="0 0 1792 1792" class="check">
                                    <path class="vue-swatches__check__path" d="M1671 566q0 40-28 68l-724 724-136 136q-28 28-68 28t-68-28l-136-136-362-362q-28-28-28-68t28-68l136-136q28-28 68-28t68 28l294 295 656-657q28-28 68-28t68 28l136 136q28 28 28 68z"></path>
                                </svg>
                            </div>
                        </div><!--v-if--></div>
                    <div class="vue-swatches__swatch" aria-label="#8E43AD" @click="l.textColor = '#8E43AD'" role="button" tabindex="0" style="width: 42px; height: 42px; border-radius: 11px; background-color: rgb(142, 67, 173); cursor: pointer; margin-right: 11px; margin-bottom: 11px;"><!--v-if-->
                        <div class="vue-swatches__check__wrapper vue-swatches--has-children-centered" style="display: none;">
                            <div class="vue-swatches__check__circle vue-swatches--has-children-centered">
                                <svg version="1.1" role="presentation" width="12" height="12" viewBox="0 0 1792 1792" class="check">
                                    <path class="vue-swatches__check__path" d="M1671 566q0 40-28 68l-724 724-136 136q-28 28-68 28t-68-28l-136-136-362-362q-28-28-28-68t28-68l136-136q28-28 68-28t68 28l294 295 656-657q28-28 68-28t68 28l136 136q28 28 28 68z"></path>
                                </svg>
                            </div>
                        </div><!--v-if--></div>
                    <div class="vue-swatches__swatch" aria-label="#3D556E" @click="l.textColor = '#3D556E'" role="button" tabindex="0" style="width: 42px; height: 42px; border-radius: 11px; background-color: rgb(61, 85, 110); cursor: pointer; margin-right: 11px; margin-bottom: 11px;"><!--v-if-->
                        <div class="vue-swatches__check__wrapper vue-swatches--has-children-centered" style="display: none;">
                            <div class="vue-swatches__check__circle vue-swatches--has-children-centered">
                                <svg version="1.1" role="presentation" width="12" height="12" viewBox="0 0 1792 1792" class="check">
                                    <path class="vue-swatches__check__path" d="M1671 566q0 40-28 68l-724 724-136 136q-28 28-68 28t-68-28l-136-136-362-362q-28-28-28-68t28-68l136-136q28-28 68-28t68 28l294 295 656-657q28-28 68-28t68 28l136 136q28 28 28 68z"></path>
                                </svg>
                            </div>
                        </div><!--v-if--></div>
                    <div class="vue-swatches__swatch" aria-label="#222F3D" @click="l.textColor = '#222F3D'" role="button" tabindex="0" style="width: 42px; height: 42px; border-radius: 11px; background-color: rgb(34, 47, 61); cursor: pointer; margin-right: 11px; margin-bottom: 11px;"><!--v-if-->
                        <div class="vue-swatches__check__wrapper vue-swatches--has-children-centered" style="display: none;">
                            <div class="vue-swatches__check__circle vue-swatches--has-children-centered">
                                <svg version="1.1" role="presentation" width="12" height="12" viewBox="0 0 1792 1792" class="check">
                                    <path class="vue-swatches__check__path" d="M1671 566q0 40-28 68l-724 724-136 136q-28 28-68 28t-68-28l-136-136-362-362q-28-28-28-68t28-68l136-136q28-28 68-28t68 28l294 295 656-657q28-28 68-28t68 28l136 136q28 28 28 68z"></path>
                                </svg>
                            </div>
                        </div><!--v-if--></div>
                    <div class="vue-swatches__swatch" aria-label="#F2C511" @click="l.textColor = '#F2C511'" role="button" tabindex="0" style="width: 42px; height: 42px; border-radius: 11px; background-color: rgb(242, 197, 17); cursor: pointer; margin-right: 11px; margin-bottom: 11px;"><!--v-if-->
                        <div class="vue-swatches__check__wrapper vue-swatches--has-children-centered" style="display: none;">
                            <div class="vue-swatches__check__circle vue-swatches--has-children-centered">
                                <svg version="1.1" role="presentation" width="12" height="12" viewBox="0 0 1792 1792" class="check">
                                    <path class="vue-swatches__check__path" d="M1671 566q0 40-28 68l-724 724-136 136q-28 28-68 28t-68-28l-136-136-362-362q-28-28-28-68t28-68l136-136q28-28 68-28t68 28l294 295 656-657q28-28 68-28t68 28l136 136q28 28 28 68z"></path>
                                </svg>
                            </div>
                        </div><!--v-if--></div>
                    <div class="vue-swatches__swatch" aria-label="#F39C19" @click="l.textColor = '#F39C19'" role="button" tabindex="0" style="width: 42px; height: 42px; border-radius: 11px; background-color: rgb(243, 156, 25); cursor: pointer; margin-right: 11px; margin-bottom: 11px;"><!--v-if-->
                        <div class="vue-swatches__check__wrapper vue-swatches--has-children-centered" style="display: none;">
                            <div class="vue-swatches__check__circle vue-swatches--has-children-centered">
                                <svg version="1.1" role="presentation" width="12" height="12" viewBox="0 0 1792 1792" class="check">
                                    <path class="vue-swatches__check__path" d="M1671 566q0 40-28 68l-724 724-136 136q-28 28-68 28t-68-28l-136-136-362-362q-28-28-28-68t28-68l136-136q28-28 68-28t68 28l294 295 656-657q28-28 68-28t68 28l136 136q28 28 28 68z"></path>
                                </svg>
                            </div>
                        </div><!--v-if--></div>
                    <div class="vue-swatches__swatch" aria-label="#E84B3C" @click="l.textColor = '#E84B3C'" role="button" tabindex="0" style="width: 42px; height: 42px; border-radius: 11px; background-color: rgb(232, 75, 60); cursor: pointer; margin-right: 11px; margin-bottom: 11px;"><!--v-if-->
                        <div class="vue-swatches__check__wrapper vue-swatches--has-children-centered" style="display: none;">
                            <div class="vue-swatches__check__circle vue-swatches--has-children-centered">
                                <svg version="1.1" role="presentation" width="12" height="12" viewBox="0 0 1792 1792" class="check">
                                    <path class="vue-swatches__check__path" d="M1671 566q0 40-28 68l-724 724-136 136q-28 28-68 28t-68-28l-136-136-362-362q-28-28-28-68t28-68l136-136q28-28 68-28t68 28l294 295 656-657q28-28 68-28t68 28l136 136q28 28 28 68z"></path>
                                </svg>
                            </div>
                        </div><!--v-if--></div>
                    <div class="vue-swatches__swatch" aria-label="#C0382B" @click="l.textColor = '#C0382B'" role="button" tabindex="0" style="width: 42px; height: 42px; border-radius: 11px; background-color: rgb(192, 56, 43); cursor: pointer; margin-right: 11px; margin-bottom: 11px;"><!--v-if-->
                        <div class="vue-swatches__check__wrapper vue-swatches--has-children-centered" style="display: none;">
                            <div class="vue-swatches__check__circle vue-swatches--has-children-centered">
                                <svg version="1.1" role="presentation" width="12" height="12" viewBox="0 0 1792 1792" class="check">
                                    <path class="vue-swatches__check__path" d="M1671 566q0 40-28 68l-724 724-136 136q-28 28-68 28t-68-28l-136-136-362-362q-28-28-28-68t28-68l136-136q28-28 68-28t68 28l294 295 656-657q28-28 68-28t68 28l136 136q28 28 28 68z"></path>
                                </svg>
                            </div>
                        </div><!--v-if--></div>
                    <div class="vue-swatches__swatch" aria-label="#DDE6E8" @click="l.textColor = '#DDE6E8'" role="button" tabindex="0" style="width: 42px; height: 42px; border-radius: 11px; background-color: rgb(221, 230, 232); cursor: pointer; margin-right: 11px; margin-bottom: 11px;"><!--v-if-->
                        <div class="vue-swatches__check__wrapper vue-swatches--has-children-centered" style="display: none;">
                            <div class="vue-swatches__check__circle vue-swatches--has-children-centered">
                                <svg version="1.1" role="presentation" width="12" height="12" viewBox="0 0 1792 1792" class="check">
                                    <path class="vue-swatches__check__path" d="M1671 566q0 40-28 68l-724 724-136 136q-28 28-68 28t-68-28l-136-136-362-362q-28-28-28-68t28-68l136-136q28-28 68-28t68 28l294 295 656-657q28-28 68-28t68 28l136 136q28 28 28 68z"></path>
                                </svg>
                            </div>
                        </div><!--v-if--></div>
                    <div class="vue-swatches__swatch" aria-label="#BDC3C8" @click="l.textColor = '#BDC3C8'" role="button" tabindex="0" style="width: 42px; height: 42px; border-radius: 11px; background-color: rgb(189, 195, 200); cursor: pointer; margin-bottom: 11px;"><!--v-if-->
                        <div class="vue-swatches__check__wrapper vue-swatches--has-children-centered" style="display: none;">
                            <div class="vue-swatches__check__circle vue-swatches--has-children-centered">
                                <svg version="1.1" role="presentation" width="12" height="12" viewBox="0 0 1792 1792" class="check">
                                    <path class="vue-swatches__check__path" d="M1671 566q0 40-28 68l-724 724-136 136q-28 28-68 28t-68-28l-136-136-362-362q-28-28-28-68t28-68l136-136q28-28 68-28t68 28l294 295 656-657q28-28 68-28t68 28l136 136q28 28 28 68z"></path>
                                </svg>
                            </div>
                        </div><!--v-if--></div>
                </div><!--v-if--></div>
        </div>
    </div>
    <div class="mt-3">
        <label for="modal-form-3" class="form-label">Wielkość etykiety</label>
        <Slider id="modal-form-3" v-model="l.fontSize" :min="0" :max="55" style="width: 100%;"/>
    </div>
</template>
<style src="@vueform/slider/themes/default.css"></style>
<script>
import VSwatches from "../../../../components/color-swatches/VSwatches";
import {onMounted, ref, watch, watchEffect} from "vue";
import Slider from '@vueform/slider'

export default {
    name: "LabelDialog",
    components: {
        VSwatches, Slider
    },
    props: {
        label: Object
    },
    emits: ["update:label"],
    setup(props, context) {
        const l = ref({fontSize: 36, message: '', textColor: '', index: 0});

        watch(l, (lab, prevLabel) => {



            context.emit("update:label", l.value);
        }, {deep: true})

        onMounted(() => {

            if (props.label.message != undefined && props.label.message != '') {
                l.value.message = props.label.message;
            } else {
                l.value.message = '';
            }

            if (props.label.fontSize != undefined && props.label.fontSize != '') {
                l.value.fontSize = props.label.fontSize;
            } else {
                l.value.fontSize = 36;
            }

            if (props.label.textColor != undefined && props.label.textColor != '') {
                l.value.textColor = props.label.textColor;
            } else {
                l.value.textColor = '#222F3D';
            }
            l.value.index = props.label.index;
            l.value.labelPosition = props.label.labelPosition;
            l.value.labelRotation = props.label.labelRotation;
        });

        return {
            l
        }
    }
}
</script>

<style scoped>

</style>
