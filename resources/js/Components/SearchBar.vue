<template>

<div class="p-4 relative">
                <input
                    v-model="search"
                    type="text"
                    placeholder="Search products"
                    class="border border-black p-2 pl-10 rounded-xl focus:border-blue-500 focus:outline-none"
                />
                <img
                    src="/icons8-search.svg"
                    alt="Search Icon"
                    class="absolute left-7 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400"
                />
            </div>
</template>

<script setup>
import { ref, watch } from "vue";
import { router } from "@inertiajs/vue3";

const search = ref("");

watch(search, (value) => {
    router.get(
        "/products",
        { search: value },
        {
            preserveState: true,
            replace: true,
        }
    );
});

</script>