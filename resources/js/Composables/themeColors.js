import { updatePrimaryPalette } from "@primeuix/themes";
import { primaryColors } from "../Constants/primaryColors";

const STORAGE_KEY = 'theme_colors';

export const setPrimaryColors = (colorName) => {
    const color = primaryColors.find(c => c.name === colorName);
    if (!color) return;

    localStorage.setItem(STORAGE_KEY, JSON.stringify(color.palette));
    updatePrimaryPalette(color.palette);
};

export const getPrimaryColors = () => {
    const storedColors = localStorage.getItem(STORAGE_KEY);
    return storedColors ? JSON.parse(storedColors) : null;
};

export const initializeDefaultTheme = () => {
    const storedColors = getPrimaryColors();
    const palette = storedColors || primaryColors[0].palette;
    updatePrimaryPalette(palette);
};