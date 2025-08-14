import { updatePrimaryPalette } from "@primeuix/themes";
import { primaryColors } from "../Constants/theme-colors";

const STORAGE_KEY = 'theme_colors';

export const setPrimaryColors = (colorName) => {
    const color = primaryColors.find(c => c.name === colorName);
    if (!color) return;

    localStorage.setItem(STORAGE_KEY, JSON.stringify(color.palette));
    updatePrimaryPalette(color.palette);
};

export const getPrimaryColors = () => {
    const storedColors = localStorage.getItem(STORAGE_KEY);
    return storedColors ? JSON.parse(storedColors) : primaryColors[0];
};

export const initializeDefaultTheme = () => {
    const storedColors = getPrimaryColors();
    updatePrimaryPalette(storedColors);
};