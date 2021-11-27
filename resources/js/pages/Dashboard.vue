<template>
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 xxl:col-span-9">
            <div class="grid grid-cols-12 gap-6">
                <!-- BEGIN: Notification -->
<!--                <div class="col-span-12 mt-6 -mb-6 intro-y">-->
<!--                    <div-->
<!--                        class="alert alert-dismissible show box bg-theme-3 text-white flex items-center mb-6"-->
<!--                        role="alert"-->
<!--                    >-->
<!--            <span-->
<!--            >Najnowszy webinar 20.04.2021 - więcej na-->
<!--              <a-->
<!--                  href="https://drb77.com"-->
<!--                  class="underline ml-1"-->
<!--                  target="blank"-->
<!--              >dbr77.com</a-->
<!--              >.</span-->
<!--            >-->
<!--                        <button-->
<!--                            type="button"-->
<!--                            class="btn-close"-->
<!--                            data-bs-dismiss="alert"-->
<!--                            aria-label="Close"-->
<!--                        >-->
<!--                            <XIcon class="w-4 h-4"/>-->
<!--                        </button>-->
<!--                    </div>-->
<!--                </div>-->


                <!-- BEGIN: Notification -->
                <!-- BEGIN: General Report -->
<!--                <div class="col-span-12 lg:col-span-8 xl:col-span-6 mt-2">-->
<!--                    <div class="intro-y block sm:flex items-center h-10">-->
<!--                        <h2 class="text-lg font-medium truncate mr-5">Finanse</h2>-->
<!--                        <select class="sm:ml-auto mt-3 sm:mt-0 sm:w-auto form-select box">-->
<!--                            <option value="daily">Dziennie</option>-->
<!--                            <option value="weekly">Tygodniowo</option>-->
<!--                            <option value="monthly">Miesięcznie</option>-->
<!--                            <option value="yearly">Rocznie</option>-->
<!--                            <option value="custom-date">Własny zakres</option>-->
<!--                        </select>-->
<!--                    </div>-->
<!--                    <div class="report-box-2 intro-y mt-12 sm:mt-5">-->
<!--                        <div class="box sm:flex">-->
<!--                            <div class="px-8 py-12 flex flex-col justify-center flex-1">-->
<!--                                <ShoppingBagIcon class="w-10 h-10 text-theme-12"/>-->
<!--                                <div class="relative text-3xl font-bold mt-12 pl-4">-->
<!--                                    54.143 <span class="absolute text-xl top-2"> zł</span>-->
<!--                                </div>-->
<!--                                <div-->
<!--                                    class="report-box-2__indicator bg-theme-9 tooltip cursor-pointer"-->
<!--                                    title="47% Higher than last month"-->
<!--                                >-->
<!--                                    47%-->
<!--                                    <ChevronUpIcon class="w-4 h-4 ml-0.5"/>-->
<!--                                </div>-->
<!--                                <div class="mt-4 text-gray-600 dark:text-gray-600">-->
<!--                                    Zarobki w danym okresie po odjęciu kosztów oraz podatków.-->
<!--                                </div>-->
<!--                                <button-->
<!--                                    class="btn btn-outline-secondary relative justify-start rounded-full mt-12"-->
<!--                                >-->
<!--                                    Pobierz raporty-->
<!--                                    <span-->
<!--                                        class="w-8 h-8 absolute flex justify-center items-center bg-theme-1 text-white rounded-full right-0 top-0 bottom-0 my-auto ml-auto mr-0.5"-->
<!--                                    >-->
<!--                    <ArrowRightIcon class="w-4 h-4"/>-->
<!--                  </span>-->
<!--                                </button>-->
<!--                            </div>-->
<!--                            <div-->
<!--                                class="px-8 py-12 flex flex-col justify-center flex-1 border-t sm:border-t-0 sm:border-l border-gray-300 dark:border-dark-5 border-dashed"-->
<!--                            >-->
<!--                                <div class="text-gray-600 dark:text-gray-600 text-xs">-->
<!--                                    WSZYSTKICH TRANSAKCJI-->
<!--                                </div>-->
<!--                                <div class="mt-1.5 flex items-center">-->
<!--                                    <div class="text-base">4</div>-->
<!--                                    <div-->
<!--                                        class="text-theme-6 flex text-xs font-medium tooltip cursor-pointer ml-2"-->
<!--                                        title="2% Lower than last month"-->
<!--                                    >-->
<!--                                        2%-->
<!--                                        <ChevronDownIcon class="w-4 h-4 ml-0.5"/>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="text-gray-600 dark:text-gray-600 text-xs mt-5">-->
<!--                                    NOWYCH TRANSAKCJI-->
<!--                                </div>-->
<!--                                <div class="mt-1.5 flex items-center">-->
<!--                                    <div class="text-base">72.000zł</div>-->
<!--                                    <div-->
<!--                                        class="text-theme-9 flex text-xs font-medium tooltip cursor-pointer ml-2"-->
<!--                                        title="49% Higher than last month"-->
<!--                                    >-->
<!--                                        49%-->
<!--                                        <ChevronDownIcon class="w-4 h-4 ml-0.5"/>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
                <!-- END: General Report -->
                <!-- BEGIN: Recent Activities -->
<!--                <div-->
<!--                    class="col-span-12 xl:col-span-6 mt-2"-->
<!--                >-->
<!--                    <div class="intro-x flex items-center h-10">-->
<!--                        <h2 class="text-lg font-medium truncate mr-5">-->
<!--                            Ostatnie aktywności-->
<!--                        </h2>-->
<!--                    </div>-->
<!--                    <div class="report-timeline mt-5 relative">-->
<!--                        <div class="intro-x text-gray-500 text-xs text-center my-4">-->
<!--                            Dzisiaj-->
<!--                        </div>-->
<!--                        <div class="intro-x relative flex items-center mb-3" v-for="(log, index) in logs" :key="index + '_activity'" @click="$router.push({path: '/challenges/card/' + log.subject_id})">-->
<!--                            <div class="report-timeline__image">-->
<!--                                <div-->
<!--                                    class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden"-->
<!--                                >-->
<!--                                    <img-->
<!--                                        alt="DBR77"-->
<!--                                        :src="'/' + log.subject.screenshot_path"-->
<!--                                    />-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="box px-5 py-3 ml-4 flex-1 zoom-in">-->
<!--                                <div class="flex items-center">-->
<!--                                    <div class="font-medium">-->
<!--                                        Nowe wyzwanie-->
<!--                                    </div>-->
<!--                                    <div class="text-xs text-gray-500 ml-auto">{{$dayjs(log.created_at).fromNow()}}</div>-->
<!--                                </div>-->
<!--                                <div class="text-gray-600 mt-1">{{log.description}}</div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
                <!-- END: Recent Activities -->
                <!-- BEGIN: Schedules -->
<!--                <div class="col-span-12 xl:col-span-6 mt-2">-->
<!--                    <div class="intro-x flex items-center h-10">-->
<!--                        <h2 class="text-lg font-medium truncate mr-5">Kalendarium</h2>-->
<!--                        <a-->
<!--                            href=""-->
<!--                            class="ml-auto text-theme-1 dark:text-theme-10 truncate flex items-center"-->
<!--                        >-->
<!--                            <PlusIcon class="w-4 h-4 mr-1"/>-->
<!--                            Dodaj zadanie-->
<!--                        </a>-->
<!--                    </div>-->
<!--                    <div class="mt-5">-->
<!--                        <div class="intro-x box">-->
<!--                            <div class="p-5">-->
<!--                                <div class="flex">-->
<!--                                    <ChevronLeftIcon class="w-5 h-5 text-gray-600"/>-->
<!--                                    <div class="font-medium text-base mx-auto">Kwiecień</div>-->
<!--                                    <ChevronRightIcon class="w-5 h-5 text-gray-600"/>-->
<!--                                </div>-->
<!--                                <div class="grid grid-cols-7 gap-4 mt-5 text-center">-->
<!--                                    <div class="font-medium">Su</div>-->
<!--                                    <div class="font-medium">Mo</div>-->
<!--                                    <div class="font-medium">Tu</div>-->
<!--                                    <div class="font-medium">We</div>-->
<!--                                    <div class="font-medium">Th</div>-->
<!--                                    <div class="font-medium">Fr</div>-->
<!--                                    <div class="font-medium">Sa</div>-->
<!--                                    <div class="py-0.5 rounded relative text-gray-600">29</div>-->
<!--                                    <div class="py-0.5 rounded relative text-gray-600">30</div>-->
<!--                                    <div class="py-0.5 rounded relative text-gray-600">31</div>-->
<!--                                    <div class="py-0.5 rounded relative">1</div>-->
<!--                                    <div class="py-0.5 rounded relative">2</div>-->
<!--                                    <div class="py-0.5 rounded relative">3</div>-->
<!--                                    <div class="py-0.5 rounded relative">4</div>-->
<!--                                    <div class="py-0.5 rounded relative">5</div>-->
<!--                                    <div-->
<!--                                        class="py-0.5 bg-theme-18 dark:bg-theme-9 rounded relative"-->
<!--                                    >-->
<!--                                        6-->
<!--                                    </div>-->
<!--                                    <div class="py-0.5 rounded relative">7</div>-->
<!--                                    <div-->
<!--                                        class="py-0.5 bg-theme-1 dark:bg-theme-1 text-white rounded relative"-->
<!--                                    >-->
<!--                                        8-->
<!--                                    </div>-->
<!--                                    <div class="py-0.5 rounded relative">9</div>-->
<!--                                    <div class="py-0.5 rounded relative">10</div>-->
<!--                                    <div class="py-0.5 rounded relative">11</div>-->
<!--                                    <div class="py-0.5 rounded relative">12</div>-->
<!--                                    <div class="py-0.5 rounded relative">13</div>-->
<!--                                    <div class="py-0.5 rounded relative">14</div>-->
<!--                                    <div class="py-0.5 rounded relative">15</div>-->
<!--                                    <div class="py-0.5 rounded relative">16</div>-->
<!--                                    <div class="py-0.5 rounded relative">17</div>-->
<!--                                    <div class="py-0.5 rounded relative">18</div>-->
<!--                                    <div class="py-0.5 rounded relative">19</div>-->
<!--                                    <div class="py-0.5 rounded relative">20</div>-->
<!--                                    <div class="py-0.5 rounded relative">21</div>-->
<!--                                    <div class="py-0.5 rounded relative">22</div>-->
<!--                                    <div-->
<!--                                        class="py-0.5 bg-theme-17 dark:bg-theme-11 rounded relative"-->
<!--                                    >-->
<!--                                        23-->
<!--                                    </div>-->
<!--                                    <div class="py-0.5 rounded relative">24</div>-->
<!--                                    <div class="py-0.5 rounded relative">25</div>-->
<!--                                    <div class="py-0.5 rounded relative">26</div>-->
<!--                                    <div-->
<!--                                        class="py-0.5 bg-theme-14 dark:bg-theme-12 rounded relative"-->
<!--                                    >-->
<!--                                        27-->
<!--                                    </div>-->
<!--                                    <div class="py-0.5 rounded relative">28</div>-->
<!--                                    <div class="py-0.5 rounded relative">29</div>-->
<!--                                    <div class="py-0.5 rounded relative">30</div>-->
<!--                                    <div class="py-0.5 rounded relative text-gray-600">1</div>-->
<!--                                    <div class="py-0.5 rounded relative text-gray-600">2</div>-->
<!--                                    <div class="py-0.5 rounded relative text-gray-600">3</div>-->
<!--                                    <div class="py-0.5 rounded relative text-gray-600">4</div>-->
<!--                                    <div class="py-0.5 rounded relative text-gray-600">5</div>-->
<!--                                    <div class="py-0.5 rounded relative text-gray-600">6</div>-->
<!--                                    <div class="py-0.5 rounded relative text-gray-600">7</div>-->
<!--                                    <div class="py-0.5 rounded relative text-gray-600">8</div>-->
<!--                                    <div class="py-0.5 rounded relative text-gray-600">9</div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="border-t border-gray-200 p-5">-->
<!--                                <div class="flex items-center">-->
<!--                                    <div class="w-2 h-2 bg-theme-11 rounded-full mr-3"></div>-->
<!--                                    <span class="truncate">Workshop - tworzenie lini</span>-->
<!--                                    <div-->
<!--                                        class="h-px flex-1 border border-r border-dashed border-gray-300 mx-3 xl:hidden"-->
<!--                                    ></div>-->
<!--                                    <span class="font-medium xl:ml-auto">23ci</span>-->
<!--                                </div>-->
<!--                                <div class="flex items-center mt-4">-->
<!--                                    <div-->
<!--                                        class="w-2 h-2 bg-theme-1 dark:bg-theme-10 rounded-full mr-3"-->
<!--                                    ></div>-->
<!--                                    <span class="truncate">Webinar Robotics</span>-->
<!--                                    <div-->
<!--                                        class="h-px flex-1 border border-r border-dashed border-gray-300 mx-3 xl:hidden"-->
<!--                                    ></div>-->
<!--                                    <span class="font-medium xl:ml-auto">10ty</span>-->
<!--                                </div>-->
<!--                                &lt;!&ndash;                                <div class="flex items-center mt-4">&ndash;&gt;-->
<!--                                &lt;!&ndash;                                    <div class="w-2 h-2 bg-theme-12 rounded-full mr-3"></div>&ndash;&gt;-->
<!--                                &lt;!&ndash;                                    <span class="truncate">Laravel Rest API</span>&ndash;&gt;-->
<!--                                &lt;!&ndash;                                    <div&ndash;&gt;-->
<!--                                &lt;!&ndash;                                        class="h-px flex-1 border border-r border-dashed border-gray-300 mx-3 xl:hidden"&ndash;&gt;-->
<!--                                &lt;!&ndash;                                    ></div>&ndash;&gt;-->
<!--                                &lt;!&ndash;                                    <span class="font-medium xl:ml-auto">31th</span>&ndash;&gt;-->
<!--                                &lt;!&ndash;                                </div>&ndash;&gt;-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
                <!-- END: Schedules -->
                <!-- BEGIN: Weekly Top Products -->
<!--                <div class="col-span-12 xl:col-span-6 mt-2">-->
<!--                    <div class="intro-y block sm:flex items-center h-10">-->
<!--                        <h2 class="text-lg font-medium truncate mr-5">-->
<!--                            Najwyżej oceniane rozwiązania-->
<!--                        </h2>-->
<!--                    </div>-->
<!--                    <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">-->
<!--                        <table class="table table-report sm:mt-2">-->
<!--                            <thead>-->
<!--                            <tr>-->
<!--                                <th class="whitespace-nowrap">NAZWA</th>-->
<!--                                <th class="text-center whitespace-nowrap">INTEGRATOR</th>-->
<!--                                &lt;!&ndash;                                <th class="text-center whitespace-nowrap">STATUS</th>&ndash;&gt;-->
<!--&lt;!&ndash;                                <th class="text-center whitespace-nowrap">AKCJE</th>&ndash;&gt;-->
<!--                            </tr>-->
<!--                            </thead>-->
<!--                            <tbody>-->
<!--                            <tr-->
<!--                                v-for="(solution, index) in solutions"-->
<!--                                :key="index"-->
<!--                                class="intro-x"-->
<!--                            >-->
<!--                                <td>-->
<!--                                    <a href="" class="font-medium whitespace-nowrap" @click.prevent="" v-if="solution.name == '' || solution.name == null">-->
<!--                                        {{solution.challenge.name }}-->
<!--                                    </a>-->
<!--                                    <a href="" class="font-medium whitespace-nowrap" @click.prevent="" v-if="solution.name != '' && solution.name != null">-->
<!--                                        {{solution.name }}-->
<!--                                    </a>-->
<!--                                    <div class="text-gray-600 text-xs whitespace-nowrap mt-0.5">-->
<!--                                        {{types[solution.challenge.type]}}-->
<!--                                    </div>-->
<!--                                </td>-->
<!--                                <td class="text-center">    {{solution.author.name }}</td>-->
<!--                                &lt;!&ndash;                                <td class="w-40">&ndash;&gt;-->
<!--                                &lt;!&ndash;                                    <div&ndash;&gt;-->
<!--                                &lt;!&ndash;                                        class="flex items-center justify-center"&ndash;&gt;-->
<!--                                &lt;!&ndash;                                        :class="{&ndash;&gt;-->
<!--                                &lt;!&ndash;                        'text-theme-9': faker.trueFalse[0],&ndash;&gt;-->
<!--                                &lt;!&ndash;                        'text-theme-6': !faker.trueFalse[0]&ndash;&gt;-->
<!--                                &lt;!&ndash;                      }"&ndash;&gt;-->
<!--                                &lt;!&ndash;                                    >&ndash;&gt;-->
<!--                                &lt;!&ndash;                                        <CheckSquareIcon class="w-4 h-4 mr-2" />&ndash;&gt;-->
<!--                                &lt;!&ndash;                                        {{ faker.trueFalse[0] ? "Active" : "Inactive" }}&ndash;&gt;-->
<!--                                &lt;!&ndash;                                    </div>&ndash;&gt;-->
<!--                                &lt;!&ndash;                                </td>&ndash;&gt;-->
<!--&lt;!&ndash;                                <td class="table-report__action w-56">&ndash;&gt;-->
<!--&lt;!&ndash;                                    <div class="flex justify-center items-center">&ndash;&gt;-->
<!--&lt;!&ndash;                                        <a class="flex items-center mr-3" href=" @click.prevent=""">&ndash;&gt;-->
<!--&lt;!&ndash;                                            <CheckSquareIcon class="w-4 h-4 mr-1"/>&ndash;&gt;-->
<!--&lt;!&ndash;                                            Podejrzyj&ndash;&gt;-->
<!--&lt;!&ndash;                                        </a>&ndash;&gt;-->
<!--&lt;!&ndash;                                        &lt;!&ndash;                                        <a class="flex items-center text-theme-6" href="">&ndash;&gt;&ndash;&gt;-->
<!--&lt;!&ndash;                                        &lt;!&ndash;                                            <Trash2Icon class="w-4 h-4 mr-1" /> Delete&ndash;&gt;&ndash;&gt;-->
<!--&lt;!&ndash;                                        &lt;!&ndash;                                        </a>&ndash;&gt;&ndash;&gt;-->
<!--&lt;!&ndash;                                    </div>&ndash;&gt;-->
<!--&lt;!&ndash;                                </td>&ndash;&gt;-->
<!--                            </tr>-->
<!--                            </tbody>-->
<!--                        </table>-->
<!--                    </div>-->
<!--&lt;!&ndash;                    <div&ndash;&gt;-->
<!--&lt;!&ndash;                        class="intro-y flex flex-wrap sm:flex-row sm:flex-nowrap items-center mt-3"&ndash;&gt;-->
<!--&lt;!&ndash;                    >&ndash;&gt;-->
<!--&lt;!&ndash;                        <ul class="pagination">&ndash;&gt;-->
<!--&lt;!&ndash;                            <li>&ndash;&gt;-->
<!--&lt;!&ndash;                                <a class="pagination__link" href="">&ndash;&gt;-->
<!--&lt;!&ndash;                                    <ChevronsLeftIcon class="w-4 h-4"/>&ndash;&gt;-->
<!--&lt;!&ndash;                                </a>&ndash;&gt;-->
<!--&lt;!&ndash;                            </li>&ndash;&gt;-->
<!--&lt;!&ndash;                            <li>&ndash;&gt;-->
<!--&lt;!&ndash;                                <a class="pagination__link" href="">&ndash;&gt;-->
<!--&lt;!&ndash;                                    <ChevronLeftIcon class="w-4 h-4"/>&ndash;&gt;-->
<!--&lt;!&ndash;                                </a>&ndash;&gt;-->
<!--&lt;!&ndash;                            </li>&ndash;&gt;-->
<!--&lt;!&ndash;                            <li>&ndash;&gt;-->
<!--&lt;!&ndash;                                <a class="pagination__link" href="">...</a>&ndash;&gt;-->
<!--&lt;!&ndash;                            </li>&ndash;&gt;-->
<!--&lt;!&ndash;                            <li>&ndash;&gt;-->
<!--&lt;!&ndash;                                <a class="pagination__link" href="">1</a>&ndash;&gt;-->
<!--&lt;!&ndash;                            </li>&ndash;&gt;-->
<!--&lt;!&ndash;                            <li>&ndash;&gt;-->
<!--&lt;!&ndash;                                <a class="pagination__link pagination__link&#45;&#45;active" href=""&ndash;&gt;-->
<!--&lt;!&ndash;                                >2</a&ndash;&gt;-->
<!--&lt;!&ndash;                                >&ndash;&gt;-->
<!--&lt;!&ndash;                            </li>&ndash;&gt;-->
<!--&lt;!&ndash;                            <li>&ndash;&gt;-->
<!--&lt;!&ndash;                                <a class="pagination__link" href="">3</a>&ndash;&gt;-->
<!--&lt;!&ndash;                            </li>&ndash;&gt;-->
<!--&lt;!&ndash;                            <li>&ndash;&gt;-->
<!--&lt;!&ndash;                                <a class="pagination__link" href="">...</a>&ndash;&gt;-->
<!--&lt;!&ndash;                            </li>&ndash;&gt;-->
<!--&lt;!&ndash;                            <li>&ndash;&gt;-->
<!--&lt;!&ndash;                                <a class="pagination__link" href="">&ndash;&gt;-->
<!--&lt;!&ndash;                                    <ChevronRightIcon class="w-4 h-4"/>&ndash;&gt;-->
<!--&lt;!&ndash;                                </a>&ndash;&gt;-->
<!--&lt;!&ndash;                            </li>&ndash;&gt;-->
<!--&lt;!&ndash;                            <li>&ndash;&gt;-->
<!--&lt;!&ndash;                                <a class="pagination__link" href="">&ndash;&gt;-->
<!--&lt;!&ndash;                                    <ChevronsRightIcon class="w-4 h-4"/>&ndash;&gt;-->
<!--&lt;!&ndash;                                </a>&ndash;&gt;-->
<!--&lt;!&ndash;                            </li>&ndash;&gt;-->
<!--&lt;!&ndash;                        </ul>&ndash;&gt;-->
<!--&lt;!&ndash;                        <select class="w-20 form-select box mt-3 sm:mt-0">&ndash;&gt;-->
<!--&lt;!&ndash;                            <option>10</option>&ndash;&gt;-->
<!--&lt;!&ndash;                            <option>25</option>&ndash;&gt;-->
<!--&lt;!&ndash;                            <option>35</option>&ndash;&gt;-->
<!--&lt;!&ndash;                            <option>50</option>&ndash;&gt;-->
<!--&lt;!&ndash;                        </select>&ndash;&gt;-->
<!--&lt;!&ndash;                    </div>&ndash;&gt;-->
<!--                </div>-->
                <!-- END: Weekly Top Products -->
            </div>
        </div>
        <div class="col-span-12 xxl:col-span-3">
            <div class="xxl:border-l border-theme-5 -mb-10 pb-10">
                <div class="xxl:pl-6 grid grid-cols-12 gap-6">
                    <!-- BEGIN: Important Notes -->
                    <div class="col-span-12 md:col-span-6 xl:col-span-12 mt-3 xxl:mt-8">
                        <div class="intro-x flex items-center h-10">
                            <h2 class="text-lg font-medium truncate mr-auto">
                                InSights
                            </h2>
                            <button
                                data-carousel="important-notes"
                                data-target="prev"
                                class="tiny-slider-navigator btn px-2 border-gray-400 text-gray-700 dark:text-gray-300 mr-2"
                                @click="prevImportantNotes"
                            >
                                <ChevronLeftIcon class="w-4 h-4"/>
                            </button>
                            <button
                                data-carousel="important-notes"
                                data-target="next"
                                class="tiny-slider-navigator btn px-2 border-gray-400 text-gray-700 dark:text-gray-300 mr-2"
                                @click="nextImportantNotes"
                            >
                                <ChevronRightIcon class="w-4 h-4"/>
                            </button>
                        </div>
                        <div class="mt-5 intro-x">
                            <div class="box zoom-in">
                                <TinySlider ref-key="importantNotesRef" v-if="posts.length != 0">
                                    <WordpressPost v-for="post in posts" :post="post"></WordpressPost>
                                </TinySlider>
                            </div>
                        </div>
                    </div>
                    <!-- END: Important Notes -->
                    <!-- BEGIN: Weekly Best Sellers -->

                    <div class="col-span-12 md:col-span-6 xl:col-span-4 xxl:col-span-12 mt-3">
                        <div class="intro-y flex items-center h-10">
                            <h2 class="text-lg font-medium truncate mr-5">
                                Nasi partnerzy
                            </h2>
                        </div>
                        <div class="mt-5">
                            <div class="intro-y">
                                <div class="box px-4 py-4 mb-3 flex items-center zoom-in">
                                    <img src="/s3/logos/fanuc_logo.jpeg"/>
                                </div>
                                <div class="box px-4 py-4 mb-3 flex items-center zoom-in">
                                    <img src="/s3/logos/yaskawa_logo.png"/>
                                </div>
                                <div class="box px-4 py-4 mb-3 flex items-center zoom-in">
                                    <img src="/s3/logos/tfm_robotics.png"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END: Weekly Best Sellers -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {defineComponent, ref, provide, onMounted} from "vue";
import GetDashboard from "../compositions/GetDashboard"
import WordpressPost from "../components/wordpress-post/WordpressPost";
import DirectusCall from "../compositions/DirectusCall"

export default {
    components: {
        WordpressPost,
    },
    setup() {
        const importantNotesRef = ref();
        const posts = ref([]);
        const solutions = ref([]);
        const logs = ref([]);

        provide("bind[importantNotesRef]", el => {
            importantNotesRef.value = el;
        });

        const prevImportantNotes = () => {
            const el = importantNotesRef.value;
            el.tns.goTo("prev");
        };
        const nextImportantNotes = () => {
            const el = importantNotesRef.value;
            el.tns.goTo("next");
        };

        const deleteSolutionsOnNull = () => {
            axios.post('/api/solution/filter', {})
                .then(response => {
                    if (response.data.success) {
                    } else {
                    }
                })
        }
        const GetDashBoardRepository = () => {

            GetDashboard((resp) => {

                // posts.value = resp.posts;
                solutions.value = resp.solutions;
                logs.value = resp.logs;
            });


        }
        onMounted(() => {
            DirectusCall('items/post?access_token=aaaa&fields=*.*.*&limit=10&sort[]=sort&filter[category_id][post_category_id]=31', (val) => {
                posts.value = val;
            });
            deleteSolutionsOnNull();
            GetDashBoardRepository();
        });

        return {
            prevImportantNotes,
            nextImportantNotes,
            posts,
            solutions,
            logs
        };
    },
    name: "Dashboard",
    data() {
        return {
            name: null,
        }
    },
    created() {
        if (window.Laravel.user) {
            this.name = window.Laravel.user.name
        }
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/";
        }
        next();
    }
}
</script>
