<template>
    <div v-if="visible">
        <div class="ml-36 flex fixed h-full z-50 pt-2" style="margin-left: 8.9rem; background-color: #fff;">
            <div class="flex-1 pt-2">
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
                <div class="w-full sm:w-auto relative mr-auto mt-1 sm:mt-0 p-2">
                    <div v-for="(subcat, index) in subcategories" :key="'subcat_' + index" @click="subcategory = subcat.value; getModelRepositories();">
                        <div
                            class="col-span-12 sm:col-span-4 xxl:col-span-3 box bg-theme-1 dark:bg-theme-1 p-5 m-2 cursor-pointer zoom-in"
                        >
                            <div class="font-medium text-base text-white">{{ subcat.name }}</div>
                            <div class="text-theme-22 dark:text-gray-400">8 Items</div>
                        </div>
                    </div>
                </div>
                <div class="w-full sm:w-auto relative mr-auto mt-1 sm:mt-0 p-2" v-if="category == 1 && subcategory == 0">

                    <div class="p-5 m-2" v-for="(brand, index) in brands.brands" :key="'subcat_' + index" @click="subcategory = subcat.value">
                        <div class="flex-none pos-image relative block">
                            <div class="pos-image__preview image-fit">
                                <img
                                    :alt="brand.name"
                                    :src="brand.image"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="margin-left: 8.9rem; background-color: #fff;" class="ml-36 flex fixed h-full z-50 pt-2" v-if="subcategory != null">
            <div class="flex-1 pt-2">
                <div class="w-full sm:w-auto relative mr-auto mt-3 sm:mt-0" v-if="category != 1 && subcategory != 0">
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
                <div class="w-full sm:w-auto relative mr-auto mt-3 sm:mt-0" v-if="category == 1 && subcategory == 0">
                    <div class="w-full sm:w-auto relative mr-auto mt-3 sm:mt-0">
                        <SearchIcon
                            class="w-4 h-1 absolute my-auto inset-y-0 ml-3 left-0 z-10 text-gray-700 dark:text-gray-300" style="visibility: hidden"
                        />
                        <input style="visibility: hidden"
                               v-model="search"
                               type="text"
                               class="form-control w-full sm:w-64 box px-10 text-gray-700 dark:text-gray-300 placeholder-theme-13 h-1"
                               placeholder="Szukaj..."
                        />
                    </div>
                    <div class="p-5 w-full sm:w-auto relative mr-auto mt-3 sm:mt-0">
                        <button class="btn btn-primary shadow-md w-1/2" @click="subcategory = null;">Powrót</button>
                    </div>
                    <div class="p-5 w-full" v-for="(brand, index) in brands" :key="'subcat_' + index" @click="selectedBrand = brand.brand; getModelRepositories();">
                        <div class="flex-none pos-image relative block w-full">
                            <div class="pos-image__preview image-fit h-24 w-full shadow-md rounded-md  zoom-in">
                                <img
                                    class="w-full p-4 "
                                    :alt="brand.name"
                                    :src="brand.image"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="margin-left: 8.9rem; background-color: #fff;" class="ml-36 flex fixed h-full z-50 pt-2" v-if="(category == 1 && subcategory == 0 && selectedBrand != '') || ((category != 1 && subcategory != 0) && subcategory != null)">
            <div class="w-full sm:w-auto relative mr-auto mt-3 sm:mt-0">
                <div class="w-full sm:w-auto relative mr-auto mt-3 sm:mt-0">
                    <SearchIcon
                        class="w-4 h-1 absolute my-auto inset-y-0 ml-3 left-0 z-10 text-gray-700 dark:text-gray-300" style="visibility: hidden"
                    />
                    <input style="visibility: hidden"
                           v-model="search"
                           type="text"
                           class="form-control w-full sm:w-64 box px-10 text-gray-700 dark:text-gray-300 placeholder-theme-13 h-1"
                           placeholder="Szukaj..."
                    />
                </div>
                <div class="p-5 w-full sm:w-auto relative mr-auto mt-3 sm:mt-0">
                    <button class="btn btn-primary shadow-md w-1/2" @click="subcategory = null; selectedBrand = '';">Powrót</button>
                </div>
                <div class=" p-5 w-full" v-for="(model, index) in models.list" :key="'model_' + index" @click="selectModel(model)">
                    <div class=" shadow-md rounded-md zoom-in">
                        <div class="flex-none pos-image relative block w-full">
                            <div class="pos-image__preview image-fit h-24 w-full">
                                <img
                                    class="w-full p-4 "
                                    :alt="model.name"
                                    :src="'s3/models_images/' + model.model_file + '.png'"
                                />

                            </div>
                        </div>
                        <h5 class="model_name w-full">{{model.name}}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div style="margin-left: 8.9rem; background-color: #fff;" class="ml-36 flex fixed h-full z-50 pt-2" v-if="!((category != 1 && subcategory != 0) && subcategory != null)">
            <div class="w-full sm:w-auto relative mr-auto mt-3 sm:mt-0">
                <div class="w-full sm:w-auto relative mr-auto mt-3 sm:mt-0">
                    <SearchIcon
                        class="w-4 h-1 absolute my-auto inset-y-0 ml-3 left-0 z-10 text-gray-700 dark:text-gray-300" style="visibility: hidden"
                    />
                    <input style="visibility: hidden"
                           v-model="search"
                           type="text"
                           class="form-control w-full sm:w-64 box px-10 text-gray-700 dark:text-gray-300 placeholder-theme-13 h-1"
                           placeholder="Szukaj..."
                    />
                </div>
                <div class="p-5 w-full sm:w-auto relative mr-auto mt-3 sm:mt-0">
                    <button class="btn btn-primary shadow-md w-1/2" @click="subcategory = null;">Powrót</button>
                </div>
                <div class=" p-5 w-full" v-for="(model, index) in models.list" :key="'model_' + index" @click="selectModel(model)">
                    <div class=" shadow-md rounded-md zoom-in">
                        <div class="flex-none pos-image relative block w-full">
                            <div class="pos-image__preview image-fit h-24 w-full">
                                <img
                                    class="w-full p-4 "
                                    :alt="model.name"
                                    :src="'s3/models_images/' + model.model_file + '.png'"
                                />

                            </div>
                        </div>
                        <h5 class="model_name w-full">{{model.name}}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {getCurrentInstance, onMounted, ref, watch} from "vue";
import GetModels from "../../../compositions/GetModels";


export default {
    name: "LeftPanel",

    setup(props, {emit}) {
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        const search = ref('');
        const selectedBrand = ref('');
        const category = ref(null);
        const subcategory = ref(null);
        const subcategories = ref([]);
        const categories = ref([]);
        const visible = ref(false);
        const models = ref([]);
        const brands = require("../../../json/robot_brands.json");
        //LEFT BUTTON CLICKED
        emitter.on('leftbuttonclick', e => handleChange(e.val))
        console.log(props);


        const getModelRepositories = async () => {
            models.value = GetModels({
                category_id: category.value,
                subcategory_id: subcategory.value,
                brand: selectedBrand.value
            });
        }

        const selectModel = (model) => {
            emitter.emit('unityoutgoingaction', { action: 'placeObject', data:model })
        }

        const handleChange = (cat_id) => {
            subcategory.value = null
            if (category.value === cat_id) {
                category.value = null;
                visible.value = false;
            } else {
                category.value = cat_id;
                console.log(cat_id);
                visible.value = true;
                console.log(categories.value[cat_id]);
                subcategories.value = categories.value[cat_id]['subcategories'];
            }
        }

        onMounted(() => {
            const c = require("../../../json/model_categories.json");
            categories.value = c.categories;
        });


        return {
            search,
            visible,
            subcategories,
            category,
            categories,
            subcategory,
            models,
            brands,
            getModelRepositories,
            selectedBrand,
            selectModel
        }
    }
}
</script>

<style scoped>

</style>
