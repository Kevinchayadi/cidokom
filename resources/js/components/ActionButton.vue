<template>
    <button :class="[custom,  buttonClass]" @click="handleClick">
        {{ name }}
    </button>
</template>

<script setup>
import { ref } from 'vue';
    const props = defineProps({
        custom:{
            type:String,
            default:'bg-gradient-to-r from-sky-700 to-teal-700 hover:from-teal-600 hover:to-sky-600 '
        },
        name:{
            type:String,
            default:'Submit'
        }
        
    })
    const emit = defineEmits(['clicked'])

    const buttonClass = ref('text-white font-bold py-2 px-4 rounded-full bg-black-300 text-base')

    const handleClick = () => {
        emit('clicked')
    }

</script>