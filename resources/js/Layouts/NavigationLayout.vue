<template>
    <Head>
        <!-- fallback title -->
        <title>Product ratings</title>
    </Head>
    <section
        class="z-10 p-5 bg-indigo-800 fixed top-0 w-full flex justify-center border-bottom border-b-2"
    >
        <header
            class="z-10 main-layout-nav flex justify-between items-center w-full max-w-screen-xl"
        >
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
                        href="/products"
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
                <NavLink href="/logout" method="post" as="button">
                    Logout
                </NavLink>
            </div>
        </header>
    </section>

    <section class="flex justify-center min-h-screen h-full bg-gray-100">
        <main class="main-content w-full max-w-screen-xl ">
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
