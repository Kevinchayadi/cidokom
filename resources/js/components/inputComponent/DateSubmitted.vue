<template>
    <div class="flex w-[250px] ">
         <input v-model="date" class="w-2/3 text-center  border rounded-lg focus:ring focus:ring-blue-100 focus:outline-none"  type="date">
         <button class="w-1/3 bg-slate-200 border border-transparent hover:border-slate-700 transition-all duration-500  rounded-full px-3 mx-2 font-sans" type="submit">search</button>
    </div>
    </template>
<script setup>
import {  ref, watch } from 'vue';

    const props = defineProps({
        modelValue: { type: String, default: '' }

    })
    const date = ref(props.modelValue)


    const emit = defineEmits(["update:modelValue"])
    watch(date, (newval)=>{
        emit('update:modelValue', newval)
    })
    watch (()=>props.modelValue, (newval)=>{
        date.value = newval
    })
</script>
<style>
    
</style>