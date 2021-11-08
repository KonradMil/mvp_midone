<template>

    <div class="min-h-full flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <Box classes="mt-4 p-5">
                <div content="pt-8">
                    <img class="mx-auto h-20 w-auto" src="/s3/logos/fanuc_logo.jpeg" alt="FANUC" />
<!--                    <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">-->
<!--                        Fanuc showroom-->
<!--                    </h2>-->
                </div>
                <form class="mt-8 space-y-6" action="#" method="POST">
                    <input type="hidden" name="remember" value="true" />
                    <div class="rounded-md shadow-sm -space-y-px">
                        <div>
                            <label for="email-address" class="sr-only">E-mail</label>
                            <input id="email-address" name="email" type="email" autocomplete="email" required="" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="e-mail" />
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Wejdź
                        </button>
                    </div>
                </form>
            </Box>
        </div>
    </div>
</template>

<script>
import {onMounted} from "vue";
import Box from "../../../components-terraform/Box";

export default {
    name: "ShowroomLogin",
    components: {Box},
    props: {
        organization: {
            type: String
        }
    },
    setup(props, {emit}) {


        onMounted(() => {

        });
    }
}
</script>

<style scoped>

</style>
