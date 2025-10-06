<script setup>
import { Button } from "primevue";
import { useTheme } from "@/Composables/useTheme";

const { theme, setTheme } = useTheme();
</script>

<template>
    <nav
        class="bg-[var(--p-content-background)] px-10 py-4 border-b border-[var(--p-menu-border-color)] flex items-center justify-between"
    >
        <h1 class="font-bold text-3xl uppercase opacity-80">
            <span class="mr-2"> 🚀 </span>
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
