<script setup>
import { Menu } from "primevue";
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";

const navigations = ref([
    {
        label: "หน้าแรก",
        icon: "pi pi-home",
        route: "admin.dashboard",
    },
    {
        label: "จังหวัด",
        icon: "pi pi-map",
        route: "admin.provinces.index",
    },
]);
</script>
<template>
    <Menu class="h-fit" :model="navigations">
        <template #item="{ item, props }">
            <Link
                v-bind="props.action"
                :href="route(item.route)"
                :class="{
                    'text-primary!': route().current(item.route),
                }"
                class="flex items-center"
            >
                <span :class="item.icon" />
                <span>{{ item.label }}</span>
            </Link>
        </template>
    </Menu>
</template>
