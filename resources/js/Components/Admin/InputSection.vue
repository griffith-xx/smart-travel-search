<script setup>
import InputError from "../InputError.vue";
import { Badge } from "primevue";
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
    required: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <div class="flex flex-col gap-2">
        <label class="flex items-center gap-2" :for="name">
            <span class="opacity-80 font-medium">
                {{ label }}
            </span>
            <Badge v-if="required" severity="danger" size="small">
                Required
            </Badge>
            <Badge v-else severity="secondary" size="small">
                Optional
            </Badge>
        </label>
        <slot></slot>
        <InputError :message="errorMessage" />
    </div>
</template>