<template>
  <!-- BEGIN: Dark Mode Switcher-->
  <div
    class="dark-mode-switcher cursor-pointer w-24 h-12 flex items-center justify-center z-50 mr-1 bg-transparent"
    @click="switchMode"
  >
    <div class="mr-2 text-gray-700 dark:text-gray-300 bg-transparent">
        <SunIcon class="w-6 h-6" v-if="!darkMode"></SunIcon>
        <MoonIcon class="w-6 h-6" v-if="darkMode"></MoonIcon>
    </div>
    <div
      :class="{ 'dark-mode-switcher__toggle--active': darkMode }"
      class="dark-mode-switcher__toggle border"
    ></div>
  </div>
  <!-- END: Dark Mode Switcher-->
</template>

<script>
import { defineComponent, onMounted, computed } from "vue";
import { useStore } from "../../store";

export default defineComponent({
  setup() {
    const store = useStore();
    const darkMode = computed(() => store.state.main.darkMode);

    const setDarkModeClass = () => {
      darkMode.value
        ? cash("html").addClass("dark")
        : cash("html").removeClass("dark");
    };

    const switchMode = () => {
      store.dispatch("main/setDarkMode", !darkMode.value);
      setDarkModeClass();
    };

    onMounted(() => {
      setDarkModeClass();
    });

    return {
      switchMode,
      darkMode
    };
  }
});
</script>
