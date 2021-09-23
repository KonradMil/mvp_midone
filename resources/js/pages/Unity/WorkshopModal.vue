<template>
    <div id="help-modal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body p-10 text-center">
                    <div class="grid grid-cols-1 gap-6 mt-5">
                        <!-- BEGIN: Profile Menu -->
                        <div class="col">
                            <Workshop></Workshop>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {onMounted, ref} from "vue";
import Workshop from './Workshop/Workshop';
export default {
    name: 'WorkshopModal',
    components: {
        Workshop
    },
    props: {
        open: {
            type: Boolean,
            default: false
        }
    },
    setup(props) {

        onMounted(() => {
        });

        return {

        }
    }
};
</script>
