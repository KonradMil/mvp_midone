<template>
    <div>
        <div class="intro-y flex items-center mt-8">

        </div>
        <div class="grid grid-cols-12 gap-6">
            <!-- BEGIN: FAQ Menu -->
            <div class="intro-y col-span-12 lg:col-span-2 xl:col-span-2">
                <div class="flex-row w-full items-center">
                    <router-link
                        :to="{ name: 'dashboard' }"
                        tag="a"
                        class="intro-x flex items-center  pt-4 px-12"
                    >
                        <img
                            alt="DBR77 Platforma Robotów "
                            class="w-full"
                            src="/s3/twopointo/logo_dbr_white.png"
                        />
                    </router-link>
                </div>
            </div>
            <!-- END: FAQ Menu -->
            <!-- BEGIN: FAQ Content -->
            <PrivacyPolicyContent v-if="props.page === 'privacy-policy'"></PrivacyPolicyContent>
            <TermsOfServiceContent v-if="props.page === 'terms-of-service'"></TermsOfServiceContent>
            <PriceListContent v-if="props.page === 'price-list'"></PriceListContent>
            <!-- END: FAQ Content -->
        </div>
    </div>
</template>

<script>
import PrivacyPolicyMenu from "./components/PrivacyPolicyMenu";
import PrivacyPolicyContent from "./components/PrivacyPolicyContent";
import PriceListMenu from "./components/PriceListMenu";
import TermsOfServiceMenu from "./components/TermsOfServiceMenu";
import TermsOfServiceContent from "./components/TermsOfServiceContent";
import PriceListContent from "./components/PriceListContent";
import cash from "cash-dom";
import {onMounted} from "vue";

export default  {
    name: "TermsMain",
    components: {
        PriceListContent,
        TermsOfServiceContent,
        TermsOfServiceMenu,
        PriceListMenu,
        PrivacyPolicyContent,
        PrivacyPolicyMenu
    },
    props: {
        page: String
    },
    setup(props) {
        onMounted(() => {
            cash("body")
                .removeClass("error-page")
        });
        return {
            props
        }
    }
}
</script>

<style scoped>

</style>
