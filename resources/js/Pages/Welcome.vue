<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { setPrimaryColors } from "@/Composables/themeManager";
import Button from "primevue/button";
import { primaryColors } from "@/Constants/theme-colors";
</script>

<template>
    <GuestLayout title="Welcone">
        <div class="container">
            <h1 class="text-4xl font-bold mb-4">Welcome to our website!</h1>
            <p>
                This is a simple website created using Vue.js and Tailwind CSS.
            </p>
            <p>
                Feel free to explore the content and contact us if you have any
                questions.
            </p>

            <div class="flex flex-col w-fit gap-4">
                <Button
                    v-for="color in primaryColors"
                    :label="color.name"
                    @click="setPrimaryColors(color.name)"
                    class="!border-none"
                    :style="{ backgroundColor: color.palette['500'] }"
                />
            </div>
        </div>
    </GuestLayout>
</template>
