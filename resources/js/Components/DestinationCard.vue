<script setup>
import Heart from "@/Components/Heart.vue";
import { Link, usePage } from "@inertiajs/vue3";
import { Card } from "primevue";
import { computed } from "vue";

const props = defineProps({
    destination: {
        type: Object,
        required: true,
    },
});

const page = usePage();
const user = computed(() => page.props.auth?.user);
const userLikedDestinations = computed(
    () => page.props.auth?.user?.liked_destinations || []
);

const isLiked = computed(() => {
    return userLikedDestinations.value.includes(props.destination.id);
});
</script>

<template>
    <div class="relative">
        <Link
            :href="route('destinations.show', destination.slug)"
            class="block transition-transform hover:scale-[1.02]"
        >
            <Card class="overflow-hidden">
                <template #header>
                    <div class="relative">
                        <img
                            class="h-48 w-full object-cover"
                            :src="destination.cover_image"
                            :alt="destination.name"
                        />
                        <div class="absolute right-2 top-2">
                            <Heart
                                v-if="user"
                                :destination="destination"
                                :is-liked="isLiked"
                            />
                        </div>

                        <!-- Category Badge -->
                        <div
                            v-if="destination.category"
                            class="absolute bottom-2 left-2"
                        >
                            <span
                                class="rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-gray-800 shadow-md dark:bg-gray-800/90 dark:text-white"
                            >
                                {{ destination.category.name }}
                            </span>
                        </div>
                    </div>
                </template>

                <template #title>
                    <h3
                        class="line-clamp-1 text-lg font-bold text-gray-900 dark:text-white"
                    >
                        {{ destination.name }}
                    </h3>
                </template>

                <template #subtitle>
                    <div class="flex items-center gap-1 text-gray-600 dark:text-gray-400">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                            />
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                            />
                        </svg>
                        <span class="text-sm">
                            {{ destination.province.name }}
                        </span>
                    </div>
                </template>

                <template #content>
                    <p class="m-0 line-clamp-2 text-sm text-gray-700 dark:text-gray-300">
                        {{ destination.short_description }}
                    </p>

                    <!-- Rating & Stats -->
                    <div
                        v-if="
                            destination.average_rating ||
                            destination.favorite_count
                        "
                        class="mt-3 flex items-center gap-4 text-xs text-gray-600 dark:text-gray-400"
                    >
                        <div
                            v-if="destination.average_rating"
                            class="flex items-center gap-1"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4 text-yellow-500"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                                />
                            </svg>
                            <span class="font-semibold">
                                {{ destination.average_rating }}
                            </span>
                        </div>

                        <div
                            v-if="destination.favorite_count > 0"
                            class="flex items-center gap-1"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4 text-red-500"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            <span>{{ destination.favorite_count }}</span>
                        </div>
                    </div>

                    <!-- Price Range -->
                    <div
                        v-if="destination.price_from"
                        class="mt-2 text-sm font-semibold text-blue-600 dark:text-blue-400"
                    >
                        ฿{{ destination.price_from.toLocaleString() }}
                        <span v-if="destination.price_to">
                            - ฿{{ destination.price_to.toLocaleString() }}
                        </span>
                    </div>
                </template>
            </Card>
        </Link>
    </div>
</template>
