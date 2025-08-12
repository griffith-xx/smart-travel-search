import { updatePrimaryPalette } from "@primeuix/themes";
import { primaryColors } from "../Constants/primaryColors";

const STORAGE_KEY = 'theme_colors';

export function setPrimaryColors(colorName) {
    const color = primaryColors.find(c => c.name === colorName);
    if (color) {
        localStorage.setItem(STORAGE_KEY, JSON.stringify(color.palette));
        updatePrimaryPalette(color.palette);
    }
}

export function getPrimaryColors() {
    const storedColors = localStorage.getItem(STORAGE_KEY);
    if (storedColors) {
        return JSON.parse(storedColors);
    }
    return primaryColors[0].palette;
}

export function intilializeThemeColors() {
    const storedColors = getPrimaryColors();
    updatePrimaryPalette(storedColors);
}

export default {
    setPrimaryColors,
    getPrimaryColors,
    intilializeThemeColors
};

