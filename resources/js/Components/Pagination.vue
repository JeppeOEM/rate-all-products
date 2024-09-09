<template>

<Link v-for="link in links"
        :is="link.url ? 'Link' : 'span'" />



  </template>
  
  <script setup>
import { Link, Head } from "@inertiajs/vue3";
  import { defineProps } from 'vue';
  
  const props = defineProps({
    links: Array
  });
  </script>