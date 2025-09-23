<script setup>
defineProps({
    'recommendedDestinations': Object,
})
</script>

<template>
    <pre>
        {{ recommendedDestinations }}
    </pre>
</template>
