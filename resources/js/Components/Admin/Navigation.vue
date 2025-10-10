<script setup>
import { Button } from "primevue";
import { useTheme } from "@/Composables/useTheme";

const { theme, setTheme } = useTheme();
</script>

<template>
    <nav
        class="bg-[var(--p-content-background)] border-b border-[var(--p-menu-border-color)] p-4 flex items-center justify-between"
    >
        <h1 class="font-extrabold text-3xl uppercase opacity-80">
            <span class="mr-1"> 🚀 </span>
            Nexus Travel
        </h1>
        <div>
            <Button
                @click="setTheme(theme === 'light' ? 'dark' : 'light')"
                severity="secondary"
                rounded
                :icon="theme === 'light' ? 'pi pi-moon' : 'pi pi-sun'"
            />
        </div>
    </nav>
</template>
