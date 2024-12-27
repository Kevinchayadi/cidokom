<template >

    <label :class="classes" :for="name">{{ computedContent.toUpperCase() }} :</label>
</template>
<script setup>
    import { computed, ref } from 'vue';

    const classes = ref('no-underline font-semibold text-xs text-white md:text-xl ml-2')
    const props = defineProps({
        name: {
            type: String,
            required: true
        },
        content:{
            type: String,
        }
    })
    const computedContent = computed(() => {
    return props.content || props.name;
});
</script>
<style lang="">
    
</style>