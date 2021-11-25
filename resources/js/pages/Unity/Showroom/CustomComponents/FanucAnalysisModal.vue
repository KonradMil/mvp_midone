<template>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <!-- BEGIN: Profile Menu -->
        <div class="col-span-12 lg:col-span-4 xxl:col-span-3 flex lg:block flex-col-reverse">
            <div class="intro-y box mt-5 lg:mt-0">
                <div class="p-5 border-t border-gray-200 dark:border-dark-5">
                    <a class="flex items-center"
                       @click.prevent=""
                       :class="''">
                        <ActivityIcon class="w-4 h-4 mr-2"/>
                        Korzyści robotyzacji
                    </a>
                    <a class="flex items-center mt-5" href=""
                       @click.prevent=" "
                       :class="'mt-5'">
                        <BoxIcon class="w-4 h-4 mr-2"/>
                        Dane MFR 2018                   </a>
                    <a class="flex items-center mt-5" href=""
                       @click.prevent="activeTab = 'rozwiazania'"
                       :class="'mt-5'">
                        <LockIcon class="w-4 h-4 mr-2"/>
                        Globalna sprzedaż robotów
                    </a>
                    <a
                        class="flex items-center mt-5" href=""
                        @click.prevent=""
                        :class="'mt-5'">
                        <SettingsIcon class="w-4 h-4 mr-2"/>
                        Światowa sprzedaż według regionów
                    </a>
                    <a
                        class="flex items-center mt-5" href=""
                        @click.prevent=" "
                        :class="'mt-5'">
                        <SettingsIcon class="w-4 h-4 mr-2"/>
                        Najbardziej zrobotyzowane kraje
                    </a>
                    <a class="flex items-center mt-5" href=""
                       @click.prevent=""
                       :class="'mt-5'">
                        <SettingsIcon class="w-4 h-4 mr-2"/>
                        Gęstość robotów w Europie
                    </a>
                    <a
                        class="flex items-center mt-5" href=""
                        @click.prevent=" "
                        :class=" 'mt-5'">
                        <SettingsIcon class="w-4 h-4 mr-2"/>
                        Analiza operacyjna rozwiązania
                    </a>
                    <a
                        class="flex items-center mt-5" href=""
                        @click.prevent=" "
                        :class=" 'mt-5'">
                        <SettingsIcon class="w-4 h-4 mr-2"/>
                        Robotyzacja w Polsce
                    </a>
                    <a
                        class="flex items-center mt-5" href=""
                        @click.prevent=" "
                        :class=" 'mt-5'">
                        <SettingsIcon class="w-4 h-4 mr-2"/>
                        Roboty w Polsce według sektorów
                    </a>
                    <a
                        class="flex items-center mt-5" href=""
                        @click.prevent=" "
                        :class=" 'mt-5'">
                        <SettingsIcon class="w-4 h-4 mr-2"/>
                        Powody braku robotów w Polsce
                    </a>
                    <a
                        class="flex items-center mt-5" href=""
                        @click.prevent=" "
                        :class=" 'mt-5'">
                        <SettingsIcon class="w-4 h-4 mr-2"/>
                        Okres zwrotu z inwestycji w Polsce
                    </a>
                    <a
                        class="flex items-center mt-5" href=""
                        @click.prevent=" "
                        :class=" 'mt-5'">
                        <SettingsIcon class="w-4 h-4 mr-2"/>
                        Plany firm niezautomatyzowanych
                    </a>
                    <a
                        class="flex items-center mt-5" href=""
                        @click.prevent=" "
                        :class=" 'mt-5'">
                        <SettingsIcon class="w-4 h-4 mr-2"/>
                        Powody robotyzacji w Polsce
                    </a>
                    <a
                        class="flex items-center mt-5" href=""
                        @click.prevent=" "
                        :class=" 'mt-5'">
                        <SettingsIcon class="w-4 h-4 mr-2"/>
                        Czas wdrożenia robota w Polsce
                    </a>
                    <a
                        class="flex items-center mt-5" href=""
                        @click.prevent=" "
                        :class=" 'mt-5'">
                        <SettingsIcon class="w-4 h-4 mr-2"/>
                        Efekty robotyzacji w Polsce
                    </a>
                    <a
                        class="flex items-center mt-5" href=""
                        @click.prevent=" "
                        :class=" 'mt-5'">
                        <SettingsIcon class="w-4 h-4 mr-2"/>
                        Co może przyspieszyć robotyzację?
                    </a>
                    <a
                        class="flex items-center mt-5" href=""
                        @click.prevent=""
                        :class="'mt-5'">
                        <SettingsIcon class="w-4 h-4 mr-2"/>
                        Plany firm zautomatyzowanych
                    </a>
                </div>
            </div>
        </div>
        <!-- END: Profile Menu -->

    </div>
</template>

<script>
export default {
    name: "FanucAnalysisModal"
}
</script>

<style scoped>

</style>
