<template >
    <nav class=" space-y-2  m-4 md:h-full align-center">

        <div v-for="data in routes" :key="data.path">
            <Link :href="data.path" :class="classes"> {{ data.name.toUpperCase() }} </Link>
        </div>

     </nav>
</template>
<script setup>
    import {
        Link
    } from "@inertiajs/vue3";
    import {
        ref
    } from "vue";
    import {
        route
    } from "ziggy-js";

    const routes = ref([
        {name: 'dashboard', path: route('admin.dashboard')},
        {name: 'hatchery', path: route('admin.hatchery')},
        {name: 'breeding', path: route('admin.breeding')},
        {name: 'commercial', path: route('admin.commercial')},
        {name:'logout', path: route('admin.logout')}

    ])
    const classes =
        "text-primary-text-light hover:text-primary-text-light-hover w-full";
</script>
<style >
    
</style>