<template>
    <footer>
        <div class="flex justify-between items-center border-b-2 border-gray-100 py-6 pb-0 md:justify-start md:space-x-4">

            <img src="/s3/twopointo/images/blobs/blob_footer_1_2.svg" class="w-full" style="position: absolute; top: 115px; z-index: 0; margin-left: 0 !important;"/>
            <img src="/s3/twopointo/images/blobs/blob_footer_1.svg" class="w-full" style="z-index: 2; margin-left: 0 !important;"/>
            <div class="grid-cols-12 grid gap-6 " style="position: absolute; z-index: 3; width: 80%; margin-left: 10%;">
                <div class="col-span-2">
                    <h5 class="footer-header font-medium">Społeczność</h5>
                    <ul class="footer-list">
                        <li>Forum</li>
                        <li>Tutorials</li>
                        <li>News</li>
                        <li>Link do pobrania</li>
                        <li>Certyfikaty</li>
                        <li>Akademia</li>
                        <li>Konkursy</li>
                        <li>Nowe funkcje Studia 3D</li>
                        <li>Q&A</li>
                    </ul>
                </div>
                <div class="col-span-2">
                    <h5 class="footer-header font-medium">Produkty</h5>
                    <ul class="footer-list">
                        <li>Platforma robotów transakcje</li>
                        <li>Assessment digitalizacja</li>
                        <li>Assessment robotyzacja</li>
                        <li>Robotyzacja stanowiska</li>
                        <li>Analiza efektów robotyzacji</li>
                        <li>Mapa strumienia wartości</li>
                        <li>Bliźniak cyfrowy</li>
                        <li>Logistyka wewnętrzna</li>
                        <li>Magazyny</li>
                        <li>Analiza pracy magazynu</li>
                        <li>Showroom</li>
                        <li>Zarządzanie projektami</li>
                        <li>Umowy na dostawy stanowisk</li>
                    </ul>
                </div>
                <div class="col-span-2">
                    <h5 class="footer-header font-medium">Rozwiązania</h5>
                    <ul class="footer-list">
                        <li>About DBR77 Solution</li>
                        <li>Branże</li>
                        <li>Procesy</li>
                        <li>Sposoby zapłaty</li>
                    </ul>
                </div>
                <div class="col-span-2">
                    <h5 class="footer-header font-medium">Baza wiedzy</h5>
                    <ul class="footer-list">
                        <li>Blog</li>
                        <li>Podcast</li>
                        <li>Webinar</li>
                        <li>Raporty</li>
                        <li>Costumer story - HSV</li>
                        <li>Digitalizacja materiały</li>
                        <li>Platform journey</li>
                    </ul>
                </div>
                <div class="col-span-2">
                    <h5 class="footer-header font-medium">Wsparcie i usługi</h5>
                    <ul class="footer-list">
                        <li>Znajdź partnera developera</li>
                        <li>Zostań partnerem developerem</li>
                        <li>Dostawcy sprzętu</li>
                        <li>Top integrator</li>
                        <li>Academic alliance</li>
                        <li>Video Toutorials</li>
                        <li>Regulamin platformy</li>
                    </ul>
                </div>
                <div class="col-span-2">
                    <h5 class="footer-header font-medium">O firmie</h5>
                    <ul class="footer-list">
                        <li>About DBR77</li>
                        <li>Leadership</li>
                        <li>Kariera</li>
                        <li>Plan rozwoju DBR77</li>
                        <li>Partnerzy DBR77</li>
                        <li>Media and brand kit</li>
                        <li>Trust and security</li>
                        <li>Code of conduct</li>
                        <li>Report ethical concerns</li>
                        <li>Relacje inwestorskie</li>
                        <li>Kontakt</li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
</template>

<script>
import { Popover, PopoverButton, PopoverGroup, PopoverPanel } from '@headlessui/vue'
import {
    MenuIcon,
    XIcon,
} from '@heroicons/vue/outline'
import { ChevronDownIcon } from '@heroicons/vue/solid'
import {onMounted} from "vue";

export default {
    components: {
        Popover,
        PopoverButton,
        PopoverGroup,
        PopoverPanel,
        ChevronDownIcon,
        MenuIcon,
        XIcon,
    },
    setup() {
        onMounted(() => {
            cash("body").addClass("main-site");

        });
        return {

        }
    },
}
</script>
