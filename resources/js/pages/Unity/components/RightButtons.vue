<template>
    <div class="flex fixed h-full z-50 pt-14" style="top: 0; right: 0;">
        <div class="flex-1 pt-2 mr-10">
            <div v-for="(icon, index) in icons" :key="'rightIcon_' + index">
                <UnityButton :tooltip="icon.tooltip" :alttext="icon.alttext" :path="icon.src" :action="index" position="rightbuttonclick" />
            </div>
        </div>
    </div>
</template>

<script>
import UnityButton from "./UnityButton";
import {getCurrentInstance, ref} from "vue";

export default {
    name: "RightButtons",
    components: {UnityButton},
    props: {
        icons: Array,
        allowedEdit: Object
    },
    setup() {
        const app = getCurrentInstance();
        const emitter = app.appContext.config.globalProperties.emitter;
        emitter.on('rightbuttonclick', e =>  handleChange(e.val) );
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
                    emitter.emit('FinancialAnalysisDialog', { val: '' });
                    break;
            }
        }
    }
}
</script>

<style scoped>

</style>
