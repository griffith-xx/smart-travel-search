<script setup>
import { Head, Link } from "@inertiajs/vue3";
</script>

<template>
    <Head title="Welcome" />
    <div class="flex flex-col gap-3 p-10">
        Hello World!
        <Link class="underline text-blue-600" :href="route('login')">Login</Link>
        <Link class="underline text-blue-600" :href="route('register')">Register</Link>
        <Link class="underline text-blue-600" :href="route('admin.login')">Login Admin</Link>
    </div>
</template>
