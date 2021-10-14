<template>
    <div class="mt-3">
        <label for="modal-form-1" class="form-label">Zespoły</label>
        <TailSelect
            v-if="props.type==='challenge'"
            id="post-form-5"
            v-model="team_unity"
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

        </TailSelect>
        <TailSelect
            v-if="props.type==='solution'"
            id="post-form-5"
            v-model="teamsSolution.teamsAllowed"
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
import {onMounted, ref, watch, computed} from "vue";
import GetTeams from '../../../../compositions/GetTeams'



export default {
    name: "TeamsDialog",
    props: {
       comment: Object,
       teams_unity: Array,
        type: String,
        solution: Object
    },
    emits: ["update:teamsSolution"],
    setup(props, context) {
        const teams = ref([]);
        const c = ref({message: '', addedTeams: [], teams: []});
        const GetTeamRepositories = async () => {
            teams.value = GetTeams();
        }

        const teamsSolution = ref({});

        watch(teamsSolution, (lab, prevLabel) => {

            context.emit("update:teamsSolution", lab);
        }, {deep: true});

        const team_unity = computed (() => {
            if(props.type === 'challenge') {
                let ts = [];
                props.teams_unity.forEach((val) => {
                    ts.push(val.id);
                })
                return ts;
            }
            else{

            }
            });




        watch(c, (ca, prevLabel) => {

            context.emit("update:comment", ca);
        }, {deep: true})
        onMounted(() => {
            GetTeamRepositories('');
        });

        return {
            c,
            teams,
            team_unity,
            props,
            teamsAllowed,
            teamsSolution
        }
    }
}
</script>

<style scoped>

</style>
