<template>
    <Head title="All products" />

    <div class="">
        <div class="flex flex-row justify-between pt-4">
            <h1 class="text-3xl p-4">All products</h1>
            <div class="p-4 relative">
                <input
                    v-model="search"
                    type="text"
                    placeholder="Search products"
                    class="border p-2 pl-10 rounded-xl focus:border-blue-500 focus:outline-none"
                />
                <img
                    src="/icons8-search.svg"
                    alt="Search Icon"
                    class="absolute left-7 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400"
                />
            </div>
        </div>
        <div
            class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-0 p-4"
        >

        <ProductListItem
                v-for="product in products.data"
                :key="product.id"
                :product="product"
            />

        </div>
        <div class="flex flex-row justify-center items-center pb-8">
            <Pagination :links="products.links" />
        </div>
    </div>
</template>

<script setup>
import { Link, Head } from "@inertiajs/vue3";
import NavigationLayout from "@/Layouts/NavigationLayout.vue";
import Pagination from "@/Components/Pagination.vue";
import ProductListItem from "@/Pages/Product/ProductListItem.vue";
import { ref, watch } from "vue";
import { router } from "@inertiajs/vue3";
defineOptions({
    layout: NavigationLayout,
});

defineProps({ products: Object });

const search = ref("");

watch(search, (value) => {
    router.get(
        "/product-list",
        { search: value },
        {
            preserveState: true,
            replace: true,
        }
    );
});
</script>
