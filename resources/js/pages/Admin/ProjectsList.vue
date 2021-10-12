<template>
    <div>
        <h2 class="intro-y text-lg font-medium mt-10">Ongoing projects</h2>
        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
                <!--                <button class="btn btn-primary shadow-md mr-2">Add New Product</button>-->
                <!--                <div class="dropdown">-->
                <!--                    <button class="dropdown-toggle btn px-2 box text-gray-700 dark:text-gray-300" aria-expanded="false">-->
                <!--                    <span class="w-5 h-5 flex items-center justify-center">-->
                <!--                    <PlusIcon class="w-4 h-4"/>-->
                <!--                    </span>-->
                <!--                    </button>-->
                <!--                    <div class="dropdown-menu w-40">-->
                <!--                        <div class="dropdown-menu__content box dark:bg-dark-1 p-2">-->
                <!--                            <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">-->
                <!--                                <PrinterIcon class="w-4 h-4 mr-2"/>-->
                <!--                                Print-->
                <!--                            </a>-->
                <!--                            <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">-->
                <!--                                <FileTextIcon class="w-4 h-4 mr-2"/>-->
                <!--                                Export to Excel-->
                <!--                            </a>-->
                <!--                            <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">-->
                <!--                                <FileTextIcon class="w-4 h-4 mr-2"/>-->
                <!--                                Export to PDF-->
                <!--                            </a>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                </div>-->
                <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                    <div class="w-56 relative text-gray-700 dark:text-gray-300">
                        <input type="text" class="form-control w-56 box pr-10 placeholder-theme-13" placeholder="Search..."/>
                        <SearchIcon class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0"/>
                    </div>
                </div>
            </div>
            <!-- BEGIN: Data List -->
            <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                <table class="table table-report -mt-2">
                    <thead>
                    <tr>
                        <th class="whitespace-nowrap">Zdjęcie</th>
                        <th class="whitespace-nowrap">Nazwa wyzwania</th>
                        <th class="text-center whitespace-nowrap">Status</th>
                        <th class="text-center whitespace-nowrap">Firma - inwestor</th>
                        <th class="text-center whitespace-nowrap">Firma - integrator</th>
                        <th class="text-center whitespace-nowrap">Akcje</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(project, index) in projects" :key="'proj_' + index" class="intro-x">
                        <td class="w-40">
                            <div class="flex">
                                <div class="w-10 h-10 image-fit zoom-in">
                                                                        <img
                                                                            alt="DBR77"
                                                                            class="rounded-full"
                                                                            :src="project.screenshot_path"
                                                                        />
                                </div>
                            </div>
                        </td>
                        <td>
                            {{project.name}}
                        </td>
                        <td class="text-center">
                            {{project.status}}
                        </td>
                        <td class="w-40">
                            {{project.author.name}} {{project.author.lastname}}
                        </td>
                        <td class="w-40">
<!--                            {{project.author.firstname}} {{project.author.lastname}}-->
                        </td>
                        <td class="table-report__action w-56">
                            <div class="flex justify-center items-center">
                                <a class="flex items-center mr-3" href="javascript:;">
                                    <CheckSquareIcon class="w-4 h-4 mr-1"/>
                                    Edit
                                </a>
                                <a class="flex items-center text-theme-6" href="javascript:;" data-toggle="modal" data-target="#delete-confirmation-modal">
                                    <Trash2Icon class="w-4 h-4 mr-1"/>
                                    Delete
                                </a>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!-- END: Data List -->
        </div>
    </div>
</template>


<script>
import {computed, onMounted, ref} from "vue";
import cash from "cash-dom";
import {useToast} from "vue-toastification";
import RequestHandler from '../../compositions/RequestHandler'

export default {
    name: "ProjectsList",
    setup() {
        const toast = useToast();
        const projects = ref([]);

        onMounted(() => {
            cash("body").removeClass("error-page");
        });

        const getData = () => {
            axios.get('/api/admin/projects/get')
                .then(response => {
                    projects.value = response.data.payload;
                })
        }

        onMounted(() => {
            getData();
        });

        return {
            projects
        }
    }
}
</script>

<style scoped>

</style>
