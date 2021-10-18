<template>
    <vue-easy-lightbox
        :visible="lightboxVisible"
        :imgs="images"
        :index="lightBoxIndex"
        @hide="hideLightbox"
    ></vue-easy-lightbox>
    <div>
        <div class="intro-y grid grid-cols-12 gap-6 mt-5">
            <!--            <button class="btn btn-primary ml-2 shadow-md mr-2" @click="$router.push({name: 'studio-playground'})">{{ $t('lite.addSave') }}</button>-->

            <!-- BEGIN: Blog Layout -->
            <!--            <div class="intro-y col-span-12 box pl-2 py-5 text-theme-1 dark:text-theme-10 font-medium" v-if="saves == undefined || saves.length == 0">-->

            <!--            </div>-->
            <div class="col-span-12 box intro-y shadow-md">
                <div class="p-10">
                    <div class="w-full flex flex-row">
                        <h2 class="text-lg font-medium mr-auto">Zadanie 1: Optymalizacja istniejącego procesu na linii produkcyjnej</h2>
                        <template v-if="dataAr.includes(1)">
                            <button class="btn btn-primary ml-2" v-if="!pubAr.includes(1)" @click="goToRoboChallenge(1)">Studio 3D</button>
                            <button class="btn btn-primary ml-2" v-if="!pubAr.includes(1) && dataAr.includes(1)" @click="show = true; tempId = 1;">Resetuj</button>
                            <button class="btn btn-primary ml-2" v-if="!pubAr.includes(1) && dataAr.includes(1)" @click="showTwo = true; tempId = 1;">Do oceny</button>
                        </template>
                    </div>
                    <div class="grid grid-cols-12 gap-6 mt-1">
                        <div class="col-span-6 p-10">
                            <h5 class="text-md font-medium -mt-8 mb-4 -ml-10" style="color: #5e50ac !important; font-size: 16px;">Zdjęcia:</h5>
                            <TinySlider id="one" :options="{
                            mode: 'gallery',
                            controls: true,
                            nav: true,
                            speed: 500,
                          }">
                                <div class="h-64 px-2" @click="showImage(0)">
                                    <div class="h-full image-fit rounded-md overflow-hidden">
                                        <img :alt="'robochallenge zadanie 1'" :src="'/s3/screenshots/ss_6168497672c84.jpg'"/>
                                    </div>
                                </div>
                                <div class="h-64 px-2" @click="showImage(1)">
                                    <div class="h-full image-fit rounded-md overflow-hidden">
                                        <img :alt="'robochallenge zadanie 1'" :src="'/s3/screenshots/1634217468.png'"/>
                                    </div>
                                </div>
                                <div class="h-64 px-2" @click="showImage(2)">
                                    <div class="h-full image-fit rounded-md overflow-hidden">
                                        <img :alt="'robochallenge zadanie 1'" :src="'/s3/screenshots/1634217480.png'"/>
                                    </div>
                                </div>
                                <div class="h-64 px-2" @click="showImage(3)">
                                    <div class="h-full image-fit rounded-md overflow-hidden">
                                        <img :alt="'robochallenge zadanie 1'" :src="'/s3/screenshots/1634225200.png'"/>
                                    </div>
                                </div>
                                <div class="h-64 px-2" @click="showImage(4)">
                                    <div class="h-full image-fit rounded-md overflow-hidden">
                                        <img :alt="'robochallenge zadanie 1'" :src="'/s3/screenshots/1634225222.png'"/>
                                    </div>
                                </div>
                            </TinySlider>
                        </div>
                        <div class="col-span-6">
                            <h5 class="text-md font-medium mt-2 mb-2" style="color: #5e50ac !important; font-size: 16px;">Opis:</h5>
                            <div style="overflow-y: scroll; max-height: 50vh">
                                <p>
                                    Zaproponuj optymalne rozwiązanie na automatyzacje/robotyzację procesu na linii produkcyjnej. Uwzględnij zmiany w layout, niezbędne elementy wyposażenia stanowiska uwzględniając wymogi dyrektywy maszynowej, animację z oszacowanymi czasami cyklu. Przygotowując koncepcję zwróć uwagę na sens biznesowy proponowanego rozwiązania.
                                </p><br/>
                                <p><b>System zmianowy: 3 zmiany</b></p>
                                <p><b>Ilość pracowników: 2</b></p>
                                <br/>
                                <h5 class="text-md font-medium" style="color: #5e50ac !important; font-size: 16px;">Cel wyzwania technologicznego:</h5> automatyzacja procesu pakowania, etykietowania i paletyzacji wyrobów po 100 % kontroli optycznej.
                                <br/>
                                <br/>
                                <b>Opis linii produkcyjnej:</b>
                                <p>
                                    Linia produkcyjna składa się z 5 identycznych maszyn przeznaczonych do kontroli jakościowej detalu. Pierwszy Operator otwiera karton z produktem przeznaczonym do kontroli jakościowej i przesypuje jego zawartość do zasobnika maszyny. Pierwszy Operator puste kartony ręcznie układa na automatycznym stole obrotowym z pojemnością dla 8 kartonów.<br/> Wyroby po 100% kontroli wpadają do kartonu ustawionego na odpowiedniej pozycji stołu obrotowego. Po zapełnieniu kartonu odpowiednią ilość dobrych sztuk stół się obraca i pod wylotem znajduję się pusty karton. Stół obrotowy jest skonfigurowany z maszyną i obraca się automatycznie po wypełnieniu kartonu zdefiniowaną ilością dobrego produktu po 100% kontroli. Ilość zgodnego produktu jest monitorowana przez system czujników liczących w maszynie.<br/> Drugi operator Zamyka ręcznie karton z produktem gotowym przy pomocy taśmy i etykietuje go. Paletyzuje gotowe kartony na euro palecie według ustalonego schematu.
                                    <br/><br/>Na każdej maszynie w tym samym czasie może być kontrolowany inny detal. System transportowy i system paletyzacji, winien być dostosowany dla różnych części kontrolowanych i pakowanych w tym samym czasie.
                                    <br/><br/>Wszystkie wyroby podlegające 100% kontroli jakościowej powinny być składowane na różnych paletach wg schematu: 1 maszyna – 1 detal – 1 paleta
                                </p>
                                <br/><br/>
                                <h5 class="text-md font-medium" style="color: #5e50ac !important; font-size: 16px;">Opis produktu:</h5>
                                <ul style="list-style: circle; padding-left: 18px;">
                                    <li>(waga kartonu 15 kg stała dla m6 (10 000 sztuk) - do m12 – (400 sztuk) high runner m8 ( 1000 sztuk)</li>
                                    <li>M6 - 1000 ilość sztuk w kartonie; waga kartonu: 15 kg; Wymiary kartonu: 30/36/22 [cm] (szerokość/długość/wysokość)</li>
                                    <li>M12 – 400 ilość sztuk w kartonie; waga kartonu: 15 kg; Wymiary kartonu: 30/36/22 [cm] (szerokość/długość/wysokość)</li>
                                    <li>M8 – 1000 ilość sztuk w kartonie; waga kartonu: 15 kg; Wymiary kartonu: 30/36/22 [cm] (szerokość/długość/wysokość)</li>
                                </ul>
                                <br/><br/>

                                <h5 class="text-md font-medium" style="color: #5e50ac !important; font-size: 16px;"> Schemat paletyzacji:</h5>
                                1200 x 800 (Paleta EUR). Ilość kartonów na palecie : 48 (4 warstwy x 12 kartonów) / Wysokość 4 warstw kartonów x paletą : max. 700 mm
                                <br/><br/>
                                <h5 class="text-md font-medium" style="color: #5e50ac !important; font-size: 16px;">Czas cyklu:</h5>
                                <ul style="list-style: circle; padding-left: 18px;">
                                    <li>czas zasypu przez operatora – 48 kartonów przez 35 min</li>
                                    <li>czas kontroli optycznej przez maszynę – 3 szt. na sekundę ilość sztuk w kartonie Minimalny czas 133 [s] - co 133 sekundy zjedzie pełny karton Maksymalny czas 55 min. - co 55 min zjedzie pełny karton ze stołu obrotowego.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-12 box intro-y shadow-md">
                <div class="p-10">
                    <div class="w-full flex flex-row">
                        <h2 class="text-lg font-medium mr-auto">Zadanie 2: Odtworzenie linii produkcyjnej na podstawie procesu o zadanych parametrach wydajnościowych</h2>
                        <template v-if="dataAr.includes(2)">
                            <button class="btn btn-primary ml-2" v-if="!pubAr.includes(2)" @click="goToRoboChallenge(2)">Studio 2D</button>
                            <button class="btn btn-primary ml-2" v-if="!pubAr.includes(2) && dataAr.includes(2)" @click="show = true; tempId = 2;">Resetuj</button>
                            <button class="btn btn-primary ml-2" v-if="!pubAr.includes(2) && dataAr.includes(2)" @click="showTwo = true; tempId = 2;">Do oceny</button>
                        </template>
                    </div>
                    <div class="grid grid-cols-12 gap-6 mt-1">

                        <div class="col-span-6 p-10">
                            <h5 class="text-md font-medium  -mt-8 mb-4 -ml-10" style="color: #5e50ac !important; font-size: 16px;">Zdjęcia:</h5>
                            <TinySlider id="two" :options="{
                            mode: 'gallery',
                            controls: true,
                            nav: true,
                            speed: 500,
                          }">
                                <div class="h-64 px-2" @click="showImage(5)">
                                    <div class="h-full image-fit rounded-md overflow-hidden">
                                        <img :alt="'robochallenge zadanie 1'" :src="'/s3/screenshots/dbr_placeholder.jpeg'"/>
                                    </div>
                                </div>
                                <div class="h-64 px-2" @click="showImage(6)">
                                    <div class="h-full image-fit rounded-md overflow-hidden">
                                        <img :alt="'robochallenge zadanie 1'" :src="'/s3/screenshots/1634218280.png'"/>
                                    </div>
                                </div>
                            </TinySlider>
                        </div>
                        <div class="col-span-6">
                            <h5 class="text-md font-medium mt-2 mb-2" style="color: #5e50ac !important; font-size: 16px;">Opis:</h5>
                            <div style="overflow-y: scroll; max-height: 50vh">
                                <p>Na postawie opisu linii produkcyjnej zaprojektuj w studio 3D proces przedstawiony w opisie uwzględniając</p>
                                <ul style="list-style: decimal; padding-left: 18px;">
                                    <li>Layout (obszar)</li>
                                    <li>Elementy wyposażenia linii produkcyjnej uwzględniając wymogi dyrektywy maszynowej (wykaz elementów w załączniku)</li>
                                    <li>Animację uwzględniającą zadane czasy cykli.</li>
                                </ul>

                                <h5 class="text-md font-medium mt-5 mb-2" style="color: #5e50ac !important; font-size: 16px;">Dane dotyczące projektu:</h5>

                                <b>Linia produkcyjna:</b>

                                Dwie linie produkcyjne z automatycznym procesem paletyzacji produktu gotowego z załadunkiem pustej i wyjazdem pełnej palety poza obszar paletyzacji. Na linii produkcyjnej zachodzi proces:
                                <ul style="list-style: circle; padding-left: 18px;">
                                    <li>załadunek wyrobu gotowego do kartonów,</li>
                                    <li>zaklejenie kartonu,</li>
                                    <li>etykietowanie kartonu,</li>
                                    <li>paletyzacja według określonego wzoru z wykorzystaniem robota przemysłowego.</li>
                                </ul>
                                <br/>
                                <b>Opis procesu:</b>
                                <p>
                                    Linia produkcyjna składa się z dwóch identycznych maszyn ustawionych równolegle do siebie w odległości około 3 metrów. Z maszyny na wyjściu uzyskujemy produkt gotowy w zaklejonym kartonie z etykietą. Kartony są transportowane na stanowisko paletyzacji przy użyciu transporterów taśmowych. Końcowe transportery łukowe skierowany są do siebie. Pomiędzy nimi na cokole znajduje się robot przemysłowy.
                                    <br/> Na ramieniu robota zamontowany jest uniwersalny chwytak szczękowy dostosowany do produktu. Po obu stronach robota znajdują się europalety. W zależności od kolejności zjazdu produktu do punktu pobrania robot pobiera lewy lub prawy karton i układa według ustalonego schematu na palecie. Proces załadunku pustej palety na transporter palet i odbioru pełnej palety na wyjeździe obsługuje operator.
                                    <br/> Pomiędzy załadunkiem pustej palety a miejscem paletyzowania znajduje się bufor jednej palety. Analogicznie na wyjeździe znajdują się dwa miejsca buforowe dla lewej i prawej strony. Przejazd palet pustych i wyjazd pełnych z obszaru paletyzacji przez robota odbywa się automatycznie na transporterach podłogowych. Obszar paletyzacji oraz wjazdu i wyjazdu palet jest wygrodzony. Przy wjeździe i wyjeździe palety znajdują się kurtyny świetlne.

                                </p>
                                <br/><br/>
                                <b>Opis produktu:</b>

                                <p>Waga kartonu: 10 kg; Wymiary kartonu: 30/36/22 [cm] (szerokość/długość/wysokość)</p>
                                <p>Waga kartonu: 10 kg; Wymiary kartonu: 28/35/24 [cm] (szerokość/długość/wysokość)</p>
                                <br/>
                                <b>Layout:</b>
                                <ul style="list-style: circle; padding-left: 18px;">
                                    <li>Obszar produkcyjny: długość 8 m, szerokość 9 m</li>
                                    <li>Obszar automatycznej paletyzacji: długość 4m , szerokość 9 m</li>
                                    <li>Droga transportowa od strony rozładunku palet: długość 3m ,szerokość 9 m</li>
                                </ul>
                                <br/>
                                <b>Przebieg procesu:</b>
                                <ul style="list-style: decimal; padding-left: 18px;">
                                    <li>Załadowanie produktu do kartonów w dedykowanej maszynie klienta</li>
                                    <li>Transport z maszyny gotowego produktu na stanowisko paletyzacji za pomocą szeregu transporterów</li>
                                    <li>Jednoczesna paletyzacja za pomocą robota przemysłowego ( karton z transportera 1 odkładane na paletę 1, karton z transportera 2 odkładany na paletę 2)</li>
                                </ul>
                                <br/>
                                <p> Czas cyklu na każdej linii wynosi 16 [s] (co 16 sekund z maszyny zjeżdża wyrób gotowy)</p>
                                <br/>
                                <b>Schemat palety:</b>
                                <ul style="list-style: circle; padding-left: 18px;">
                                    <li>Ilość warstw: 6</li>
                                    <li>Waga palety: 505 [kg]</li>
                                </ul>
                                <br/>
                                <p>Elementy wyposażenia stanowiska w załączniku 1.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-12 box intro-y shadow-md">
                <div class="p-10">
                    <div class="w-full flex flex-row">
                        <h2 class="text-lg font-medium mr-auto">Zadanie 3: Znajdź 5 błędów w istniejącym procesie i uzasadnij je</h2>
                        <template>
                            <button class="btn btn-primary ml-2" v-if="!pubAr.includes(3)" @click="goToRoboChallenge(3)">Studio 3D</button>
                            <button class="btn btn-primary ml-2" v-if="!pubAr.includes(3) && dataAr.includes(3)" @click="show = true; tempId = 3;">Resetuj</button>
                            <button class="btn btn-primary ml-2" v-if="!pubAr.includes(3) && dataAr.includes(3)" @click="showTwo = true; tempId = 3;">Do oceny</button>
                        </template>
                    </div>
                    <div class="grid grid-cols-12 gap-6 mt-1">

                        <div class="col-span-6 p-10">
                            <h5 class="text-md font-medium -mt-8 mb-4 -ml-10" style="color: #5e50ac !important; font-size: 16px;">Zdjęcia:</h5>
                            <TinySlider id="three" :options="{
                            mode: 'gallery',
                            controls: true,
                            nav: true,
                            speed: 500,
                          }">
                                <div class="h-64 px-2" @click="showImage(7)">
                                    <div class="h-full image-fit rounded-md overflow-hidden">
                                        <img :alt="'robochallenge zadanie 3'" :src="'/s3/screenshots/ss_616888b4d787c.jpg'"/>
                                    </div>
                                </div>
                            </TinySlider>
                        </div>
                        <div class="col-span-6">
                            <h5 class="text-md font-medium mt-2 mb-2" style="color: #5e50ac !important; font-size: 16px;">Opis:</h5>
                            <div style="overflow-y: scroll; max-height: 50vh">
                                <p>Znajdź 5 błędów w istniejącym procesie i uzasadnij je</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--            <div v-for="(save, index) in saves" :key="index" class="intro-y col-span-12 md:col-span-6 xl:col-span-4 box">-->
            <!--                <div class="flex items-center border-b border-gray-200 dark:border-dark-5 px-5 py-4">-->
            <!--                    <div class="w-10 h-10 flex-none image-fit">-->
            <!--                        <img alt="DBR77" class="rounded-full" :src="'/' + save.screenshot_path"/>-->
            <!--                    </div>-->
            <!--                    <div class="ml-3 mr-auto" @click.prevent="$router.push( {path : '/challenges/card/' + save.id})">-->
            <!--                        <a href="" class="font-medium">{{ save.name }}</a>-->
            <!--                    </div>-->
            <!--                    <div class="dropdown ml-3">-->
            <!--                        <a href="javascript:" class="dropdown-toggle w-5 h-5 text-gray-600 dark:text-gray-300" aria-expanded="false">-->
            <!--                            <MoreVerticalIcon class="w-5 h-5"/>-->
            <!--                        </a>-->
            <!--                        <div class="dropdown-menu w-40">-->
            <!--                            <div class="dropdown-menu__content box dark:bg-dark-1 p-2">-->
            <!--                                <a href="" @click.prevent="$router.push({name: 'addChallenge', params: {challenge_id: save.id }});" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">-->
            <!--                                    <Edit2Icon class="w-4 h-4 mr-2"/>-->
            <!--                                    Edytuj-->
            <!--                                </a>-->
            <!--                                <a href="" @click.prevent="deleteSave(save.id)" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">-->
            <!--                                    <TrashIcon class="w-4 h-4 mr-2"/>-->
            <!--                                    Usuń-->
            <!--                                </a>-->
            <!--                            </div>-->
            <!--                        </div>-->
            <!--                    </div>-->
            <!--                </div>-->
            <!--                <div class="p-5">-->
            <!--                    <div class="h-40 xxl:h-56 image-fit" @click="$router.push( {path : '/challenges/card/' + save.id})">-->
            <!--                        <img-->
            <!--                            alt="DBR77"-->
            <!--                            class="rounded-md"-->
            <!--                            :src="'/' + save.screenshot_path"/>-->
            <!--                    </div>-->
            <!--                    <a href="" class="block font-medium text-base mt-5"></a>-->
            <!--                </div>-->
            <!--                <div class="flex items-center px-5 py-3 border-t border-gray-200 dark:border-dark-5">-->

            <!--                </div>-->
            <!--            </div>-->
            <!-- END: Blog Layout -->
        </div>
    </div>
    <Modal :show="show" id="res-modal">
        <!--        <h3 class="intro-y text-lg font-medium mt-5">{{ $t('teams.addMember') }}</h3>-->
        <div class="intro-y box p-5 mt-12 sm:mt-5">
            <div>
                Czy na pewno chcesz przywrócić zapis tego zadania do stanu pierwotnego?
            </div>
        </div>
        <div class="intro-y box p-5 mt-12 sm:mt-5">
            <div class="relative text-gray-700 dark:text-gray-300 mr-4">
                <button class="btn btn-primary shadow-md mr-2" @click="show = false;">Anuluj</button>
                <button class="btn btn-primary shadow-md mr-2" :disabled="isDisabled" @click="resetRoboChallenge">Tak przywróć</button>
            </div>
        </div>
    </Modal>
    <Modal :show="showTwo" id="grade-modal">
        <!--        <h3 class="intro-y text-lg font-medium mt-5">{{ $t('teams.addMember') }}</h3>-->
        <div class="intro-y box p-5 mt-12 sm:mt-5">
            <div>
                Czy na pewno skończyłeś pracować nad tym zadaniem?
            </div>
        </div>
        <div class="intro-y box p-5 mt-12 sm:mt-5">
            <div class="relative text-gray-700 dark:text-gray-300 mr-4">
                <button class="btn btn-primary shadow-md mr-2" @click="showTwo = false;">Anuluj</button>
                <button class="btn btn-primary shadow-md mr-2" :disabled="isDisabled" @click="gradeRoboChallenge">Tak skończyłem</button>
            </div>
        </div>
    </Modal>
</template>

<script>
import {defineComponent, ref, provide, onMounted, getCurrentInstance, watch, onUpdated} from "vue";
import {useToast} from "vue-toastification";
import VueEasyLightbox from 'vue-easy-lightbox'
import RequestHandler from '../../../compositions/RequestHandler'
import router from "../../../router";
import Modal from "../../../components/Modal"

export default {
    name: "PlaygroundSaves",
    components: {
        VueEasyLightbox, Modal
    },
    setup(props) {
        const show = ref(false);
        const showTwo = ref(false);
        const tempId = ref();
        const saves = ref([]);
        const user = ref({});
        const dataAr = ref([]);
        const pubAr = ref([]);
        const toast = useToast();
        const guard = ref(false);
        const lightboxVisible = ref(false);
        const getSaveRepositories = async (callback) => {
            // RequestHandler('playground/saves', 'get', {}, (response) => {
            //     saves.value = response.data.payload;
            // });
        }
        const images = [
            "/s3/screenshots/ss_6168497672c84.jpg",
            "/s3/screenshots/1634217468.png",
            "/s3/screenshots/1634217480.png",
            "/s3/screenshots/1634225200.png",
            "/s3/screenshots/1634225222.png",
            "/s3/screenshots/dbr_placeholder.jpeg",
            "/s3/screenshots/1634218280.png",
            "/s3/screenshots/ss_616888b4d787c.jpg"
        ];

        const goToRoboChallenge = (id) => {
            axios.post('/api/playground/robochallenge/go', {task_id: id})
                .then(response => {
                    console.log(response);
                    router.push({path: '/playground/' + response.data})
                })
        }

        onMounted(function () {
            getSaveRepositories();
            if (window.Laravel.user) {
                user.value = window.Laravel.user;
            }
        });

        const getData = async () => {
            axios.post('/api/playground/save/data/get')
                .then(response => {
                    dataAr.value = response.data.exist;
                    pubAr.value = response.data.pub;
                })
        }

        const deleteSave = async (id) => {
            axios.post('/api/playground/saves/delete', {id: id})
                .then(response => {

                    if (response.data.success) {
                        toast.success('Wyzwanie usunięte');
                        window.location.reload();
                    } else {

                    }
                })
        }

        const lightBoxIndex = ref(0);

        onMounted(() => {
            getData();
        });

        const showImage = (index) => {
            lightboxVisible.value = true;
            lightBoxIndex.value = index;
        }

        const hideLightbox = () => {
            lightboxVisible.value = false;
        }


        const resetRoboChallenge = () => {
            axios.post('/api/playground/saves/reset', {id: tempId.value})
                .then(response => {
                    toast.success('Zadanie zeresetowane');
                    show.value = false;
                }).catch(e => {
                toast.success('Wystąpił błąd.');
                show.value = false;
            })
        }

        const gradeRoboChallenge = async () => {
            axios.post('/api/playground/saves/grade', {id: tempId.value})
                .then(response => {
                    toast.success('Oczekuj na zakończenie konkursu.');
                    showTwo.value = false;
                }).catch(e => {
                toast.success('Wystąpił błąd.');
                showTwo.value = false;
            })
        }

        return {
            resetRoboChallenge,
            gradeRoboChallenge,
            guard,
            saves,
            user,
            getSaveRepositories,
            deleteSave,
            lightboxVisible,
            showImage,
            hideLightbox,
            lightBoxIndex,
            images,
            goToRoboChallenge,
            dataAr,
            show,
            showTwo,
            tempId,
            pubAr
        }
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/";
        }
        next((vm) => {
            // vm.getSaveRepositories();
        });
    }
}
</script>
