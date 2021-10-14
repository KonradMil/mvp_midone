<template>
    <div>
        <div class="col-span-12 lg:col-span-4">
            <div class="intro-y box p-5" style="z-index: 99999;">
                <div class="mt-3">
                    <label for="post-form-3" class="form-label">{{ $t('models.cat') }}</label>
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
                                }">
                        <option selected disabled>{{ $t('challengesNew.selectCategories') }}</option>
                        <option v-for="(category,index) in categories" :value="category.value">{{ category.name }}</option>
                    </TailSelect>
                </div>
            </div>
            <div class="intro-y box p-5" v-if="category != ''" style="z-index: 99999;">
                <div class="mt-3">
                    <label for="post-form-3" class="form-label">{{ $t('models.subcat') }}</label>
                    <TailSelect
                        id="post-form-3"
                        v-model="subcategory"
                        :options="{
                                locale: 'pl',
                                placeholder: 'Wybierz kategorie...',
                                limit: 'Nie można wybrać więcej',
                                search: false,
                                hideSelected: false,
                                classNames: 'w-full'
                                }">
                        <option selected disabled>{{ $t('challengesNew.selectCategories') }}</option>
                        <option v-for="(cat,index) in categories[category].subcategories" :value="cat.value">{{ cat.name }}</option>
                    </TailSelect>
                    <button type="button" class="btn btn-primary shadow-md mr-2" @click="getModelRepositories">Szukaj</button>
                </div>
            </div>
        </div>
        <h2 class="intro-y text-lg font-medium mt-10">{{$t('models.models')}}</h2>
        <div class="grid grid-cols-12 gap-6 mt-5">
            <div
                class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2"
            >
                <button class="btn btn-primary shadow-md mr-2" @click="$router.push({name: 'modelsAdd'})">{{$t('models.addModel')}}</button>
                <div class="hidden md:block mx-auto text-gray-600">

                </div>
                <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                    <div class="w-56 relative text-gray-700 dark:text-gray-300">
                        <input
                            type="text"
                            class="form-control w-56 box pr-10 placeholder-theme-13"
                            :placeholder="$t('global.search')"
                        />
                        <SearchIcon
                            class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0"
                        />
                    </div>
                </div>
            </div>
            <!-- BEGIN: Data List -->
            <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                <table class="table table-report -mt-2">
                    <thead>
                    <tr>
                        <th class="whitespace-nowrap">{{$t('models.photo')}}</th>
                        <th class="whitespace-nowrap">{{$t('models.name')}}</th>
                        <th class="whitespace-nowrap">Model</th>
                        <th class="whitespace-nowrap">{{$t('models.brand')}}</th>
                        <th class="whitespace-nowrap">{{$t('models.cat')}}</th>
                        <th class="whitespace-nowrap">{{$t('models.actions')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr
                        v-for="(model, index) in models.list"
                        :key="index"
                        class="intro-x"
                    >
                        <td>
                            <div class="flex">
                                <div class="w-10 h-10 image-fit zoom-in">
                                    <Tippy
                                        tag="img"
                                        :alt="model.name"
                                        class="rounded-full"
                                        :src="'/s3/models_images/' + model.model_file + '.png'"
                                        :content="model.name"
                                    />
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="font-medium whitespace-nowrap">
                                {{model.name }}
                            </div>
                        </td>
                        <td>
                            <div class="text-gray-600 text-xs whitespace-nowrap mt-0.5">
                                {{ model.model }}
                            </div>
                        </td>
                        <td>
                            <div class="text-gray-600 text-xs whitespace-nowrap mt-0.5">
                                {{ model.brand }}
                            </div>
                        </td>
                        <td>
                            <a href="" class="font-medium whitespace-nowrap">
                                <CategoryName :categories="categories" :id="model.category"/>
                            </a>
                            <div class="text-gray-600 text-xs whitespace-nowrap mt-0.5">
                                <SubcategoryName :categories="categories" :id="model.subcategory" :catid="model.category"/>
                            </div>
                        </td>
                        <td class="table-report__action w-56">
                            <div class="flex justify-center items-center">
                                <a class="flex items-center mr-3" href="" @click.prevent="$router.push({path: '/models/edit/' + model.id})">
                                    <CheckSquareIcon class="w-4 h-4 mr-1"/>
                                    {{$t('models.edit')}}
                                </a>
                                <a
                                    @click="temp_model_id = model.id"
                                    class="flex items-center text-theme-6"
                                    href="javascript:;"
                                    data-toggle="modal"
                                    data-target="#delete-confirmation-modal"
                                >
                                    <Trash2Icon class="w-4 h-4 mr-1"/>
                                    {{$t('models.delete')}}
                                </a>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!-- END: Data List -->
            <!-- BEGIN: Pagination -->
<!--            <div-->
<!--                class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center"-->
<!--            >-->
<!--                <ul class="pagination">-->
<!--                    <li>-->
<!--                        <a class="pagination__link" href="">-->
<!--                            <ChevronsLeftIcon class="w-4 h-4"/>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a class="pagination__link" href="">-->
<!--                            <ChevronLeftIcon class="w-4 h-4"/>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a class="pagination__link" href="">...</a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a class="pagination__link" href="">1</a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a class="pagination__link pagination__link&#45;&#45;active" href="">2</a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a class="pagination__link" href="">3</a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a class="pagination__link" href="">...</a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a class="pagination__link" href="">-->
<!--                            <ChevronRightIcon class="w-4 h-4"/>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                    <li>-->
<!--                        <a class="pagination__link" href="">-->
<!--                            <ChevronsRightIcon class="w-4 h-4"/>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                </ul>-->
<!--                <select class="w-20 form-select box mt-3 sm:mt-0">-->
<!--                    <option>10</option>-->
<!--                    <option>25</option>-->
<!--                    <option>35</option>-->
<!--                    <option>50</option>-->
<!--                </select>-->
<!--            </div>-->
            <!-- END: Pagination -->
        </div>
        <!-- BEGIN: Delete Confirmation Modal -->
        <div
            id="delete-confirmation-modal"
            class="modal"
            tabindex="-1"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="p-5 text-center">
                            <XCircleIcon class="w-16 h-16 text-theme-6 mx-auto mt-3"/>
                            <div class="text-3xl mt-5">{{$t('models.areSure')}}</div>
                            <div class="text-gray-600 mt-2">
                                {{ $t('models.reallyDelete') }} <br/>
                                {{ $t('models.processUndone') }}
                            </div>
                        </div>
                        <div class="px-5 pb-8 text-center">
                            <button
                                type="button"
                                data-dismiss="modal"
                                class="btn btn-outline-secondary w-24 mr-1"
                            >
                                {{ $t('models.cancel') }}
                            </button>
                            <button @click="del(temp_model_id)" type="button" class="btn btn-danger w-24" data-dismiss="modal">{{ $t('models.delete') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Delete Confirmation Modal -->
    </div>
</template>

<script>
import {computed, onMounted, ref} from "vue";
import GetModels from "../../compositions/GetModels";
import DeleteModel from "../../compositions/DeleteModel";
import cash from "cash-dom";
import CategoryName from "./CategoryName";
import SubcategoryName from "./SubcategoryName";
import {useToast} from "vue-toastification";


export default {
    name: "List",
    components: {SubcategoryName, CategoryName},
    setup() {
        const toast = useToast();
        const model = ref('');
        const models = ref([]);
        const categories = ref([]);
        const types = require("../../json/model_categories.json");
        const category = ref('');
        const subcategory = ref('');
        const temp_model_id = ref(null);
        const del = async(model) => {
            await axios.post('/api/model/delete', {id: temp_model_id.value})
                .then(response => {

                    if (response.data.success) {

                        getModelRepositories();
                        toast.success(response.data.message);
                    } else {
                        toast.error('Ups! Coś poszło nie tak!');
                    }
                })
        }
        const getModelRepositories = async () => {
            models.value = GetModels({category: category.value, subcategory: subcategory.value});
        }

        onMounted(() => {
            categories.value = types.categories;
            cash("body")
                .removeClass("error-page");
        });

        getModelRepositories();
        return {
            model,
            models,
            categories,
            DeleteModel,
            del,
            category,
            subcategory,
            getModelRepositories,
            temp_model_id
        }
    }
}
</script>

<style scoped>

</style>
