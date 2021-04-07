<template>
    <div v-if="visible" style="background-color: #fff" class="ml-36 flex fixed h-full z-50 pt-2">
        <div class="flex-1 pt-2 ml-10">
            <div class="w-full sm:w-auto relative mr-auto mt-3 sm:mt-0">
                <SearchIcon
                    class="w-4 h-4 absolute my-auto inset-y-0 ml-3 left-0 z-10 text-gray-700 dark:text-gray-300"
                />
                <input
                    v-model="search"
                    type="text"
                    class="form-control w-full sm:w-64 box px-10 text-gray-700 dark:text-gray-300 placeholder-theme-13"
                    placeholder="Szukaj..."
                />
            </div>
            <div class="w-full sm:w-auto relative mr-auto mt-1 sm:mt-0">
               <div class="" v-for="(subcat, index) in subcategories" :key="'subcat_' + index">
                    <div class="h5">
                        {{subcat.name}}
                    </div>
               </div>
            </div>
        </div>
    </div>
</template>

<script>
import {getCurrentInstance, onMounted, ref} from "vue";

export default {
    name: "LeftPanel",
    setup() {
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        const search = ref('');
        const category = ref(0);
        const subcategory = ref(0);
        const subcategories = ref([]);
        const categories = ref([]);
        const visible = ref(false);
        //LEFT BUTTON CLICKED
        emitter.on('leftbuttonclick', e =>  handleChange(e.val) )

        const handleChange = (cat_id) => {
            subcategory.value = 0
            if(category.value === cat_id) {
                category.value = 0;
                visible.value = false;
            } else {
                category.value = cat_id;
                console.log(cat_id);
                visible.value = true;
                subcategories.value = categories[cat_id].subcategories;
            }
        }

        onMounted(()=> {
            const  c = require("../../../json/model_categories.json");
            categories.value = c.categories;
        });

        return {
            search,
            visible,
            subcategories,
            category,
            categories
        }
    }
}
</script>

<style scoped>

</style>
