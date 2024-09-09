<template>
    <Head title="All products" />

    <h1 class="text-3xl mb-6">All products</h1>

    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div
                class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8"
            >
                <div
                    class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg"
                >
                    <article v-for="product in products.data" :key="product.id">
                        <Link
                            :href="`/products/${product.id}`"
                            class="text-indigo-600 hover:text-indigo-900"
                        >
                            <div class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div>
                                        <div
                                            class="text-sm font-medium text-gray-900"
                                        >
                                            {{ product.description }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </Link>
                    </article>
                </div>
            </div>
        </div>
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
