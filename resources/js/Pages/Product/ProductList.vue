<template>
    <Head title="All products" />

    <div class="main-layout-padding">
        <div class="flex flex-col sm:flex-row justify-between">
            <h1 class="headline py-4">All products</h1>
            <SearchBar> </SearchBar>
        </div>
        <div
            class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3"
        >
            <ProductListItem
                v-for="product in products.data"
                :key="product.id"
                :product="product"
            />
        </div>
        <div class="flex flex-row justify-center items-center py-8">
            <Pagination :links="products.links" />
        </div>
    </div>
</template>

<script setup>
import { Head } from "@inertiajs/vue3";
import NavigationLayout from "@/Layouts/NavigationLayout.vue";
import Pagination from "@/Components/Pagination.vue";
import SearchBar from "@/Components/SearchBar.vue";
import ProductListItem from "@/Pages/Product/ProductListItem.vue";
defineOptions({
    layout: NavigationLayout,
});

defineProps({ products: Object });
</script>
