<template lang="">
    <h1 class="text-center font-bold text-primary  lg:text-4xl text-2xl mb-2">{{ tittle.toUpperCase() }}</h1>
</template>
<script setup>
    const props = defineProps({
        tittle : {
            type: String,
            required: true
        }
    })
</script>
<style lang="">
    
</style>