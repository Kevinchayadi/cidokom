<template >

    <label :class="classes" :for="name">{{ name.toUpperCase() }} :</label>
</template>
<script setup>
    import { ref } from 'vue';

    const classes = ref('no-underline font-semibold text-xs ml-2')
    const props = defineProps({
        name: {
            type: String,
            required: true
        }
    })
    
</script>
<style lang="">
    
</style>