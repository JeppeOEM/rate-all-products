<template>
    <template v-for="link in links">
        <Link
            v-if="link.url"
            :href="link.url"
            v-html="link.label"
            :class="['p-1', { 'text-lg text-blue-700 underline font-bold': link.active, 'text-lg hover:text-blue-700 ': !link.active }]"
        />
        <span class="text-lg" v-else v-html="link.label"> </span>
    </template>
</template>

<script setup>
import { Link, Head } from "@inertiajs/vue3";
import { defineProps } from "vue";

const props = defineProps({
    links: Array,
});
</script>
