<template>
    <div class="flex fixed h-full z-50 pt-14" style="top: 0; right: 0; pointer-events: none;">
        <div class="flex-1 pt-2 mr-10">
<!--            <div v-for="(icon, index) in icons" :key="'rightIcon_' + index" v-if="index != 'operationalanalysis' && type == 'solution'" class="unity-button">-->
<!--                <UnityButton :tooltip="icon.tooltip" :alttext="icon.alttext" :path="icon.src" :action="index" position="rightbuttonclick"  />-->
<!--            </div>-->
            <div class="unity-button">
                <UnityButton :tooltip="'Description'" :alttext="'description'" :path="'s3/builder_icons/notatka_simple.png'" :action="'description'" position="rightbuttonclick"  />
            </div>
            <div class="unity-button">
                <UnityButton :tooltip="'Settings'" :alttext="'settings'" :path="'s3/builder_icons/dane_simple.png'" :action="'settings'" position="rightbuttonclick"  />
            </div>
            <div class="unity-button" v-if="allowedEdit && type == 'solution'">
                <UnityButton :tooltip="'financial'" :alttext="'financial'" :path="'s3/builder_icons/assum_simple.png'" :action="'financial'" position="rightbuttonclick"  />
            </div>
            <div class="unity-button" v-if="allowedEdit && type == 'solution'">
                <UnityButton :tooltip="'operational'" :alttext="'operational'" :path="'s3/builder_icons/analiza_finansowa.png'" :action="'operational'" position="rightbuttonclick"  />
            </div>
            <div class="unity-button" v-if="allowedEdit && type == 'solution'">
                <UnityButton :tooltip="'Analiza operacyjna'" :alttext="'operationalanalysis'" :path="'s3/builder_icons/analiza_operacyjna_simple.png'" :action="'operationalanalysis'" position="rightbuttonclick"  />
            </div>
        </div>
    </div>
</template>

<script>
import UnityButton from "./UnityButton";
import {getCurrentInstance, onMounted, ref} from "vue";

export default {
    name: "RightButtons",
    components: {UnityButton},
    props: {
        icons: Array,
        allowedEdit: Object,
        type: String
    },
    setup(props) {
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        const type = ref('challenge');
        emitter.on('rightbuttonclick', e =>  handleChange(e.val) );

        onMounted(() => {
            type.value = props.type;
        });

        const handleChange = (val) => {
            console.log(val);
            switch(val) {
                case 'teams':
                    emitter.emit('TeamsDialog', { val: '' });
                    break;
                case 'multiplayer':
                    emitter.emit('MultiplayerDialog', { val: '' });
                    break;
                case 'description':
                    emitter.emit('DescriptionDialog', { val: '' });
                    break;
                case 'settings':
                    emitter.emit('SettingsDialog', { val: '' });
                    break;
                case 'operational':
                    emitter.emit('OperationalDialog', { val: '' });
                    break;
                case 'operationalanalysis':
                    emitter.emit('OperationalAnalysisDialog', { val: '' });
                    break;
                case 'financial':
                    emitter.emit('FinancialDialog', { val: '' });
                    break;
            }
        }
    }
}
</script>

<style scoped>

</style>
