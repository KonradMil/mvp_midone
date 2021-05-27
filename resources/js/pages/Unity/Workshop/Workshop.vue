<template>
    <div>
        <div class="intro-y flex items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">Marketplace obiektów</h2>
        </div>
        <div class="grid grid-cols-12 gap-6 mt-5">
            <!-- BEGIN: Profile Menu -->
            <div class="col-span-12 lg:col-span-4 xxl:col-span-3 flex lg:block flex-col-reverse">
                <div class="intro-y box mt-5 lg:mt-0">
                    <div class="p-5 border-t border-gray-200 dark:border-dark-5">
                        <a
                            class="flex items-center"
                            href=""
                            @click.prevent="activeTab = 'obiekty'"
                            :class="(activeTab == 'obiekty')? ' text-theme-1 dark:text-theme-10 font-medium' : ''">
                            <ActivityIcon class="w-4 h-4 mr-2"/>
                            Twoje obiekty
                        </a>
                        <a class="flex items-center mt-5" href=""
                           @click.prevent="activeTab = 'marketplace'"
                           :class="(activeTab == 'marketplace')? ' text-theme-1 dark:text-theme-10 font-medium' : 'mt-5'">
                            <BoxIcon class="w-4 h-4 mr-2"/>
                            Marketplace
                        </a>
                        <a class="flex items-center mt-5" href=""
                           @click.prevent="activeTab = 'workshop'"
                           :class="(activeTab == 'workshop')? ' text-theme-1 dark:text-theme-10 font-medium' : 'mt-5'">
                            <LockIcon class="w-4 h-4 mr-2"/>
                            Workshop
                        </a>
                        <a class="flex items-center mt-5" href=""
                           @click.prevent="activeTab = 'oferty'"
                           :class="(activeTab == 'oferty')? ' text-theme-1 dark:text-theme-10 font-medium' : 'mt-5'">
                            <SettingsIcon class="w-4 h-4 mr-2"/>
                            Oferty
                        </a>
                        <a class="flex items-center mt-5" href=""
                           @click.prevent="activeTab = 'pytania'"
                           :class="(activeTab == 'pytania')? ' text-theme-1 dark:text-theme-10 font-medium' : 'mt-5'">
                            <SettingsIcon class="w-4 h-4 mr-2"/>
                            Pytania
                        </a>
                    </div>
                    <div class="p-5 border-t border-gray-200 dark:border-dark-5">
                        <a class="flex items-center" href=""
                           @click.prevent="activeTab = 'zespoly'"
                           :class="(activeTab == 'zespoly')? ' text-theme-1 dark:text-theme-10 font-medium' : ''">
                            <ActivityIcon class="w-4 h-4 mr-2"/>
                            Zespoły
                        </a>
                    </div>
                    <div class="p-5 border-t border-gray-200 dark:border-dark-5 flex" v-if="challenge.author_id == user.id">
                        <button type="button" class="btn btn-primary py-1 px-2" @click="$router.push({name: 'addChallenge', params: {challenge_id: challenge.id }});">
                            Edytuj
                        </button>
                        <button type="button" class="btn btn-primary py-1 px-2 ml-2" @click="$router.push({name: 'challengeStudio', params: {id: challenge.id, type: 'challenge', load: challenge}})">
                            Studio 3D
                        </button>
                        <button
                            v-if="challenge.status == 0"
                            type="button"
                            class="btn btn-outline-secondary py-1 px-2 ml-auto"
                            @click="publish(challenge.id)">
                            Opublikuj
                        </button>
                        <button
                            v-if="challenge.status == 1 && challenge.solutions.length == 0"
                            type="button"
                            class="btn btn-outline-secondary py-1 px-2 ml-auto"
                            @click="unpublish(challenge.id)">
                            Odpublikuj
                        </button>
                    </div>
                    <div class="p-5 border-t border-gray-200 dark:border-dark-5 flex" v-if="challenge.author_id != user.id && user.type == 'integrator'">
                        <button
                            v-if="challenge.stage == 1"
                            type="button"
                            class="btn btn-outline-secondary py-1 px-2 ml-auto"
                            @click.prevent="addSolution">
                            Dodaj rozwiązanie
                        </button>
                        <button
                            v-if="challenge.stage == 2"
                            type="button"
                            class="btn btn-outline-secondary py-1 px-2 ml-auto">
                            Złóż ofertę
                        </button>
                    </div>
                </div>
                <WhatsNext :user="user" :challenge="challenge"></WhatsNext>
            </div>
            <!-- END: Profile Menu -->
            <BasicInformationPanel :challenge="challenge" v-if="activeTab == 'podstawowe'"></BasicInformationPanel>
            <TechnicalInformationPanel :challenge="challenge" v-if="activeTab == 'techniczne'"></TechnicalInformationPanel>
            <QuestionsPanel v-if="activeTab == 'pytania'" :id="challenge.id"></QuestionsPanel>
            <SolutionsPanel v-if="activeTab == 'rozwiazania'" :challenge="challenge"></SolutionsPanel>
            <TeamsPanel v-if="activeTab == 'zespoly'" :teams="challenge.teams"> </TeamsPanel>
        </div>
    </div>
</template>

<script>
export default {
name: "Workshop"
}
</script>

<style scoped>

</style>
