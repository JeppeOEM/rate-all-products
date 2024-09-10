<template>
    <Head title="All products" />

    <h1 class="text-3xl mb-6">All products</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-0 p-4">
        <article v-for="product in products.data" :key="product.id" class="bg-white overflow-hidden outline outline-1 outline-gray-300 outline-offset-[-1px] flex flex-col justify-between">
            <Link :href="`/products/${product.id}`" class="flex-grow flex flex-col justify-between">
                <img class="w-full h-48 object-cover" :src="product.image_url || 'https://via.placeholder.com/300'" alt="Product Image">
                <div class="p-4 flex flex-col flex-grow justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">{{ product.title }}</h2>
                        <p class="text-gray-600 mt-2">{{ product.description }}</p>
                    </div>
                    <div class="flex items-center justify-between mt-4">
                        <span class="text-gray-800 font-bold text-lg">${{ product.price }}</span>

                    </div>
                </div>
            </Link>
        </article>
    </div>

    <Pagination :links="products.links" class="mt-6" />
</template>

<script setup>
import { Link, Head } from "@inertiajs/vue3";
import NavigationLayout from "@/Layouts/NavigationLayout.vue";
import Pagination from "@/Components/Pagination.vue";

defineOptions({
    layout: NavigationLayout,
});

defineProps({ products: Object });
</script>