<template>
    <div>
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">Nowy post</h2>
            <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                <button
                    type="button"
                    class="btn box text-gray-700 dark:text-gray-300 mr-2 flex items-center ml-auto sm:ml-0"
                >
                    <EyeIcon class="w-4 h-4 mr-2"/>
                    Podgląd
                </button>
                <button
                    class="dropdown-toggle btn btn-primary mr-2 shadow-md flex items-center  ml-auto sm:ml-0"
                    aria-expanded="false"
                    @click="saveKnowledgebasePost"
                >
                    <SaveIcon class="w-4 h-4 mr-2"/>
                    Zapisz
                </button>
            </div>
        </div>
        <div class="pos intro-y grid grid-cols-12 gap-5 mt-5">
            <!-- BEGIN: Post Content -->
            <div class="intro-y col-span-12 lg:col-span-8">
                <input
                    type="text"
                    class="intro-y form-control py-3 px-4 box pr-10 placeholder-theme-13"
                    placeholder="Nazwa"
                    v-model="name"
                />
                <div class="post intro-y overflow-hidden box mt-5">
                    <div
                        class="post__tabs nav nav-tabs flex-col sm:flex-row bg-gray-300 dark:bg-dark-2 text-gray-600"
                        role="tablist"
                    >
                        <Tippy
                            id="content-tab"
                            tag="a"
                            content="Fill in the article content"
                            data-toggle="tab"
                            data-target="#content"
                            href="javascript:;"
                            class="w-full sm:w-40 py-4 text-center flex justify-center items-center active"
                            role="tab"
                            aria-controls="content"
                            aria-selected="true"
                            @click="tab = 'desc'"
                        >
                            <FileTextIcon class="w-4 h-4 mr-2"/>
                            Główne
                        </Tippy>
                    </div>
                    <div class="post__content tab-content">
                        <div
                            v-if="tab === 'desc'"
                            id="content"
                            class="tab-pane p-5 active"
                            role="tabpanel"
                            aria-labelledby="content-tab"
                        >
                            <div
                                class="border border-gray-200 dark:border-dark-5 rounded-md p-5"
                            >
                                <div
                                    class="font-medium flex items-center border-b border-gray-200 dark:border-dark-5 pb-5"
                                >
                                    <ChevronDownIcon class="w-4 h-4 mr-2"/>
                                    Opis
                                </div>
                                <div class="mt-5">
                                    <textarea v-model="description" style="width: 100%;"></textarea>
                                </div>
                            </div>
                            <div
                                class="border border-gray-200 dark:border-dark-5 rounded-md p-5 mt-5"
                            >
                                <input
                                    type="text"
                                    class="intro-y form-control py-3 px-4 box pr-10 placeholder-theme-13"
                                    placeholder="Youtube ID"
                                    v-model="youtube"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Post Content -->
            <!-- BEGIN: Post Info -->
            <div class="col-span-12 lg:col-span-4">
                <div class="intro-y box p-5">
                    <div class="mt-3">
                        <label for="post-form-3" class="form-label">Categories</label>
                        <TailSelect
                            id="post-form-3"
                            v-model="category"
                            :options="{
                                locale: 'pl',
                                placeholder: 'Wybierz kategorie...',
                                limit: 'Nie można wybrać więcej',
                search: false,

                hideSelected: false,



                classNames: 'w-full'
              }"
                        >

                            <option selected disabled>Wybierz kategorie...</option>
                            <option v-for="(category,index) in categories" :value="category.value">{{ category.name }}</option>

                        </TailSelect>
                    </div>
                    <div class="form-check flex-col items-start mt-3">
                        <label for="post-form-5" class="form-check-label ml-0 mb-2"
                        >Publikuj</label
                        >
                        <input id="post-form-5" class="form-check-switch" v-model="published" type="checkbox"/>
                    </div>
                </div>
            </div>
            <!-- END: Post Info -->
        </div>
    </div>
</template>

<script>
import {onMounted, ref} from "vue";
import SavePost from "../../compositions/SavePost";

export default {
    name: "AddKnowledgebase",
    setup() {
        const name = ref('');
        const description = ref('');
        const youtube = ref('');
        const tab = ref('desc');
        const categories = ref([])
        const category = ref('');
        const published = ref(false);

        const saveKnowledgebasePost = async () => {
            SavePost({
                name: name.value,
                description: description.value,
                type: category.value,
                youtube: youtube.value,
                category: category.value,
                published: published.value
            });
        }


        onMounted(function () {
            const c = require("../../json/knowledgebase_categories.json");
            categories.value = c.categories;
        });

        return {
            name,
            description,
            tab,
            categories,
            category,
            saveKnowledgebasePost,
            youtube,
            published
        }
    }
}
</script>

<style scoped>

</style>
