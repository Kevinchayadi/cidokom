<template>
    <div class=" flex flex-col mt-10  h-screen ">
        <div class="flex justify-center items-center mb-2" >
            <img src="../../../../public/img/logo.png" alt="" class="w-60">
    
        </div>
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
    </div>
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
            name: "Dashboard",
            path: route("user.dashboard")
        },
        {
            name: "Chicken",
            path: route("user.ayamList")
        },
        {
            name: "Farm",
            path: route("user.kandangList")
        },
        {
            name: "Pen",
            path: route("user.penList")
        },
        {
            name: "Feed",
            path: route("user.pakan")
        },
        {
            name: "Machine",
            path: route("user.machine")
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
