<script setup>
import { Head, Link } from "@inertiajs/vue3";
</script>

<template>
    <Head title="Welcome" />
    <div class="flex flex-col">
        Hello World!
        <Link href="/login">Login</Link>
        <Link href="/register">Register</Link>
    </div>
</template>
