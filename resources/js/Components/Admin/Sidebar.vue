<script setup>
import { Menu } from "primevue";
import { ref } from "vue";

const items = ref([
    {
        label: "สถานที่ท่องเที่ยว",
        items: [
            {
                label: "New",
                icon: "pi pi-plus",
            },
            {
                label: "Search",
                icon: "pi pi-search",
            },
        ],
    },
    {
        label: "โปรไฟล์",
        items: [
            {
                label: "Settings",
                icon: "pi pi-cog",
            },
            {
                label: "Logout",
                icon: "pi pi-sign-out",
            },
        ],
    },
]);
</script>
<template>
    <Menu :model="items" />
</template>
