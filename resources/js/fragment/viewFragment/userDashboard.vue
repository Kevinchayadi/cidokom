<template>
    <div class=" m-4 md:h-full w-[80%] justify-center text-center align-center">
        <Headers tittle="dashboard" class="mb-10 text-primary" />
        <div :class="menuClasses" v-for="data in routes" :key="data.path">
            <Link :href="data.path" :class="classes">
            {{ data . name . toUpperCase() }}
            </Link>
        </div>
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
    import Headers from "../../components/Headers.vue";

    const props = defineProps({
        auth: Object,
    });

    const logout = () => {
        Inertia.post("/logout");
    };

    const routes = ref([{
            name: "Breeding",
            path: route("user.breeding")

        },
        {
            name: "Hatchery",
            path: route("user.hatchery")
        },
        {
            name: "Commercial",
            path: route("user.commercial")
        },
        {
            name: "other",
            path: route("user.kandangList")
        },
    ]);

    const classes =
        "text-primary-text-dark hover:text-grey-400 w-full font-extrabold p-2";

    const menuClasses =
        "hover:bg-gray-200 bordered rounded-full mt-4";
</script>

<style scoped>
    /* Tailwind active class */
    .active {
        @apply bg-gray-100 text-primary-text-light-hover font-bold;
    }
</style>
