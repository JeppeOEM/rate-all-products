<template>
    <Head>
        <!-- fallback title -->
        <title>Product ratings</title>
    </Head>
    <section class="p-5 bg-white fixed top-0 w-full flex justify-center border-bottom border-b-2 border-grey-800">
        <header class="px-4 flex justify-between items-center w-full max-w-screen-xl">
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
                        :active="$page.component === 'Product/ProductList'"
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

    <section class="flex justify-center h-full">
        <main class="main-content w-full max-w-screen-xl border bg-slate-100">

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
