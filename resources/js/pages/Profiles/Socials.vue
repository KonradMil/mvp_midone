<template>
    <div class="intro-y box lg:mt-5">
        <div class="preview">
            <div class="flex flex-wrap">
                <button class="btn btn-facebook w-32 mr-2 mb-2"> <i data-feather="facebook" class="w-4 h-4 mr-2"></i> Facebook </button>
                <button class="btn btn-twitter w-32 mr-2 mb-2"> <i data-feather="twitter" class="w-4 h-4 mr-2"></i> Twitter </button>
                <button class="btn btn-instagram w-32 mr-2 mb-2"> <i data-feather="instagram" class="w-4 h-4 mr-2"></i> Instagram </button>
                <button class="btn btn-linkedin w-32 mr-2 mb-2"> <i data-feather="linkedin" class="w-4 h-4 mr-2"></i> Linkedin </button>
            </div>
        </div>
        <div class="source-code hidden">
            <button data-target="#copy-social-media-button" class="copy-code btn py-1 px-2 btn-outline-secondary"> <i data-feather="file" class="w-4 h-4 mr-2"></i> Copy example code </button>
            <div class="overflow-y-auto mt-3 rounded-md">
                <pre id="copy-social-media-button" class="source-preview"> <code class="text-xs p-0 rounded-md html pl-5 pt-8 pb-4 -mb-10 -mt-10"> HTMLOpenTagbutton class=&quot;btn btn-facebook w-32 mr-2 mb-2&quot;HTMLCloseTag HTMLOpenTagi data-feather=&quot;facebook&quot; class=&quot;w-4 h-4 mr-2&quot;HTMLCloseTagHTMLOpenTag/iHTMLCloseTag Facebook HTMLOpenTag/buttonHTMLCloseTag HTMLOpenTagbutton class=&quot;btn btn-twitter w-32 mr-2 mb-2&quot;HTMLCloseTag HTMLOpenTagi data-feather=&quot;twitter&quot; class=&quot;w-4 h-4 mr-2&quot;HTMLCloseTagHTMLOpenTag/iHTMLCloseTag Twitter HTMLOpenTag/buttonHTMLCloseTag HTMLOpenTagbutton class=&quot;btn btn-instagram w-32 mr-2 mb-2&quot;HTMLCloseTag HTMLOpenTagi data-feather=&quot;instagram&quot; class=&quot;w-4 h-4 mr-2&quot;HTMLCloseTagHTMLOpenTag/iHTMLCloseTag Instagram HTMLOpenTag/buttonHTMLCloseTag HTMLOpenTagbutton class=&quot;btn btn-linkedin w-32 mr-2 mb-2&quot;HTMLCloseTag HTMLOpenTagi data-feather=&quot;linkedin&quot; class=&quot;w-4 h-4 mr-2&quot;HTMLCloseTagHTMLOpenTag/iHTMLCloseTag Linkedin HTMLOpenTag/buttonHTMLCloseTag </code> </pre>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Socials"
}
</script>

<style scoped>

</style>
