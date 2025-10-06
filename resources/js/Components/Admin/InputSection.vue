<script setup>
import InputError from "../InputError.vue";
defineProps({
    name: {
        type: String,
        required: true,
    },
    label: {
        type: String,
        required: true,
    },
    errorMessage: {
        type: String,
        default: "",
    },
});
</script>

<template>
    <div class="flex flex-col gap-2">
        <label class="opacity-80" :for="name">{{ label }}</label>
        <slot></slot>
        <InputError :message="errorMessage" />
    </div>
</template>
