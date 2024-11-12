<template>
    <button :class="[background,  buttonClass, custom] ":disabled="disabled" type="submit">
        {{ name }}
    </button>
</template>

<script setup>
import { ref } from 'vue';
    const props = defineProps({
        background:{
            type:String,
            default:'bg-gradient-to-r from-sky-700 to-teal-700 hover:from-teal-600 hover:to-sky-600 '
        },
        name:{
            type:String,
            default:'Submit'
        },
        custom:{
            type:String,
            default:''
        },
        disabled:{
            type:Boolean,
            default:false
        }
    })
    const buttonClass = ref('text-white font-bold py-2 px-4 rounded-full bg-black-300 text-2xl my-2')

</script>