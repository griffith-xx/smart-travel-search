<script setup>
import { Link, router } from "@inertiajs/vue3";
import { Button } from "primevue";
import { ref, computed } from "vue";

const props = defineProps({
    destination: {
        type: Object,
        required: true,
    },
    showLikeButton: {
        type: Boolean,
        default: true,
    },
});

const isLiked = ref(props.destination.is_liked || false);
const likeCount = ref(props.destination.like_count || 0);
const isTogglingLike = ref(false);

const coverImage = computed(() => {
    return props.destination.cover_image || "/images/placeholder-destination.jpg";
});

const priceRange = computed(() => {
    if (!props.destination.price_from && !props.destination.price_to) {
        return "ฟรี";
    }

    if (props.destination.price_from && props.destination.price_to) {
        if (props.destination.price_from === props.destination.price_to) {
            return `${Number(props.destination.price_from).toLocaleString()} บาท`;
        }
        return `${Number(props.destination.price_from).toLocaleString()} - ${Number(props.destination.price_to).toLocaleString()} บาท`;
    }

    if (props.destination.price_from) {
        return `เริ่มต้น ${Number(props.destination.price_from).toLocaleString()} บาท`;
    }

    return `สูงสุด ${Number(props.destination.price_to).toLocaleString()} บาท`;
});

const toggleLike = async (event) => {
    event.preventDefault();
    event.stopPropagation();

    if (isTogglingLike.value) return;

    isTogglingLike.value = true;
    const previousLiked = isLiked.value;
    const previousCount = likeCount.value;

    // Optimistic update
    isLiked.value = !isLiked.value;
    likeCount.value = isLiked.value ? likeCount.value + 1 : likeCount.value - 1;

    try {
        router.post(
            route("destinations.like.toggle", props.destination.id),
            {},
            {
                preserveScroll: true,
                onError: () => {
                    // Revert on error
                    isLiked.value = previousLiked;
                    likeCount.value = previousCount;
                },
                onFinish: () => {
                    isTogglingLike.value = false;
                },
            }
        );
    } catch (error) {
        // Revert on error
        isLiked.value = previousLiked;
        likeCount.value = previousCount;
        isTogglingLike.value = false;
    }
};
</script>

<template>
    <Link
        :href="route('destinations.show', destination.slug)"
        class="group block bg-[var(--p-content-background)] rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 border border-surface-300 dark:border-surface-700 hover:border-[var(--p-primary-color)]/30"
    >
        <!-- Image Container -->
        <div class="relative overflow-hidden aspect-[4/3]">
            <img
                :src="coverImage"
                :alt="destination.name"
                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                loading="lazy"
            />

            <!-- Overlay Gradient -->
            <div
                class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/0 to-black/20"
            ></div>

            <!-- Featured Badge -->
            <div
                v-if="destination.is_featured"
                class="absolute top-3 left-3 bg-yellow-500 text-white px-3 py-1 rounded-full text-xs font-semibold flex items-center gap-1"
            >
                <i class="pi pi-star-fill text-[10px]"></i>
                <span>แนะนำ</span>
            </div>

            <!-- Like Button -->
            <div
                v-if="showLikeButton"
                class="absolute top-3 right-3"
                @click.prevent.stop
            >
                <Button
                    @click="toggleLike"
                    :disabled="isTogglingLike"
                    rounded
                    :severity="isLiked ? 'danger' : 'secondary'"
                    :class="{
                        'bg-white/90 hover:bg-white': !isLiked,
                        'animate-pulse': isTogglingLike,
                    }"
                    class="backdrop-blur-sm"
                >
                    <i
                        :class="
                            isLiked
                                ? 'pi pi-heart-fill text-red-500'
                                : 'pi pi-heart'
                        "
                    ></i>
                </Button>
            </div>

            <!-- Rating Badge -->
            <div
                v-if="destination.average_rating"
                class="absolute bottom-3 left-3 bg-white/95 backdrop-blur-sm px-2.5 py-1.5 rounded-lg flex items-center gap-1.5"
            >
                <i class="pi pi-star-fill text-yellow-500 text-xs"></i>
                <span class="font-semibold text-sm text-gray-900">
                    {{ Number(destination.average_rating).toFixed(1) }}
                </span>
                <span class="text-xs text-gray-500">
                    ({{ destination.total_reviews || 0 }})
                </span>
            </div>
        </div>

        <!-- Content -->
        <div class="p-4">
            <!-- Title -->
            <h3
                class="font-semibold text-lg mb-2 line-clamp-2 group-hover:text-[var(--p-primary-color)] transition-colors"
            >
                {{ destination.name }}
            </h3>

            <!-- Short Description -->
            <p
                v-if="destination.short_description"
                class="text-sm opacity-70 mb-3 line-clamp-2"
            >
                {{ destination.short_description }}
            </p>

            <!-- Location -->
            <div class="flex items-center gap-1.5 text-sm opacity-60 mb-3">
                <i class="pi pi-map-marker text-xs"></i>
                <span>
                    {{ destination.province?.name_th || "ไม่ระบุจังหวัด" }}
                </span>
            </div>

            <!-- Category Badge -->
            <div class="flex items-center gap-2 mb-3">
                <span
                    class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-[var(--p-primary-color)]/10 text-[var(--p-primary-color)] rounded-full text-xs font-medium"
                >
                    <i class="pi pi-tag text-[10px]"></i>
                    {{ destination.category?.name || "ทั่วไป" }}
                </span>
            </div>

            <!-- Features Icons -->
            <div class="flex items-center gap-3 mb-3 text-xs opacity-60">
                <div
                    v-if="destination.has_parking"
                    class="flex items-center gap-1"
                    v-tooltip.bottom="'มีที่จอดรถ'"
                >
                    <i class="pi pi-car"></i>
                </div>
                <div
                    v-if="destination.has_wifi"
                    class="flex items-center gap-1"
                    v-tooltip.bottom="'มี WiFi'"
                >
                    <i class="pi pi-wifi"></i>
                </div>
                <div
                    v-if="destination.has_restaurant"
                    class="flex items-center gap-1"
                    v-tooltip.bottom="'มีร้านอาหาร'"
                >
                    <i class="pi pi-shopping-bag"></i>
                </div>
                <div
                    v-if="destination.pet_friendly"
                    class="flex items-center gap-1"
                    v-tooltip.bottom="'สัตว์เลี้ยงเข้าได้'"
                >
                    <i class="pi pi-heart"></i>
                </div>
            </div>

            <!-- Footer -->
            <div class="flex items-center justify-between pt-3 border-t border-surface-300 dark:border-surface-700">
                <!-- Price -->
                <div class="flex flex-col">
                    <span class="text-xs opacity-60">ค่าใช้จ่าย</span>
                    <span class="font-semibold text-sm text-[var(--p-primary-color)]">
                        {{ priceRange }}
                    </span>
                </div>

                <!-- Stats -->
                <div class="flex items-center gap-3 text-xs opacity-60">
                    <div class="flex items-center gap-1" v-tooltip.bottom="'ยอดดู'">
                        <i class="pi pi-eye"></i>
                        <span>{{ (destination.view_count || 0).toLocaleString() }}</span>
                    </div>
                    <div class="flex items-center gap-1" v-tooltip.bottom="'ถูกใจ'">
                        <i class="pi pi-heart"></i>
                        <span>{{ likeCount.toLocaleString() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </Link>
</template>
