import { updatePrimaryPalette, updateSurfacePalette } from "@primeuix/themes";
import { computed, ref } from "vue";

const appState = ref({
    primary: "emerald",
    surface: null,
    darkMode: false
});