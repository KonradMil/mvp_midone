<template>
    <div class="p-5">
        <img class="w-full mb-2" :src="p.thumbnail">
        <div class="text-base font-medium truncate">
            {{p.title}}
        </div>
        <div class="text-gray-500 mt-1">15 godzin temu</div>
        <div class="text-gray-600 text-justify mt-1">
            <span v-html="p.excerpt"></span>
        </div>
        <div class="font-medium flex mt-5">
            <button type="button" class="btn btn-secondary py-1 px-2" @click.prevent="w.open('https://dbr77.com/' + p.slug, '_blank').focus();">
                Zobacz
            </button>
            <!--                                            <button-->
            <!--                                                type="button"-->
            <!--                                                class="btn btn-outline-secondary py-1 px-2 ml-auto ml-auto"-->
            <!--                                            >-->
            <!--                                                Dismiss-->
            <!--                                            </button>-->
        </div>
    </div>
</template>

<script>
import {onMounted, ref} from "vue";

export default {
    name: "WordpressPost",
    props: {
        post: Object
    },
    setup(props) {
        const p = ref({});
        const w = ref({});
        onMounted(() =>{
            p.value = props.post;
            w.value = window;
        })

        return {
            p,
            w
        }

    }
}
</script>

<style scoped>

</style>
