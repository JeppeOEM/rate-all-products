<template>
    <Head title="All products" />

    <div>
        <div class="flex flex-row justify-between pt-4">
            <h1 class="headline p-4">All products</h1>
            <SearchBar>
                
            </SearchBar>

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
