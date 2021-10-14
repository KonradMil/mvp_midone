<template>
    <div id="workshop-modal" class="modal" tabindex="-1" aria-hidden="false" style=" ">
        <div class="modal-dialog modal-xl" style="margin-top: 2rem; width: 90vw;">
            <div class="modal-content">
                <div class="modal-body p-5 text-center">
                    <div class="grid grid-cols-1 gap-6 mt-1">
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
import {onMounted, ref, watch} from "vue";
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
        },
    },
    setup(props) {
        // watch(() => props.open, (first, second) => {

        //     // if(first == true) {
        //         cash("#workshop-modal").modal("show");
        //     // } else {
        //     //     cash("#workshop-modal").modal("close");
        //     // }
        // });

        return {

        }
    }
};
</script>
