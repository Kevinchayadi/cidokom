<template >
    <nav class=" space-y-2  m-4 md:h-full align-center">

        <div v-for="data in routes" :key="data.path">
            <Link :href="route.path"> {{ data.name.toUpperCase() }} </Link>
        </div>

     </nav>
</template>
<script setup>
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

    const routes = ref([
        {name: dashboard, path: route('user.dashboard')}
    ])
</script>
<style >
    
</style>