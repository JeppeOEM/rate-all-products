<template>
    <div>
      <Component
        :is="link.url ? 'Link' : 'span'"
        v-for="link in links"
        :key="link.label"
        :href="link.url"
        v-html="link.label"
        class="px-1"
        :class="{ 'text-gray-500': !link.url, 'font-bold': link.active }"
      />
    </div>
  </template>
  
  <script setup>
  import { defineProps } from 'vue';
  
  const props = defineProps({
    links: Array
  });
  </script>