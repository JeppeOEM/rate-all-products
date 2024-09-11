<template>
    <article
        class="hover-highlight bg-white custom-border flex flex-col justify-between"
    >
        <Link
            :href="`/products/${product.id}`"
            class="flex-grow flex flex-col justify-between"
        >
            <img
                class="w-full h-48 object-cover rounded-t-xl"
                :src="product.image_url || 'https://via.placeholder.com/300'"
                alt="Product Image"
            />
            <div class="p-4 flex flex-col flex-grow justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">
                        {{ product.title }}
                    </h2>
                    <p class="text-gray-600 mt-2">
                        {{ product.description }}
                    </p>
                </div>
                <div class="flex items-center justify-between mt-4">
                    <span class="text-gray-800 font-bold text-lg">
                        {{ product.price }}
                        <span class="text-grey-400">kr</span>
                    </span>
                </div>
            </div>
        </Link>
    </article>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import { defineProps } from 'vue';

const props = defineProps({
    product: Object,
});
</script>