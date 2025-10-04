<script setup>
import { Head } from "@inertiajs/vue3";
import { useFlash } from "@/Composables/useFlash";
import Toast from "primevue/toast";

defineProps({
    title: {
        type: String,
        required: true,
    },
});

useFlash();
</script>

<template>
    <div>
        <Head :title="title" />
        <Toast />
        <div>
            <slot></slot>
        </div>
    </div>
</template>
