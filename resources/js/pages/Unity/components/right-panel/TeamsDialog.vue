<template>
    <div class="mt-3">
        <label for="modal-form-1" class="form-label">Zespoły</label>
        <TailSelect
            id="post-form-5"
            v-model="teams"
            :options="{
             locale: 'pl',
             placeholder: 'Wybierz zespoły...',
             limit: 'Nie można wybrać więcej',
             placeholderMulti: 'Wybierz do :limit zespołów...',
             search: false,
             hideSelected: true,
             hideDisabled: true,
             multiLimit: 3,
             multiShowCount: false,
             multiContainer: true,
             classNames: 'w-full'
              }"
            multiple
        >
            <option selected disabled>{{ $t('challengesNew.selectTags') }}</option>
            <option v-for="(team,index) in teams.list" :value="team.id">{{ team.name }}</option>
        </TailSelect>
<!--        <input-->
<!--            id="modal-form-1"-->
<!--            type="text"-->
<!--            class="form-control"-->
<!--            placeholder=""-->
<!--            v-model="c.title"-->
<!--        />-->
    </div>
    <div class="mt-3">
        <label for="modal-form-2" class="form-label">Wiadomości</label>
        <textarea
            id="modal-form-2"
            class="form-control"
            v-model="c.message"
        />
    </div>
</template>

<script>
import {onMounted, ref, watch} from "vue";
import GetTeams from '../../../../compositions/GetTeams'


export default {
    name: "TeamsDialog",
    props: {
      comment: Object,
      teams_challenge: Array
    },
    setup(props, context) {
        const teams = ref([]);
        const c = ref({message: '', addedTeams: [], teams: []});
        const GetTeamRepositories = async () => {
            teams.value = GetTeams();
        }


        watch(c, (ca, prevLabel) => {
            console.log('CHANGE');
            context.emit("update:comment", ca);
        }, {deep: true})
        onMounted(() => {
            GetTeamRepositories('');
        });

        return {
            c,
            teams
        }
    }
}
</script>

<style scoped>

</style>
