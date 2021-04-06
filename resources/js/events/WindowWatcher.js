import {onMounted, watch, ref, onUnmounted} from 'vue';
const WindowWatcher = () => {
    const scrollY = ref(0);
    onMounted(() => {
        window.addEventListener('scroll', e => {
            this.scrollY = window.scrollY
        })
    })

    return {
        scrollY
    }
}

export default WindowWatcher;
