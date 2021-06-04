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
                        <a class="flex items-center" href="" @click.prevent="activeTab = 'obiekty'" :class="(activeTab == 'obiekty')? ' text-theme-1 dark:text-theme-10 font-medium' : ''">
                            <ActivityIcon class="w-4 h-4 mr-2"/>
                            Twoje obiekty
                        </a>
                        <a class="flex items-center mt-5" href="" @click.prevent="activeTab = 'marketplace'" :class="(activeTab == 'marketplace')? ' text-theme-1 dark:text-theme-10 font-medium' : 'mt-5'">
                            <BoxIcon class="w-4 h-4 mr-2"/>
                            Marketplace
                        </a>
                        <a class="flex items-center mt-5" href="" @click.prevent="activeTab = 'workshop'" :class="(activeTab == 'workshop')? ' text-theme-1 dark:text-theme-10 font-medium' : 'mt-5'">
                            <LockIcon class="w-4 h-4 mr-2"/>
                            Workshop
                        </a>
                    </div>
                </div>
            </div>
            <!-- END: Profile Menu -->
            <WorkshopPanel v-if="activeTab == 'workshop'"></WorkshopPanel>
            <Marketplace v-if="activeTab == 'marketplace'"></Marketplace>
            <OwnObjects v-if="activeTab == 'obiekty'"></OwnObjects>
        </div>
    </div>
</template>

<script>
import WorkshopPanel from "./panels/WorkshopPanel";
import Marketplace from "./panels/Marketplace";
import OwnObjects from "./panels/OwnObjects";
import UnityBridgeWorkshop from "./bridge_workshop";

import {onBeforeMount, ref} from "vue";
import UnityBridge from "../bridge";
export default {
name: "Workshop",
    components: {OwnObjects, Marketplace, WorkshopPanel},
    setup() {
        const activeTab = ref('obiekty');
        const bridge = ref();

        onBeforeMount(() => {
            //ADDS LISTENERS
            bridge.value = UnityBridgeWorkshop();

        });

        return {
            activeTab
        }
    }
}
</script>

<style scoped>

</style>
