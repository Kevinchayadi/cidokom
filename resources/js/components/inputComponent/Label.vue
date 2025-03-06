<template >

    <label :class="label === 'white' ? classes1 : classes2" :for="name">{{ computedContent.toUpperCase() }} :</label>
</template>
<script setup>
    import { computed, ref } from 'vue';

    const classes1 = ref('no-underline font-semibold text-xs text-white md:text-xl ml-2')
    const classes2 = ref('no-underline font-semibold text-xs  md:text-xl ml-2')
    const props = defineProps({
        name: {
            type: String,
            required: true
        },
        content:{
            type: String,
        },
        label:{
            type: String,
            default: 'white',
        }
    })
    const computedContent = computed(() => {
    return props.content || props.name;
});
</script>
<style lang="">
    
</style>