<template>
    <div class="py-4 relative">
        <input
            v-model="search"
            type="text"
            placeholder="Search products"
            class="border-2 border-black p-2 pl-10 rounded-xl focus:border-indigo-800 focus:outline-none"
        />
        <img
            src="/icons8-search.svg"
            alt="Search Icon"
            class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400"
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
