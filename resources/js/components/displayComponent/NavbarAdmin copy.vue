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
        {name: 'Dashboard', path: route('admin.dashboard')},
        {name: 'Hatchery', path: route('admin.hatchery')},
        {name: 'Breeding', path: route('admin.breeding')},
        {name: 'Commercial', path: route('admin.commercial')},
        {name: 'Reject', path: route('admin.afkir')},
        {name: 'Breeding Quarantine', path: route('admin.breeding.karantina')},
        {name: 'Commercial Quarantine', path: route('admin.commercial.karantina')},
        {name: 'Admin', path: route('admin.Admin')},
        {name: 'Chicken', path: route('admin.chicken')},
        {name: 'Cage', path: route('admin.kandang')},
        {name: 'Pen', path: route('admin.pen')},
        {name: 'Feed', path: route('admin.pakan')},
        {name: 'Vaccine', path: route('admin.vaksin')},
        {name: 'Vaccine schedule', path: route('admin.vaksin.schedule')},
        {name:'Logout', path: route('admin.logout')}

    ])
    const classes =
        "text-primary-text-light hover:text-primary-text-light-hover w-full";
</script>
<style >
    
</style>