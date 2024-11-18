<template>
    
    <nav class="space-y-2 m-4  align-center">
        <div v-if="auth">
            <h1>{{ auth . user . username }}</h1>
        </div>
        <div v-for="data in routes" :key="data.path">
            <Link :href="data.path" :class="classes">
            {{ data . name . toUpperCase() }}
            </Link>
        </div>
        <div v-if="auth">
            <Link href="#" :class="classes" @click.prevent="logout">Logout</Link>
        </div>
    </nav>
</template>

<script setup>
    import {
        Inertia
    } from "@inertiajs/inertia";
    import {
        Link
    } from "@inertiajs/vue3";
    import {
        ref
    } from "vue";
    import {
        route
    } from "ziggy-js";

    const props = defineProps({
        auth: Object,
    });

    const logout = () => {
        Inertia.post("/logout");
    };

    const routes = ref([{
            name: "dashboard",
            path: route("user.dashboard")
        },
        {
            name: "Chicken",
            path: route("user.ayamList")
        },
        {
            name: "farm",
            path: route("user.kandangList")
        },
        {
            name: "Pen",
            path: route("user.penList")
        },
        {
            name: "pakan",
            path: route("user.pakan")
        },
        {
            name: "Logout",
            path: route("user.logout")
        },
        

    ]);

    const classes =
        "text-primary-text-light hover:text-primary-text-light-hover w-full";
</script>

<style scoped>
    /* Tailwind active class */
    .active {
        @apply bg-gray-100 text-primary-text-light-hover font-bold;
    }
</style>
