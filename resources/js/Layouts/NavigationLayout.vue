<template>
    <Head>
        <!-- fallback title -->
        <title>Product ratings</title>
    </Head>
    <section class="p-6 bg-gray-200 fixed top-0      w-full flex items-center">
        <header class="flex justify-between items-center">
            <div class="flex items-center">
                <nav class="flex space-x-4">
                    <NavLink
                        v-if="user"
                        href="/"
                        :active="$page.component === 'Home'"
                    >
                        Home
                    </NavLink>
                    <NavLink
                        v-if="user"
                        href="/product-list"
                        :active="$page.component === 'ProductList/Index'"
                    >
                        Products
                    </NavLink>
                    <NavLink
                        v-if="!user"
                        href="/register"
                        :active="$page.component === 'Auth/Create'"
                    >
                        Register
                    </NavLink>
                    <NavLink
                        v-if="!user"
                        href="/login"
                        :active="$page.component === 'Auth/Login'"
                    >
                        Login
                    </NavLink>
                </nav>
            </div>
            <div v-if="user" class="ml-auto">
                <NavLink
                    href="/logout"
                    method="post"
                    as="button"
                >
                    Logout
                </NavLink>
            </div>
        </header>
    </section>

    <section class="p-6">
        <main class="mx-auto">
            <slot />
        </main>
    </section>
</template>

<script setup>
import { computed } from "vue";
import NavLink from "../Components/NavLink.vue";
import { Head, usePage } from "@inertiajs/vue3";

const props = defineProps({
    auth: {
        type: Object,
        required: true,
    },
});

const user = computed(() => props.auth.user);
</script>
