<template >
    <div class=" flex flex-col justify-center items-center md:h-screen ">
        <div class="flex justify-center items-center mb-2" >
            <img src="../../../../public/img/logo.png" alt="" class="w-60">
    
        </div>
        <nav class=" space-y-2  m-2 md:h-full align-center items-start ">
    
            <div v-for="data in routes" :key="data.path">
                <Link :href="data.path" :class="classes"> {{ data.name.toUpperCase() }} </Link>
            </div>
    
         </nav>

    </div>
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
        {name: 'afkir', path: route('admin.afkir')},
        {name: 'chicken', path: route('admin.chicken')},
        {name: 'kandang', path: route('admin.kandang')},
        {name: 'pen', path: route('admin.pen')},
        {name: 'pakan', path: route('admin.pakan')},
        {name:'logout', path: route('admin.logout')}

    ])
    const classes =
        "text-primary-text-light hover:text-primary-text-light-hover w-full";
</script>
<style >
    
</style>