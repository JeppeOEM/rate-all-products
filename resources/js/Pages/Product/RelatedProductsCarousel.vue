<template>
    <div class="custom-border relative bg-blue-800 p-6 rounded-lg">
        <h2 class="text-2xl font-bold text-white mb-4">Related Products</h2>
        <div class="relative overflow-hidden">
            <button
                @click="scrollLeft"
                class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-gray-700 text-white w-12 h-12 rounded-full opacity-75 hover:opacity-100 transition-opacity z-20 flex items-center justify-center text-2xl font-bold"
            >
                &larr;
            </button>

            <div
                class="flex overflow-x-auto snap-x snap-mandatory"
                ref="carousel"
            >
                <div class="flex">
                    <div
                        v-for="relatedProduct in relatedProducts"
                        :key="relatedProduct.id"
                        class="flex-none w-72 snap-start mr-4"
                    >
                        <ProductListItem :product="relatedProduct" />
                    </div>
                </div>
            </div>
            <button
                @click="scrollRight"
                class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-gray-700 text-white w-12 h-12 rounded-full opacity-75 hover:opacity-100 transition-opacity z-20 flex items-center justify-center text-2xl font-bold"
            >
                &rarr;
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { defineProps } from "vue";
import ProductListItem from "./ProductListItem.vue"; // Adjust the path as necessary

const props = defineProps({
    relatedProducts: Array,
});

const carousel = ref(null);

const scrollLeft = () => {
    if (carousel.value) {
        carousel.value.scrollBy({ left: -300, behavior: "smooth" });
    }
};

const scrollRight = () => {
    if (carousel.value) {
        carousel.value.scrollBy({ left: 300, behavior: "smooth" });
    }
};
</script>

