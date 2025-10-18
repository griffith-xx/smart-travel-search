<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    destination: {
        type: Object,
        required: true,
    },
    isLiked: {
        type: Boolean,
        default: false,
    },
});

const liked = ref(props.isLiked);
const isLoading = ref(false);

const toggleLike = async (event) => {
    event.preventDefault();
    event.stopPropagation();

    if (isLoading.value) {
        return;
    }

    isLoading.value = true;
    const previousState = liked.value;
    liked.value = !liked.value;

    router.post(
        route('destinations.like.toggle', props.destination.id),
        {},
        {
            preserveScroll: true,
            onSuccess: (page) => {
                // Success handled by optimistic update
            },
            onError: (errors) => {
                // Revert on error
                liked.value = previousState;
                console.error('Failed to toggle like:', errors);
            },
            onFinish: () => {
                isLoading.value = false;
            },
        }
    );
};
</script>

<template>
    <button
        @click="toggleLike"
        :disabled="isLoading"
        class="group flex items-center justify-center rounded-full bg-white/80 p-2 shadow-md transition-all hover:scale-110 hover:bg-white disabled:cursor-not-allowed disabled:opacity-50 dark:bg-gray-800/80 dark:hover:bg-gray-800"
        :class="{
            'scale-110': liked,
        }"
        type="button"
        :aria-label="liked ? 'Unlike destination' : 'Like destination'"
    >
        <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            class="h-5 w-5 transition-all"
            :class="{
                'fill-red-500 text-red-500': liked,
                'fill-none text-gray-600 group-hover:text-red-500 dark:text-gray-300':
                    !liked,
            }"
        >
            <path
                stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"
            />
        </svg>
    </button>
</template>
