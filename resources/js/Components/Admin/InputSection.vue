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
        default: "",
    },
    errorMessage: {
        type: String,
        default: "",
    },
    noLabel: {
        type: Boolean,
        default: false,
    },
    required: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <div class="flex flex-col gap-2">
        <label v-if="!noLabel" class="flex items-center gap-2" :for="name">
            <slot name="image"> </slot>
            <span class="opacity-80 font-medium">
                {{ label }}
            </span>
            <Badge v-if="required" severity="danger" size="small">
                Required
            </Badge>
            <Badge v-else severity="secondary" size="small"> Optional </Badge>
        </label>
        <slot></slot>
        <InputError :message="errorMessage" />
    </div>
</template>
