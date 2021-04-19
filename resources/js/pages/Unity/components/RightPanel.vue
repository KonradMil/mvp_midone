<template>
    <div
        id="header-footer-slide-over-preview"
        class="modal modal-slide-over"
        data-backdrop="static"
        tabindex="-1"
        aria-hidden="true"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <a data-dismiss="modal" href="javascript:;">
                    <XIcon class="w-8 h-8 text-gray-500" />
                </a>
                <!-- BEGIN: Slide Over Header -->
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">
                        Broadcast Message
                    </h2>
                    <button class="btn btn-outline-secondary hidden sm:flex">
                        <FileIcon class="w-4 h-4 mr-2" />
                        Download Docs
                    </button>
                    <div class="dropdown sm:hidden">
                        <a
                            class="dropdown-toggle w-5 h-5 block"
                            href="javascript:;"
                            aria-expanded="false"
                        >
                            <MoreHorizontalIcon
                                class="w-5 h-5 text-gray-600 dark:text-gray-600"
                            />
                        </a>
                        <div class="dropdown-menu w-40">
                            <div
                                class="dropdown-menu__content box dark:bg-dark-1 p-2"
                            >
                                <a
                                    href="javascript:;"
                                    class="flex items-center p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md"
                                >
                                    <FileIcon class="w-4 h-4 mr-2" />
                                    Download Docs
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Slide Over Header -->
                <!-- BEGIN: Slide Over Body -->
                <div class="modal-body">
                    <div>
                        <label for="modal-form-1" class="form-label"
                        >From</label
                        >
                        <input
                            id="modal-form-1"
                            type="text"
                            class="form-control"
                            placeholder="example@gmail.com"
                        />
                    </div>
                    <div class="mt-3">
                        <label for="modal-form-2" class="form-label">To</label>
                        <input
                            id="modal-form-2"
                            type="text"
                            class="form-control"
                            placeholder="example@gmail.com"
                        />
                    </div>
                    <div class="mt-3">
                        <label for="modal-form-3" class="form-label"
                        >Subject</label
                        >
                        <input
                            id="modal-form-3"
                            type="text"
                            class="form-control"
                            placeholder="Important Meeting"
                        />
                    </div>
                    <div class="mt-3">
                        <label for="modal-form-4" class="form-label"
                        >Has the Words</label
                        >
                        <input
                            id="modal-form-4"
                            type="text"
                            class="form-control"
                            placeholder="Job, Work, Documentation"
                        />
                    </div>
                    <div class="mt-3">
                        <label for="modal-form-5" class="form-label"
                        >Doesn't Have</label
                        >
                        <input
                            id="modal-form-5"
                            type="text"
                            class="form-control"
                            placeholder="Job, Work, Documentation"
                        />
                    </div>
                    <div class="mt-3">
                        <label for="modal-form-6" class="form-label"
                        >Size</label
                        >
                        <select id="modal-form-6" class="form-select">
                            <option>10</option>
                            <option>25</option>
                            <option>35</option>
                            <option>50</option>
                        </select>
                    </div>
                </div>
                <!-- END: Slide Over Body -->
                <!-- BEGIN: Slide Over Footer -->
                <div
                    class="modal-footer text-right w-full absolute bottom-0"
                >
                    <button
                        type="button"
                        data-dismiss="modal"
                        class="btn btn-outline-secondary w-20 mr-1"
                    >
                        Cancel
                    </button>
                    <button type="button" class="btn btn-primary w-20">
                        Send
                    </button>
                </div>
                <!-- END: Slide Over Footer -->
            </div>
        </div>
    </div>
</template>

<script>
import {getCurrentInstance, ref} from "vue";

export default {
    name: "RightPanel",
    setup() {
        //GLOBAL
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        const layouts = ref([]);
        const labels = ref([]);
        const comments = ref([]);
        const showSidebar = ref(false);

        emitter.on('UnityLayoutSelected', e => {

        });

        emitter.on('UnityLabelSelected', e => {

        });

        emitter.on('UnityCommentSelected', e => {

        });


    }
}
</script>

<style scoped>

</style>
